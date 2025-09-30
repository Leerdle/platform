# Laravel + Vue 3 + Inertia Monolith — Starter Kit

A batteries-included starter for building a modern Laravel 12 app with a Vue 3 front end powered by Inertia.js, Vite, and Tailwind CSS 4. It also ships with a helpful dev toolbox: Ziggy for routes in JS, Laravel Debugbar, Pail for live logs, Pest for testing, PHPStan for static analysis, and Pint for code style.

---

## Quick Start

```bash
# 1) Install PHP deps
composer install

# 2) Copy env and set your DB credentials
cp .env.example .env

# 3) Generate app key
php artisan key:generate

# 4) Create the sqlite file
New-Item database/database.sqlite

# 5) Run database migrations + seeders
php artisan migrate:fresh --seed

# 6) Install JS deps
npm install

# 7) Start Vite in watch mode (one terminal)
npm run dev

# 8) Start the PHP server (second terminal)
php -S 0.0.0.0:80 -t public
# (Port 80 usually needs sudo; 8000 is safer for local dev.)

# Open the app
# http://localhost
```

**Note**: This project intentionally does not use Herd due to Google API constraints in some setups. The built-in PHP server or Sail works great.

---

## Why this stack

- Laravel 12 (PHP 8.2+) 
  - Mature backend framework, routing, Eloquent, queues, etc. 
- Vue 3 + Inertia.js 
  - SPAs without API boilerplate
  - server-side routing with client-side rendering. 
- Vite 
  - Fast dev server & production bundling. 
- Tailwind CSS 4 
  - Utility-first modern styling. 
- Ziggy 
  - Use Laravel route names in Vue. 
- Dev UX 
  - Debugbar
  - Pail (tail logs)
  - Pest (tests)
  - PHPStan (static analysis)
  - Pint (formatting)

---

## Requirements

- PHP 8.2+ 
- Composer 2.x 
- Node.js 18+ (20+ recommended) and npm 
- A running database (MySQL/MariaDB/PostgreSQL/SQLite)
