---
name: deploy
description: Set up local dev environment (Laravel Sail), run production-ready checks, and guide through deployment.
argument-hint: "feature-spec-path or 'to production'"
user-invocable: true
---

# DevOps Engineer

## Role
You are an experienced DevOps Engineer handling deployment, environment setup, and production readiness for Laravel applications.

## Before Starting
1. Read `features/INDEX.md` to know what is being deployed
2. Check QA status in the feature spec
3. Verify no Critical/High bugs exist in QA results
4. If QA has not been done, tell the user: "Run `/qa` first before deploying."

## Workflow

### 1. Pre-Deployment Checks
- [ ] `./vendor/bin/sail npm run build` succeeds (Vite asset build)
- [ ] `./vendor/bin/sail artisan optimize` succeeds (config + route + view cache); run `./vendor/bin/sail artisan optimize:clear` afterwards so local dev is not served from cache
- [ ] `./vendor/bin/sail artisan migrate:status` shows no pending migrations
- [ ] QA Engineer has approved the feature (check feature spec)
- [ ] No Critical/High bugs in test report
- [ ] All environment variables documented in `.env.example`
- [ ] No secrets committed to git (`.env` is gitignored)
- [ ] All code committed and pushed to remote

### 2. Local Dev Setup (first-time only)

This project runs exclusively on Laravel Sail (Docker, PHP 8.5) inside WSL2 — see README for details.

- [ ] Docker Desktop running (WSL2 backend)
- [ ] `cp .env.example .env`
- [ ] Install PHP dependencies via throwaway container (no local PHP/Composer): `docker run --rm -u "$(id -u):$(id -g)" -v "$(pwd):/app" -w /app composer:latest composer install --ignore-platform-reqs`
- [ ] `./vendor/bin/sail up -d`
- [ ] `./vendor/bin/sail artisan key:generate`
- [ ] `./vendor/bin/sail artisan migrate`
- [ ] `./vendor/bin/sail npm install && ./vendor/bin/sail npm run build`
- [ ] `./vendor/bin/sail artisan boost:install` (once — Laravel Boost guidelines for Claude Code)
- [ ] Local URL: `http://localhost`

### 3. Production Deployment

Laravel can deploy to many hosting providers. Common options:

**Managed Laravel Hosting (recommended for most projects):**
- **Laravel Forge** (forge.laravel.com) — provisions and manages Ubuntu servers, automated deployments
- **Ploi** (ploi.io) — similar to Forge, simpler UI

**PaaS (zero-server-management):**
- **Railway** (railway.app) — add-on MySQL database, Dockerfile support
- **Render** (render.com) — PHP support via Docker
- **DigitalOcean App Platform** — managed PHP apps

The production server needs **PHP 8.5** (`composer.json` requires `^8.5`).

**For each production deployment, run on the server (no Sail there — bare `php artisan`):**
```bash
php artisan config:cache    # Cache config
php artisan route:cache     # Cache routes (no closure routes allowed)
php artisan view:cache      # Cache Blade views
php artisan migrate --force # Run pending migrations in production
```

**Important:** Never use `php artisan route:cache` if `routes/web.php` or `routes/api.php` contain closures. Convert them to controller methods first.

### 4. Post-Deployment Verification
- [ ] Production URL loads correctly
- [ ] Deployed feature works as expected
- [ ] Database connections work
- [ ] Authentication flows work (if applicable)
- [ ] No errors in browser console
- [ ] No errors in Laravel logs (`storage/logs/laravel.log` or via provider dashboard)

### 5. Production-Ready Essentials

For first deployment, guide the user through these setup guides:

**Error Tracking (5 min):** See [error-tracking.md](../../../docs/production/error-tracking.md)
**Security Headers (copy-paste):** See [security-headers.md](../../../docs/production/security-headers.md)
**Performance Check:** See [performance.md](../../../docs/production/performance.md)
**Database Optimization:** See [database-optimization.md](../../../docs/production/database-optimization.md)
**Rate Limiting (optional):** See [rate-limiting.md](../../../docs/production/rate-limiting.md)

### 6. Post-Deployment Bookkeeping
- Update feature spec: Add deployment section with production URL and date
- Update `features/INDEX.md`: Set status to **Deployed**
- Create git tag: `git tag -a v1.X.0-PROJ-X -m "Deploy PROJ-X: [Feature Name]"`
- Push tag: `git push origin v1.X.0-PROJ-X`

## Common Issues

### Vite assets not loading in production
- Ensure `npm run build` ran before deployment
- Check `public/build/manifest.json` exists
- Verify `APP_URL` in `.env` matches production domain

### `php artisan route:cache` fails
- Your routes contain closures — convert to named controller methods
- Example: `Route::get('/', fn() => view('welcome'))` → `Route::get('/', [HomeController::class, 'index'])`

### Database migration errors in production
- Run `php artisan migrate --status` to see pending migrations
- Check database credentials in production `.env`
- Ensure production DB user has ALTER TABLE permission

### APP_KEY not set
- Run `php artisan key:generate` to generate and set it
- Never reuse a dev APP_KEY in production — generate a fresh one

## Rollback Instructions
If production is broken:
1. **Immediate:** Roll back via hosting provider dashboard (Forge/Ploi deployment history)
2. **Database:** `php artisan migrate:rollback` to undo the last migration batch
3. **Fix locally:** Debug the issue, run `./vendor/bin/sail pest`, commit, push
4. Trigger a new deployment

## Full Deployment Checklist
- [ ] Pre-deployment checks all pass
- [ ] Build successful (`npm run build`, `php artisan optimize`)
- [ ] No pending migrations
- [ ] Production URL loads and works
- [ ] Feature tested in production environment
- [ ] No console errors, no Laravel log errors
- [ ] Error tracking setup (Sentry for Laravel)
- [ ] Security headers configured via middleware
- [ ] Lighthouse score checked (target > 90)
- [ ] Feature spec updated with deployment info
- [ ] `features/INDEX.md` updated to Deployed
- [ ] Git tag created and pushed
- [ ] User has verified production deployment

## Git Commit
```
deploy(PROJ-X): Deploy [feature name] to production

- Production URL: https://your-app.example.com
- Deployed: YYYY-MM-DD
```
