# Visa App

A Laravel 11 application for online visa ordering: product catalog with offers and extras, multi-currency / multi-language storefront, cart and checkout via Omnipay (Authorize.Net), order lifecycle with statuses, CMS articles, and an admin area. Backed by PostgreSQL and Redis, with queue workers and a scheduler running under supervisord.

## Stack

- PHP 8.2 / Laravel 11
- PostgreSQL 16
- Redis 7 (cache, session, queue)
- Nginx + PHP-FPM
- Vite + Tailwind + Alpine
- Supervisor (queue worker + scheduler)
- Adminer (DB UI)

## Prerequisites

- Docker Desktop (or Docker Engine + Compose v2)
- Git

## Installation

### 1. Clone

```bash
git clone <repo-url> visa-app
cd visa-app
```

### 2. Create `.env`

```bash
cp .env.example .env
```

Ensure these values point at the container services (already correct if you copied from `.env.example` after our Docker setup):

```env
APP_URL=http://localhost:8080

DB_CONNECTION=pgsql
DB_HOST=postgres
DB_PORT=5432
DB_DATABASE=visa_app
DB_USERNAME=visa
DB_PASSWORD=secret

REDIS_HOST=redis
REDIS_PORT=6379
REDIS_PASSWORD=null

QUEUE_CONNECTION=redis
CACHE_STORE=redis
SESSION_DRIVER=redis
```

### 3. Build and start containers

```bash
docker compose -f docker-compose.dev.yml build
docker compose -f docker-compose.dev.yml up -d
```

This brings up: `app` (PHP-FPM), `nginx`, `vite`, `queue-worker`, `scheduler`, `postgres`, `redis`, `adminer`.

### 4. Install dependencies

```bash
docker compose -f docker-compose.dev.yml exec app composer install
```

(Vite runs in its own container and auto-installs npm deps on first boot — check with `docker compose -f docker-compose.dev.yml logs vite`.)

### 5. Generate app key

```bash
docker compose -f docker-compose.dev.yml exec app php artisan key:generate
```

### 6. Migrate and seed the database

```bash
docker compose -f docker-compose.dev.yml exec app php artisan migrate
docker compose -f docker-compose.dev.yml exec app php artisan db:seed --force
```

Seeders populate roles, users, countries, travel directions, languages, currencies, products, offers, extras, gateways, order statuses, articles, and site settings.

### 7. Open the app

| Service     | URL                         |
|-------------|-----------------------------|
| App         | http://localhost:8080       |
| Vite (HMR)  | http://localhost:5173       |
| Adminer     | http://localhost:8081       |
| Postgres    | `localhost:5432`            |
| Redis       | `localhost:6379`            |

Adminer login — system: `PostgreSQL`, server: `postgres`, user: `visa`, password: `secret`, database: `visa_app`.

## Everyday commands

```bash
# Tail app logs
docker compose -f docker-compose.dev.yml logs -f app

# Open a shell in the app container
docker compose -f docker-compose.dev.yml exec app bash

# Artisan
docker compose -f docker-compose.dev.yml exec app php artisan <command>

# Re-seed / reset DB
docker compose -f docker-compose.dev.yml exec app php artisan migrate:fresh --seed

# Clear caches after config or view-shared data changes
docker compose -f docker-compose.dev.yml exec app php artisan cache:clear
docker compose -f docker-compose.dev.yml exec app php artisan config:clear

# Run tests
docker compose -f docker-compose.dev.yml exec app php artisan test

# Stop everything
docker compose -f docker-compose.dev.yml down

# Reset volumes (destroys DB data)
docker compose -f docker-compose.dev.yml down -v
```

## Background work

- **Queue worker** — the `queue-worker` service runs `php artisan queue:work` under supervisord with 2 processes. Configure in [docker/supervisor/queue-worker.conf](docker/supervisor/queue-worker.conf).
- **Scheduler** — the `scheduler` service runs `php artisan schedule:work`. Register recurring tasks in `routes/console.php` or `app/Console/Kernel.php`.

## Production

```bash
# Prepare a real .env: APP_ENV=production, APP_DEBUG=false, strong secrets
docker compose -f docker-compose.prod.yml build
docker compose -f docker-compose.prod.yml up -d
docker compose -f docker-compose.prod.yml exec app php artisan migrate --force
docker compose -f docker-compose.prod.yml exec app php artisan config:cache route:cache view:cache
```

The prod image bakes in composer deps, built Vite assets, and opcache with `validate_timestamps=0`. Nginx serves `public/` from a dedicated image. Adminer is bound to `127.0.0.1` only.

## Project layout

```
app/
  Http/Controllers/       Controllers (storefront + admin)
  Models/                 Eloquent models (Product, Order, Language, …)
  Observers/              User & Order observers
  Services/               GlobalsService, SiteSettingsService, LocationService
  View/Composers/         GlobalsComposer (shares language/currency/menu to views)
database/
  migrations/             Schema
  seeders/                Seed data
docker/
  php/                    Dockerfile, php.ini, www.conf, xdebug.ini
  nginx/                  default.conf + prod Dockerfile
  supervisor/             queue-worker.conf, scheduler.conf
resources/                Blade views, JS, CSS
routes/                   web.php, api.php, console.php
```

## Troubleshooting

- **`vendor/autoload.php` not found** → run `composer install` inside the `app` container.
- **`No application encryption key has been specified`** → `php artisan key:generate`.
- **`relation "languages" does not exist`** → run `php artisan migrate` (and `db:seed`).
- **Stale shared view data (menu, languages, currencies)** → `php artisan cache:clear`.
- **Queue/scheduler not picking up code changes** → restart the worker containers: `docker compose -f docker-compose.dev.yml restart queue-worker scheduler`.

## License

MIT.
