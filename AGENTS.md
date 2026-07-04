This is a tech blog written in latest PHP and Laravel. It uses static analysis like PHPStan and CS Fixer to ensure code quality. It also uses Podman for development and production.

## Podman

Use `./run` script for working with Podman. Instead of using long podman commands like `podman-compose -f compose.yml -f compose.dev.yml --env=app/.env build` just use shortcut like `./run dev build`, `./run dev up -d`, `./run prod build`, etc.
