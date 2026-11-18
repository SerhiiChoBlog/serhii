# Serhii Cho Blog

[![Main](https://github.com/SerhiiChoBlog/serhii/actions/workflows/main.yml/badge.svg)](https://github.com/SerhiiChoBlog/serhii/actions/workflows/main.yml)

This is a tech blog written in latest PHP, Laravel, TailwindCss, TypeScript and Vue. It uses static analysis like PHPStan and CS Fixer to ensure code quality. It also uses Podman for development and production.

## Podman

Use `./cmd/run` script for working with Podman. Instead of using long podman commands like `podman-compose -f compose.yml -f compose.dev.yml --env=app/.env build` just use shortcut like `./cmd/run build`, `./cmd/run up -d`, `./cmd/run build`, etc. For example, run all checks with `./cmd/run exec php composer check`.

## Technologies

- Laravel
- Vue.js
- TypeScript
- Vitepress
- MariaDB

## Rules

- If you create a data provider for a test, call it `providerFor<test-name>` where `<test-name>` is the name of the test that uses it. For example, if your test is called `testFunc`, provider should be `providerForFunc`.
