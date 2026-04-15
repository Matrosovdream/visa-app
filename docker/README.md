# Docker setup

## Dev

```bash
cp .env.example .env
# in .env set:
#   DB_CONNECTION=pgsql
#   DB_HOST=postgres
#   DB_PORT=5432
#   DB_DATABASE=visa_app
#   DB_USERNAME=visa
#   DB_PASSWORD=secret
#   REDIS_HOST=redis
#   QUEUE_CONNECTION=redis
#   CACHE_STORE=redis
#   SESSION_DRIVER=redis

docker compose -f docker-compose.dev.yml build
docker compose -f docker-compose.dev.yml up -d
docker compose -f docker-compose.dev.yml exec app php artisan key:generate
docker compose -f docker-compose.dev.yml exec app php artisan migrate
```

Services:
- App (Laravel):     http://localhost:8080
- Vite dev server:   http://localhost:5173
- Adminer:           http://localhost:8081  (server: `postgres`, user: `visa`, pass: `secret`)
- Postgres:          localhost:5432
- Redis:             localhost:6379

## Prod

```bash
# Provide a real .env with strong secrets, APP_ENV=production, APP_DEBUG=false
docker compose -f docker-compose.prod.yml build
docker compose -f docker-compose.prod.yml up -d
docker compose -f docker-compose.prod.yml exec app php artisan migrate --force
docker compose -f docker-compose.prod.yml exec app php artisan config:cache route:cache view:cache
```

## Containers

| Service        | Purpose                                          |
|----------------|--------------------------------------------------|
| `app`          | PHP-FPM (Laravel)                                |
| `nginx`        | Web server, proxies PHP to `app:9000`            |
| `vite`         | Vite dev server (dev only)                       |
| `queue-worker` | `php artisan queue:work` via supervisord (2 procs) |
| `scheduler`    | `php artisan schedule:work` via supervisord      |
| `postgres`     | Postgres 16                                      |
| `redis`        | Redis 7                                          |
| `adminer`      | DB UI                                            |

The queue worker and scheduler reuse the app image and run via supervisord
configs in `docker/supervisor/`. Adjust `numprocs`, `--queue`, `--tries`, etc.
in `queue-worker.conf` to taste.
