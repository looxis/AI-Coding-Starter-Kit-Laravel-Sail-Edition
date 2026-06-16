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
| **Local Dev** | Laravel Sail (Docker), PHP 8.3 | Containerized, no local PHP/Composer/Node needed |

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
.env.example          # Environment variable template (Sail ports, DB config)
compose.yaml          # Laravel Sail / Docker services (app + mysql)
```

## Local Development (Docker / Sail only)

- This project runs **exclusively via Docker + Laravel Sail** — no local PHP, Composer, or Node installation is assumed or required.
- **Laravel Herd is not used for this project.**
- On Windows, all development happens inside **WSL2/Ubuntu** — never directly in PowerShell or CMD. Ideally the repo lives in the WSL filesystem (e.g. `~/code/your-project`), not under `/mnt/c/Users/...`.
- Always run project commands through `./vendor/bin/sail ...` (artisan, composer, npm, pest) rather than bare `php`/`composer`/`npm`.
- Ports default to Sail's standard values (`APP_PORT=80`, `VITE_PORT=5173`, `FORWARD_DB_PORT=3306`). If multiple Sail projects run in parallel, override these in `.env`/`.env.example` to avoid collisions — see README for details.
- Feature development should only start once `/init` has defined the actual product (`docs/PRD.md`) and this base Sail installation is documented and runnable.

## Development Workflow

1. `/init` — Initialize the project: PRD + feature map (run once at the start)
2. `/write-spec` — Create a full feature spec for one feature
3. `/architecture` — Design tech architecture (PM-friendly, no code)
4. `/frontend` — Build UI with Blade templates and Alpine.js
5. `/backend` — Build controllers, Eloquent models, migrations, Form Requests
6. `/qa` — Test against acceptance criteria + security audit + Pest tests
7. `/deploy` — Set up Sail locally, production-ready checks

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

All commands run through Sail (no local PHP/Composer/Node):

```bash
# Containers
./vendor/bin/sail up -d
./vendor/bin/sail down

# Development
./vendor/bin/sail artisan migrate           # Run pending migrations
./vendor/bin/sail artisan make:model X -mf  # Create model, migration, factory
./vendor/bin/sail artisan make:request StoreXRequest  # Create Form Request
./vendor/bin/sail artisan make:policy XPolicy --model=X  # Create Policy
./vendor/bin/sail artisan route:list        # Show all registered routes

# Testing
./vendor/bin/sail pest                      # Run all Pest tests
./vendor/bin/sail pest --filter=FeatureName # Run specific test

# Assets
./vendor/bin/sail npm run dev               # Vite asset dev server
./vendor/bin/sail npm run build             # Production asset build
```

## Product Context

@docs/PRD.md

## Feature Overview

@features/INDEX.md
