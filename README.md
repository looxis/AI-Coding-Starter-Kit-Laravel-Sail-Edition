# AI Coding Starter Kit — Laravel Edition

> Build production-ready Laravel apps faster with AI-powered Skills handling Requirements, Architecture, Development, QA, and Deployment.

This template uses [Claude Code](https://docs.anthropic.com/en/docs/claude-code) with modern Skills, Rules, and Sub-Agents to provide a complete AI-powered development workflow — adapted for the **Laravel / Blade / Tailwind / Alpine.js / MySQL / Pest** stack.

## Quick Start

### Option A: Laravel Herd (recommended for Windows/Mac)

```bash
# 1. Install Herd from herd.laravel.com — it manages PHP, MySQL, and local domains

# 2. Clone into your Herd sites directory
git clone https://github.com/YOUR_USERNAME/ai-coding-starter-kit.git ~/Herd/my-project
cd ~/Herd/my-project

# 3. Install PHP dependencies
composer install

# 4. Set up environment
cp .env.example .env
php artisan key:generate

# 5. Create a MySQL database and update .env with DB credentials
# DB_DATABASE=my_project, DB_USERNAME=root, DB_PASSWORD=

# 6. Run migrations
php artisan migrate

# 7. Install and build assets
npm install && npm run dev

# 8. Open http://my-project.test in your browser
```

### Option B: Laravel Sail (Docker)

```bash
# 1. Install Docker Desktop

# 2. Clone the repo
git clone https://github.com/YOUR_USERNAME/ai-coding-starter-kit.git my-project
cd my-project

# 3. Install PHP dependencies (needs PHP on host or use the Docker workaround)
composer install

# 4. Set up environment
cp .env.example .env

# 5. Start Docker containers
./vendor/bin/sail up -d

# 6. Generate app key and run migrations
./vendor/bin/sail artisan key:generate
./vendor/bin/sail artisan migrate

# 7. Build assets
./vendor/bin/sail npm install && ./vendor/bin/sail npm run dev

# 8. Open http://localhost in your browser
```

### Initialize Your Project

Open Claude Code and run `/init` with a brief description of your idea:

```
/init I want to build a project management tool for small teams
where users can create projects, assign tasks, and track progress.
```

The skill interviews you one question at a time (**Grill Me** principle — always with a recommended answer you just confirm or correct) until there's a shared understanding. It then:
1. Creates your **Product Requirements Document** (`docs/PRD.md`)
2. Breaks the project into a prioritized feature map (P0/P1/P2)
3. Decides on authentication and local dev setup
4. Updates **feature tracking** (`features/INDEX.md`)
5. Recommends which feature to build first

### Spec Your First Feature

```
/write-spec PROJ-1
```

The skill interviews you about this single feature in depth — user stories, edge cases, acceptance criteria in German Angenommen/Wenn/Dann format. Use `/refine PROJ-X` at any point to revisit and improve.

### Build Features

```
/architecture    Design the tech approach for features/PROJ-1-user-auth.md
/frontend        Build the Blade UI for features/PROJ-1-user-auth.md
/backend         Build controllers, models, migrations for features/PROJ-1-user-auth.md
/qa              Test features/PROJ-1-user-auth.md
/deploy          Deploy to production
```

Each skill suggests the next step when it finishes. Handoffs are always user-initiated.

---

## Available Skills

| Skill | Command | What It Does |
|-------|---------|-------------|
| Project Initializer | `/init` | One-time setup: creates PRD + feature map via Grill Me interview |
| Feature Spec Writer | `/write-spec` | Creates a full spec for one feature (user stories, AC, edge cases) |
| Spec Refiner | `/refine PROJ-X` | Reopens an existing spec to improve, extend, or challenge it |
| Solution Architect | `/architecture` | Designs PM-friendly tech architecture (no code, only high-level design) |
| Frontend Developer | `/frontend` | Builds UI with Blade templates, Alpine.js, and Tailwind CSS |
| Backend Developer | `/backend` | Builds controllers, Eloquent models, migrations, Form Requests |
| QA Engineer | `/qa` | Tests features against acceptance criteria + writes Pest tests + security audit |
| DevOps | `/deploy` | Sets up Herd/Sail locally and guides through production deployment |
| Help | `/help` | Context-aware guide: shows where you are and what to do next |

### How Skills Work

- **Skills** are defined in `.claude/skills/` and auto-discovered by Claude Code
- **Rules** in `.claude/rules/` are auto-applied based on file context (no manual loading)
- **Sub-Agents** run heavy tasks (frontend, backend, QA) in isolated contexts for cost efficiency
- **CLAUDE.md** provides project context automatically at every session start

---

## Development Workflow

```
0. Setup     /init          -->  PRD + feature map (once per project)
1. Spec      /write-spec    -->  Feature spec in features/PROJ-X.md
             /refine PROJ-X -->  Revisit and improve an existing spec
2. Design    /architecture  -->  Tech design added to feature spec
3. Build     /frontend      -->  Blade views + Alpine.js implemented
             /backend       -->  Controllers + models + migrations (if needed)
4. Test      /qa            -->  Pest tests + security audit
5. Ship      /deploy        -->  Deployed to production
```

### Feature Tracking

Features are tracked in `features/INDEX.md`:

| ID | Feature | Status | Spec |
|----|---------|--------|------|
| PROJ-1 | User Login | Deployed | [Spec](features/PROJ-1-user-login.md) |
| PROJ-2 | Dashboard | In Progress | [Spec](features/PROJ-2-dashboard.md) |

Every skill reads this file at start and updates it when done, preventing duplicate work.

---

## Tech Stack

| Category | Tool | Why? |
|----------|------|------|
| **Framework** | Laravel (PHP) | Full-stack MVC, batteries included |
| **Templating** | Blade | Server-side templating with reusable components |
| **Styling** | Tailwind CSS v3 | Utility-first CSS |
| **JS Framework** | Alpine.js | Lightweight reactive behavior, no SPA overhead |
| **Database** | MySQL | Relational database via Eloquent ORM |
| **Validation** | Laravel Form Requests | Validation + authorization in one class |
| **Testing** | Laravel Pest | Expressive PHP testing |
| **Local Dev** | Laravel Herd / Sail | Native (Herd) or Docker (Sail) |

---

## Project Structure

```
ai-coding-starter-kit/
+-- CLAUDE.md                        <-- Auto-loaded project context
+-- .claude/
|   +-- settings.json                <-- Team permissions (committed)
|   +-- settings.local.json          <-- Personal overrides (gitignored)
|   +-- rules/                       <-- Auto-applied coding rules
|   |   +-- general.md                   Git workflow, feature tracking
|   |   +-- frontend.md                  Blade components, Alpine.js, CSRF
|   |   +-- backend.md                   Form Requests, Eloquent, Policies
|   |   +-- security.md                  Secrets, CSRF, auth, headers
|   +-- skills/                      <-- Invocable workflows (/command)
|   |   +-- init/SKILL.md                /init
|   |   +-- write-spec/SKILL.md          /write-spec
|   |   +-- refine/SKILL.md              /refine
|   |   +-- architecture/SKILL.md        /architecture
|   |   +-- frontend/SKILL.md            /frontend (runs as sub-agent)
|   |   +-- backend/SKILL.md             /backend (runs as sub-agent)
|   |   +-- qa/SKILL.md                  /qa (runs as sub-agent)
|   |   +-- deploy/SKILL.md              /deploy
|   |   +-- help/SKILL.md                /help
|   +-- agents/                      <-- Sub-agent configs
|       +-- frontend-dev.md              Model, tools, limits
|       +-- backend-dev.md
|       +-- qa-engineer.md
+-- features/                        <-- Feature specifications
|   +-- INDEX.md                         Status tracking
|   +-- README.md                        Spec format documentation
+-- docs/
|   +-- PRD.md                       <-- Product Requirements Document
|   +-- production/                  <-- Production setup guides
|       +-- error-tracking.md            Sentry for Laravel (5 min)
|       +-- security-headers.md          SecurityHeaders middleware
|       +-- performance.md               Lighthouse, caching, optimization
|       +-- database-optimization.md     Indexing, N+1, Eloquent caching
|       +-- rate-limiting.md             Laravel throttle middleware
+-- app/
|   +-- Http/Controllers/            <-- MVC Controllers
|   +-- Http/Requests/               <-- Form Request classes
|   +-- Models/                      <-- Eloquent Models
|   +-- Policies/                    <-- Authorization Policies
+-- resources/
|   +-- views/                       <-- Blade templates
|   |   +-- components/              <-- Reusable Blade components
|   +-- js/                          <-- Alpine.js
|   +-- css/                         <-- Tailwind CSS
+-- routes/
|   +-- web.php                      <-- Web routes
|   +-- api.php                      <-- API routes
+-- database/
|   +-- migrations/                  <-- Schema migrations
|   +-- factories/                   <-- Model factories
+-- tests/
|   +-- Feature/                     <-- Pest Feature tests
|   +-- Unit/                        <-- Pest Unit tests
+-- .env.example                     <-- Environment variable template
```

---

## How It Works Under the Hood

### Skills (`.claude/skills/`)
Each skill is a structured workflow that Claude Code discovers automatically. Skills can run inline (in the main conversation) or as forked sub-agents (isolated context window).

| Skill | Execution | Why? |
|-------|-----------|------|
| `/init` | Inline | Needs live interview with user |
| `/write-spec` | Inline | Needs live interview with user |
| `/refine` | Inline | Needs live interview with user |
| `/architecture` | Inline | Short output, user reviews in real-time |
| `/frontend` | Sub-agent (forked) | Heavy file editing, lots of output |
| `/backend` | Sub-agent (forked) | Heavy file editing, migrations, controllers |
| `/qa` | Sub-agent (forked) | Systematic testing, lots of output |
| `/deploy` | Inline | Deployment needs user oversight |
| `/help` | Inline | Quick status check and guidance |

### Rules (`.claude/rules/`)
Coding standards that are auto-applied based on which files Claude is working with. No manual loading needed.

### Sub-Agent Configs (`.claude/agents/`)
Lightweight configurations that define model, tool access, and turn limits for forked skills.

### CLAUDE.md
Auto-loaded at every session start. Contains tech stack, conventions, and references to PRD and feature index.

---

## Context Engineering

AI agents work best with clean, structured context — not longer prompts. This template is designed around these principles:

### State lives in files, not in memory

Every skill reads `features/INDEX.md` and the relevant feature spec at start. After context compaction or a new session, nothing is lost — the agent simply re-reads the files.

### Context is layered

| Layer | What | When loaded |
|-------|------|-------------|
| `CLAUDE.md` | Tech stack, conventions, commands | Every session (auto) |
| `.claude/rules/` | Coding standards | When editing matching files (auto) |
| Skill `SKILL.md` | Workflow instructions | When skill is invoked |
| Feature spec | Requirements, AC, tech design | On demand (skill reads it) |
| `docs/production/` | Deployment guides | Only when referenced |

### Context is isolated

Heavy implementation skills (`/frontend`, `/backend`, `/qa`) run as **forked sub-agents** with their own context window. Each fork starts clean and loads only what it needs.

### Context recovery is built in

All forked skills include a **Context Recovery** section: if the context is compacted mid-task, the agent re-reads the feature spec, checks `git diff` for progress, and continues without restarting.

---

## Customization for Your Team

This template is a starting point. Customize it for your project:

1. **Edit CLAUDE.md** — Add project-specific conventions
2. **Edit docs/PRD.md** — Define your product vision and roadmap
3. **Edit .claude/rules/** — Adjust coding standards for your team
4. **Edit .claude/skills/** — Modify workflows to match your process
5. **Edit .claude/settings.json** — Configure team permissions

---

## Production Guides

Standalone guides in `docs/production/`:

| Guide | Setup Time | What It Does |
|-------|-----------|-------------|
| [Error Tracking](docs/production/error-tracking.md) | 5 min | Sentry for Laravel — automatic error capture |
| [Security Headers](docs/production/security-headers.md) | 2 min | SecurityHeaders middleware (XSS, Clickjacking) |
| [Performance](docs/production/performance.md) | 10 min | Lighthouse, caching, Eloquent optimization |
| [Database Optimization](docs/production/database-optimization.md) | 15 min | Indexing, N+1 prevention, query caching |
| [Rate Limiting](docs/production/rate-limiting.md) | 5 min | Laravel throttle middleware |

---

## Scripts

```bash
# Laravel
php artisan serve          # Development server (localhost:8000)
php artisan migrate        # Run pending migrations
php artisan test           # Run Pest test suite
php artisan route:list     # List all registered routes

# Assets (Vite)
npm run dev                # Asset dev server (hot reload)
npm run build              # Production asset build

# Laravel Sail (Docker)
./vendor/bin/sail up -d
./vendor/bin/sail artisan migrate
./vendor/bin/sail npm run dev
```

---

## License

MIT License — feel free to use for your projects!
