---
paths:
  - "app/Http/**"
  - "routes/**"
  - "config/**"
  - ".env.example"
---

# Security Rules

## Secrets Management
- NEVER commit secrets, API keys, or credentials to git
- Use `.env` for all environment-specific values (already gitignored by Laravel)
- Access env vars via `config()` helper in application code, not `env()` directly
- Document ALL required env vars in `.env.example` with dummy/placeholder values
- There is NO `NEXT_PUBLIC_` prefix concept in Laravel — never use it

## CSRF Protection
- Laravel's CSRF middleware is enabled by default for all web routes
- NEVER disable or add exceptions to the CSRF middleware (configured in `bootstrap/app.php`) without explicit justification
- ALL HTML forms must include the `@csrf` Blade directive
- API routes (in `routes/api.php`) use token-based auth (Sanctum), not CSRF

## Authentication
- Use `auth` middleware to protect routes: `Route::middleware('auth')->group(...)`
- Use Laravel Sanctum for API token authentication
- NEVER roll a custom authentication system — use Laravel Fortify (the auth backend of Laravel's official starter kits) with Blade views; Laravel Breeze is no longer used
- Always verify authentication before processing requests

## Authorization
- Use Laravel Policies for resource-level authorization
- Policies in `app/Policies/` are auto-discovered (`Todo` → `TodoPolicy`); there is no `AuthServiceProvider` — register non-conventional ones with `Gate::policy()` in `AppServiceProvider`
- Any changes to Policies or Gates require explicit user approval before proceeding

## Security Headers
- Implement security headers via a `SecurityHeaders` middleware class
- Register globally in `bootstrap/app.php` via `->withMiddleware(fn (Middleware $middleware) => $middleware->append(SecurityHeaders::class))` — there is no `app/Http/Kernel.php`
- Required headers: `X-Frame-Options: DENY`, `X-Content-Type-Options: nosniff`,
  `Referrer-Policy: origin-when-cross-origin`, `Strict-Transport-Security`

## Input Validation
- Validate ALL user input server-side via FormRequest classes
- Never trust client-side validation alone
- Use FormRequest `rules()` for validation and `authorize()` for authorization

## Code Review Triggers
- Any changes to middleware (especially auth/CSRF) require explicit user approval
- Any changes to Policy or Gate files require explicit user approval
- Any new environment variables must be documented in `.env.example`
