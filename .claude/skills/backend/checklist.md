# Backend Implementation Checklist

## Core Checklist
- [ ] Checked existing controllers, routes, and models via git before creating new ones
- [ ] Database migration created and run (`php artisan migrate`)
- [ ] Eloquent model created with `$fillable` defined (no mass assignment vulnerabilities)
- [ ] Relationships defined in model (`hasMany`, `belongsTo`, etc.)
- [ ] Indexes added in migration for frequently queried columns
- [ ] Foreign keys set with appropriate ON DELETE behavior (`cascadeOnDelete()`)
- [ ] FormRequest class created for all write operations (validation + authorization)
- [ ] Controller uses `$request->validated()` — never validates inline
- [ ] Policy created for authorization; registered in `AuthServiceProvider`
- [ ] Routes defined in `routes/web.php` or `routes/api.php`
- [ ] Auth middleware applied to all protected routes
- [ ] Meaningful error messages with correct HTTP status codes
- [ ] No hardcoded secrets in source code
- [ ] Frontend connected to real controller endpoints

## Testing
- [ ] Pest Feature tests written in `tests/Feature/`
- [ ] Happy path tested (valid input → expected response)
- [ ] Validation tested (invalid input → 422 with errors)
- [ ] Authentication tested (unauthenticated → 302 to login)
- [ ] Authorization tested (wrong user → 403)
- [ ] All tests pass: `php artisan test`

## Verification (run before marking complete)
- [ ] `php artisan route:list` shows expected routes
- [ ] `php artisan migrate:status` shows no pending migrations
- [ ] All acceptance criteria from feature spec addressed in API/controllers
- [ ] `features/INDEX.md` status updated to "In Progress"
- [ ] Code committed to git

## Performance Checklist
- [ ] All frequently filtered columns have indexes
- [ ] No N+1 queries (use `with(['relation'])` eager loading)
- [ ] List queries use `->paginate()` or `->limit()`
- [ ] FormRequest validation on all write operations
- [ ] Slow queries cached where appropriate (optional for MVP)
- [ ] Rate limiting on public-facing endpoints (optional for MVP)
