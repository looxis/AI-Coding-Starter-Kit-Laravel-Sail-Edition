# Error Tracking Setup (Sentry for Laravel)

Track production errors automatically so you know about issues before your users report them.

## Setup (5 minutes)

### 1. Create Sentry Account
- Go to [sentry.io](https://sentry.io) (free tier available for small apps)
- Create a new project and select "Laravel"

### 2. Install Laravel Sentry SDK
```bash
composer require sentry/sentry-laravel
```

### 3. Publish Sentry Config
```bash
php artisan vendor:publish --provider="Sentry\Laravel\ServiceProvider"
```
This creates `config/sentry.php`.

### 4. Add Environment Variable
Add to `.env` (local) and your production server's environment:
```bash
SENTRY_LARAVEL_DSN=https://xxx@xxx.ingest.sentry.io/xxx
```

Also document in `.env.example`:
```bash
# SENTRY_LARAVEL_DSN=https://xxx@xxx.ingest.sentry.io/xxx
```

### 5. Register Error Reporting
In `app/Exceptions/Handler.php`, add inside the `register()` method:
```php
$this->reportable(function (Throwable $e) {
    if (app()->bound('sentry')) {
        app('sentry')->captureException($e);
    }
});
```

### 6. Verify Setup
Trigger a test error and check Sentry Dashboard:
```php
// Temporary test — remove after verification
throw new \Exception("Sentry test error");
```

## What You Get
- Automatic error capture (PHP exceptions + queue job failures)
- Stack traces with full Laravel context
- Error grouping and deduplication
- Email alerts for new errors
- Performance monitoring (optional)

## Alternative
**Flare** (flareapp.io) — Laravel-specific error tracking with deep Blade/Eloquent context. Often more useful for Laravel projects than generic Sentry.

Install: `composer require spatie/laravel-ignition flare-client-php/flare`
