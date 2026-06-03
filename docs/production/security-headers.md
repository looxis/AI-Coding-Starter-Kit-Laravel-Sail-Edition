# Security Headers Configuration

Protect against XSS, Clickjacking, MIME sniffing, and other common web attacks.

## Setup

### 1. Create the Middleware
```bash
php artisan make:middleware SecurityHeaders
```

### 2. Implement the Middleware
In `app/Http/Middleware/SecurityHeaders.php`:
```php
<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class SecurityHeaders
{
    public function handle(Request $request, Closure $next): Response
    {
        $response = $next($request);

        $response->headers->set('X-Frame-Options', 'DENY');
        $response->headers->set('X-Content-Type-Options', 'nosniff');
        $response->headers->set('Referrer-Policy', 'origin-when-cross-origin');
        $response->headers->set('Strict-Transport-Security', 'max-age=31536000; includeSubDomains');

        return $response;
    }
}
```

### 3. Register the Middleware
In `app/Http/Kernel.php`, add to the `$middleware` array (applies globally):
```php
protected $middleware = [
    // ... existing middleware
    \App\Http\Middleware\SecurityHeaders::class,
];
```

## What Each Header Does

| Header | Protection |
|--------|-----------|
| X-Frame-Options: DENY | Prevents your site from being embedded in iframes (clickjacking) |
| X-Content-Type-Options: nosniff | Prevents browsers from guessing content types (MIME sniffing) |
| Referrer-Policy | Controls how much URL info is sent to other sites |
| Strict-Transport-Security | Forces HTTPS connections |

## Verify After Deployment
1. Open Chrome DevTools
2. Go to Network tab
3. Click on any request to your site
4. Check Response Headers section
5. Verify all 4 headers are present

## Advanced (Optional)
**Content-Security-Policy (CSP)** — The most powerful header, but can break your app if misconfigured. Only add after thorough testing:
```php
$response->headers->set(
    'Content-Security-Policy',
    "default-src 'self'; script-src 'self' 'unsafe-inline'"
);
```
Start with report-only mode first: `Content-Security-Policy-Report-Only`
