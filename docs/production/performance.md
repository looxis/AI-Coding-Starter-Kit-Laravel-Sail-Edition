# Performance Monitoring

## Lighthouse Check (after every deployment)

1. Open Chrome DevTools (F12)
2. Go to Lighthouse tab
3. Select: Performance, Accessibility, Best Practices, SEO
4. Generate Report for both Mobile and Desktop
5. **Target: Score > 90** in all categories

## Common Performance Issues

### Unoptimized Images
```html
<!-- Bad: no lazy loading, no sizing -->
<img src="/large-image.jpg">

<!-- Good: lazy loading, explicit dimensions -->
<img src="/large-image.jpg" width="800" height="600" loading="lazy" alt="Description">
```
For advanced image handling (resizing, WebP conversion), use **Spatie Media Library**: `composer require spatie/laravel-medialibrary`

### Large JavaScript Bundle
Use dynamic Alpine.js imports for heavy components that aren't needed on initial load.
Split Vite entrypoints in `vite.config.js` for code-splitting.

### Missing Loading States
Show Alpine.js feedback during data fetching or form submission:
```html
<div x-data="{ loading: false }">
    <button @click="loading = true" :disabled="loading">
        <span x-show="loading">Saving...</span>
        <span x-show="!loading">Save</span>
    </button>
</div>
```

### No Caching Strategy
Cache slow database queries with Laravel Cache:
```php
$stats = Cache::remember('dashboard-stats', 3600, function () {
    return DB::table('stats')->get();
});
```

## Laravel-Specific Optimizations

**Cache configuration (production only):**
```bash
php artisan config:cache   # Merges config into single file
php artisan route:cache    # Caches route registration (no closures allowed)
php artisan view:cache     # Pre-compiles all Blade templates
```
Never run these in development — they bypass real-time file changes.

**Opcache** — Enable in your PHP server config (`opcache.enable=1`). Caches compiled PHP bytecode, massively speeds up repeated requests.

**Eloquent optimization:**
```php
// Use select() to fetch only needed columns
User::select(['id', 'name', 'email'])->get();

// Use chunk() for processing large datasets
User::chunk(200, function ($users) {
    // process batch
});
```

## Quick Wins Checklist
- [ ] Images use `loading="lazy"` attribute
- [ ] Alpine.js shows loading feedback during async operations
- [ ] `php artisan config:cache` and `route:cache` run in production
- [ ] Eager loading (`with()`) used everywhere relationships are accessed
- [ ] No unbounded queries (all list queries use `->paginate()` or `->limit()`)
