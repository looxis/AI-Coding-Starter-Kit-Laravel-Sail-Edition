# AI Coding Starter Kit

> A Laravel template with an AI-powered development workflow using specialized skills for Requirements, Architecture, Frontend, Backend, QA, and Deployment.

## Tech Stack

| Category | Tool | Why? |
|----------|------|------|
| **Framework** | Laravel (PHP) | Full-stack MVC, batteries included |
| **Templating** | Blade | Server-side templating with reusable component system |
| **Styling** | Tailwind CSS v3 | Utility-first CSS |
| **JS Framework** | Alpine.js | Lightweight reactive behavior in Blade templates |
| **Database** | MySQL | Relational database, managed by Eloquent ORM |
| **Validation** | Laravel Form Requests | Request validation + authorization in one class |
| **Testing** | Laravel Pest | Expressive PHP testing framework |
| **Local Dev** | Laravel Herd or Laravel Sail (Docker) | Native (Herd) or Docker (Sail) |

## Project Structure

```
app/
  Http/
    Controllers/      # MVC Controllers
    Requests/         # Form Request classes (validation + authorization)
    Middleware/        # Laravel Middleware
  Models/             # Eloquent Models
  Policies/           # Authorization Policies
  Providers/          # Service Providers (AuthServiceProvider, etc.)
resources/
  views/              # Blade templates
    layouts/          # Master layouts
    components/       # Reusable Blade components (<x-name>)
  js/                 # Alpine.js files
  css/                # Tailwind CSS entry point
  lang/               # Translations
routes/
  web.php             # Web routes (return Blade views)
  api.php             # API routes (return JSON)
database/
  migrations/         # DB schema migrations
  factories/          # Model factories (for tests/seeders)
  seeders/            # DB seeders
tests/
  Feature/            # Pest feature tests (HTTP layer tests)
  Unit/               # Pest unit tests (isolated logic)
config/               # Laravel config files
storage/              # Logs, cache, file uploads
.env.example          # Environment variable template
docker-compose.yml    # Laravel Sail config (if using Docker)
```

## Development Workflow

1. `/init` — Initialize the project: PRD + feature map (run once at the start)
2. `/write-spec` — Create a full feature spec for one feature
3. `/architecture` — Design tech architecture (PM-friendly, no code)
4. `/frontend` — Build UI with Blade templates and Alpine.js
5. `/backend` — Build controllers, Eloquent models, migrations, Form Requests
6. `/qa` — Test against acceptance criteria + security audit + Pest tests
7. `/deploy` — Set up Herd/Sail locally, production-ready checks

Use `/refine PROJ-X` at any point to revisit and improve an existing feature spec.

## Feature Tracking

All features tracked in `features/INDEX.md`. Every skill reads it at start and updates it when done. Feature specs live in `features/PROJ-X-name.md`.

## Key Conventions

- **Feature IDs:** PROJ-1, PROJ-2, etc. (sequential)
- **Commits:** `feat(PROJ-X): description`, `fix(PROJ-X): description`
- **Single Responsibility:** One feature per spec file
- **Blade components first:** check `resources/views/components/` before creating new ones. Reuse via `<x-component-name>`.
- **Form Requests for all validation:** NEVER validate in controllers directly
- **`$fillable` on every model:** prevents mass assignment vulnerabilities
- **Human-in-the-loop:** All workflows have user approval checkpoints
- **Pest tests:** Feature tests in `tests/Feature/` (HTTP layer), Unit tests in `tests/Unit/`

## Build & Test Commands

```bash
# Development
php artisan serve          # Dev server (localhost:8000)
php artisan migrate        # Run pending migrations
php artisan make:model X -mf  # Create model, migration, factory
php artisan make:request StoreXRequest  # Create Form Request
php artisan make:policy XPolicy --model=X  # Create Policy
php artisan route:list     # Show all registered routes

# Testing
php artisan test           # Run all Pest tests
./vendor/bin/pest          # Run Pest directly
./vendor/bin/pest --filter=FeatureName  # Run specific test

# Assets
npm run dev                # Vite asset dev server
npm run build              # Production asset build

# With Laravel Sail (Docker)
./vendor/bin/sail up -d
./vendor/bin/sail artisan migrate
./vendor/bin/sail npm run dev
```

## Product Context

@docs/PRD.md

## Feature Overview

@features/INDEX.md
