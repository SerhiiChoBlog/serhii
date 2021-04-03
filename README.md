# Serhii Cho

# Zoo-Zoo-Zoo Admin panel

# Requirements

- [node](https://nodejs.org/en/)
- [npm](https://www.npmjs.com/get-npm)
- [composer](https://getcomposer.org/)
- [php 8.0](https://www.php.net/)

# Get started

## Install project

```bash
git clone https://github.com/Z00-Z00-Z00/admin-panel.git
# or
git clone git@github.com:SerhiiCho/serhii.git
```

## Create database

Create empty database with the name of `serhii`

## Create .env file

Create `.env` file in the root of the project by copying `.env.example` file and saving it as `.env`.

```bash
cp .env.example .env
```

## Fill in .env file

Fill in database credentials into .env file in the root of the project.

```bash
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=serhii
DB_USERNAME=
DB_PASSWORD=
```

## Create all the tables in database

In the root of the project run `php artisan migrate` in order to create all the tables in the database.

```bash
php artisan migrate
```

## Install PHP dependencies

Run `composer install` command in the root of the project to install all the dependencies. If you're installing project for production you can add `--no-dev` flag to the end of the command in order to install only production dependencies.

```bash
composer install
```

## Generate key

Generate encryption key into config file by running the artisan command:

```bash
php artisan key:generate
```

## Install npm dependencies

In order to compile all the assets you need to install npm dependencies. Run:

```bash
npm i
```

## Compiled assets

Compile all the assets by running npm or yarn command:

```bash
npm run prod
```

## Link storage to public directory

In order to make images available on the frontend of the app you need to create a sym link that points to storage/app directory. Run `php artisan storage:link` in order to do that.

```bash
php artisan storage:link
```

## Serve the application

Run `php artisan serve` in the directory of the project

```bash
php artisan serve
```

