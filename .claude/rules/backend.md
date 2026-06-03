---
paths:
  - "app/Http/Controllers/**"
  - "app/Http/Requests/**"
  - "app/Models/**"
  - "database/migrations/**"
  - "routes/**"
---

# Backend Development Rules

## Form Requests (MANDATORY)
- ALWAYS create a dedicated `FormRequest` class for any form input: `php artisan make:request StoreTodoRequest`
- NEVER validate directly inside Controller methods — use `$request->validated()` after a FormRequest
- Validation rules live in the `rules()` method of the FormRequest
- Authorization logic belongs in the `authorize()` method of the FormRequest

## Eloquent Models
- Create Eloquent models for every database table: `php artisan make:model Todo -mf`
- ALWAYS define `$fillable` on every model to prevent mass assignment vulnerabilities
- Define relationships (`hasMany`, `belongsTo`, `hasOne`, etc.) in the model, not in controllers
- Use Eloquent scopes for reusable query filters

## Database Migrations
- ALL schema changes go through migrations: `php artisan make:migration create_todos_table`
- NEVER edit the database directly — always use migrations
- Add indexes in migrations: `$table->index(['column'])` or `$table->foreign('user_id')`
- Use `->cascadeOnDelete()` for foreign keys where appropriate
- Run migrations: `php artisan migrate`

## Controllers (MVC)
- Keep controllers thin — business logic belongs in Models or Service classes
- Use resource controllers for CRUD: `php artisan make:controller TodoController --resource`
- Web controllers return views; API controllers return JSON responses
- Always check authorization with Policies or Gates before acting on data

## Authorization (Policies)
- Create a Policy for every model: `php artisan make:policy TodoPolicy --model=Todo`
- Register policies in `app/Providers/AuthServiceProvider.php`
- Check authorization in controllers using `$this->authorize()` or `Gate::authorize()`

## Performance
- ALWAYS use eager loading to avoid N+1 queries: `Todo::with(['user'])->get()`
- Use `->paginate(20)` instead of fetching all rows
- Select only needed columns: `->select(['id', 'title', 'created_at'])`

## Security
- Never hardcode secrets in source code — use `.env` variables
- Access config via `config('app.var')` helper (not `env()`) inside application code
- Document all new environment variables in `.env.example`
