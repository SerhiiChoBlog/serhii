# Serhii Cho Blog

This is a tech blog written in latest PHP, Laravel and Vue. It uses static analysis like PHPStan and CS Fixer to ensure code quality. It also uses Podman for development and production.

## Podman

Use `./cmd/run dev` script for working with Podman. Instead of using long podman commands like `podman-compose -f compose.yml -f compose.dev.yml --env=app/.env build` just use shortcut like `./cmd/run dev build`, `./cmd/run dev up -d`, `./cmd/run prod build`, etc.
