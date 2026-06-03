# Rate Limiting

Prevent abuse, brute-force attacks, and excessive API usage.

## When to Add Rate Limiting
- **MVP:** Optional (focus on features first)
- **Production with users:** Recommended on auth endpoints and public APIs
- **Public-facing APIs:** Required

## Laravel's Built-in Rate Limiting (no external service needed)

### 1. Apply to Routes
In `routes/web.php` or `routes/api.php`:
```php
// Limit to 60 requests per minute per user/IP
Route::middleware(['auth', 'throttle:60,1'])->group(function () {
    Route::get('/dashboard', [DashboardController::class, 'index']);
});

// Stricter limit for auth endpoints
Route::middleware('throttle:5,1')->group(function () {
    Route::post('/login', [AuthController::class, 'store']);
    Route::post('/forgot-password', [PasswordController::class, 'store']);
});
```

### 2. Custom Rate Limiters
For more control, define named rate limiters in `app/Providers/AppServiceProvider.php` or `RouteServiceProvider.php`:
```php
use Illuminate\Support\Facades\RateLimiter;
use Illuminate\Http\Request;

RateLimiter::for('api', function (Request $request) {
    return Limit::perMinute(60)->by($request->user()?->id ?: $request->ip());
});

RateLimiter::for('uploads', function (Request $request) {
    return Limit::perMinute(5)->by($request->user()->id);
});
```

Then apply:
```php
Route::middleware('throttle:uploads')->post('/upload', ...);
```

### 3. Response When Limit Exceeded
Laravel automatically returns HTTP 429 Too Many Requests with `Retry-After` header when the limit is exceeded. No additional code needed.

## Recommended Limits

| Endpoint Type | Limit | Window |
|--------------|-------|--------|
| Login / Register | 5 requests | 1 minute |
| Password Reset | 3 requests | 5 minutes |
| File Upload | 5 requests | 1 minute |
| General Web Routes | 60 requests | 1 minute |
| Public API | 30 requests | 1 minute |

## Redis-Backed Rate Limiting (higher scale)

By default, Laravel stores rate limit counters in the cache driver (database or file). For high-traffic production apps, switch to Redis:

1. Install Redis client: `composer require predis/predis`
2. Update `.env`:
   ```
   CACHE_STORE=redis
   REDIS_HOST=127.0.0.1
   REDIS_PORT=6379
   ```
3. With Laravel Sail, Redis is already included in `docker-compose.yml`
