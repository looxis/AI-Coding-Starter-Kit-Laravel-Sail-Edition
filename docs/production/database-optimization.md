# Database Optimization

## 1. Indexing

Create indexes on columns used in WHERE, ORDER BY, or JOIN clauses — include them in your migration:

```php
// In your migration file
Schema::create('tasks', function (Blueprint $table) {
    $table->id();
    $table->foreignId('user_id')->constrained()->cascadeOnDelete();
    $table->string('title');
    $table->enum('status', ['todo', 'done'])->default('todo');
    $table->timestamps();

    // Index: this table will be queried frequently by user_id + sorted by created_at
    $table->index(['user_id', 'created_at']);
});
```

**Rule of thumb:** If a column appears in `WHERE`, `ORDER BY`, or `JOIN` and the table will have >1000 rows, add an index.

## 2. Avoid N+1 Queries

The most common performance problem with ORMs:

```php
// Bad: N+1 (1 query for users + N queries for tasks)
$users = User::all();
foreach ($users as $user) {
    echo $user->tasks->count(); // Query per user!
}

// Good: Eager loading (2 queries total)
$users = User::with('tasks')->get();
foreach ($users as $user) {
    echo $user->tasks->count(); // No extra query
}
```

Use **Laravel Debugbar** (`composer require barryvdh/laravel-debugbar --dev`) to detect N+1 queries during development — it shows every SQL query on the page.

## 3. Always Limit Results

Never return unbounded results from the database:

```php
// Bad: Returns ALL rows
$tasks = Task::all();

// Good: Paginated (returns 20 rows + pagination links)
$tasks = Task::paginate(20);

// In your Blade view: {{ $tasks->links() }}

// Good: Fixed limit for non-paginated contexts
$recent = Task::latest()->limit(10)->get();
```

## 4. Caching Strategy

For data that changes rarely (categories, config, dashboard stats):

```php
use Illuminate\Support\Facades\Cache;

$categories = Cache::remember('categories', 3600, function () {
    return Category::all();
});

// To clear the cache when data changes:
Cache::forget('categories');
```

**When to cache:**
- Data that changes less than once per hour
- Expensive aggregation queries (`COUNT`, `SUM`, `GROUP BY`)
- Data shared across all users (not user-specific)

**When NOT to cache:**
- User-specific data that changes frequently
- Real-time data

## 5. Select Only What You Need

```php
// Bad: Fetches all columns (including large text/blob fields)
$users = User::all();

// Good: Fetches only needed columns
$users = User::select(['id', 'name', 'email', 'created_at'])->get();
```
