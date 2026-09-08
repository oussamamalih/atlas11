# Atlas11 ⚽

**Atlas11** is a Moroccan football talent scouting platform that connects players and scouts. Players create detailed profiles showcasing their skills, while scouts can search, filter, and express scouting interest. The platform features role-based dashboards and an admin panel for platform management.

---

## Features

- **Role-based authentication** — `player`, `scout`, and `admin` roles
- **Player profiles** — position, city, age, preferred foot, bio, and more
- **Scout profiles** — organisation, specialisation, and bio
- **Player search** — scouts can filter players by position, city, age, and foot
- **Scouting interests** — scouts express interest in players; duplicates are prevented
- **Notifications** — players are notified when a scout expresses interest
- **Dashboards** — role-customised dashboards for all user types
- **Admin panel** — administrators can view and manage all platform users

---

## Technology Stack

| Layer | Technology |
|---|---|
| Backend framework | Laravel 13 |
| Language | PHP 8.3 |
| Database | MySQL 8.4 (Docker) / SQLite (local dev/tests) |
| Frontend | Blade templates + Tailwind CSS |
| Asset bundler | Vite |
| Auth scaffolding | Laravel Breeze |
| Package manager | Composer / npm |
| Containerisation | Docker + Docker Compose |
| Testing | PHPUnit 12 |

---

## Prerequisites

### Local development

- PHP 8.3+
- Composer 2
- Node.js 20+ and npm
- SQLite (for local dev and tests — no extra setup required)

### Docker

- Docker Desktop (or Docker Engine + Compose plugin)

---

## Installation

### Option A — Local development (SQLite)

```bash
# 1. Clone the repository
git clone https://github.com/oussamamalih/atlas11.git
cd atlas11

# 2. Copy the environment file and generate an application key
cp .env.example .env
php artisan key:generate

# 3. Install PHP dependencies
composer install

# 4. Install and build frontend assets
npm install
npm run build

# 5. Run the database migrations
php artisan migrate

# 6. Start the development server
php artisan serve
```

Visit [http://localhost:8000](http://localhost:8000).

---

### Option B — Docker (MySQL)

> **Note:** The Docker environment uses MySQL. The first `docker compose up` run builds the image and may take a few minutes.

```bash
# 1. Clone the repository
git clone https://github.com/oussamamalih/atlas11.git
cd atlas11

# 2. Copy the environment file
cp .env.example .env

# 3. Build and start the containers
docker compose up -d --build

# 4. Generate the application key
docker compose exec app php artisan key:generate

# 5. Run migrations
docker compose exec app php artisan migrate

# 6. (Optional) Seed the database
docker compose exec app php artisan db:seed
```

Visit [http://localhost:8000](http://localhost:8000).

---

## Environment Variables

Key variables to configure in `.env`:

| Variable | Description | Default |
|---|---|---|
| `APP_KEY` | Laravel application encryption key | generated |
| `APP_DEBUG` | Enable debug mode | `true` |
| `DB_CONNECTION` | Database driver (`sqlite` / `mysql`) | `sqlite` |
| `DB_HOST` | MySQL host (Docker: `mysql`) | — |
| `DB_DATABASE` | Database name | `atlas11` |
| `DB_USERNAME` | Database user | `atlas11` |
| `DB_PASSWORD` | Database password | `secret` |
| `SESSION_DRIVER` | Session storage driver | `database` |
| `QUEUE_CONNECTION` | Queue driver | `database` |

The `.env.example` file contains commented blocks for both SQLite and MySQL configurations.

---

## Docker Services

| Service | Container | Host Port |
|---|---|---|
| Laravel app | `atlas11-app` | `8000` |
| MySQL 8.4 | `atlas11-mysql` | `3308` |

Connect to MySQL from your host machine at `127.0.0.1:3308` (user `atlas11`, password `secret`).

### Useful Docker commands

```bash
# View container logs
docker compose logs -f app

# Open a shell inside the app container
docker compose exec app bash

# Stop all containers
docker compose down

# Stop and remove volumes (resets the database)
docker compose down -v
```

---

## Database Migrations

```bash
# Run all pending migrations
php artisan migrate

# Roll back the last batch
php artisan migrate:rollback

# Reset and re-run all migrations
php artisan migrate:fresh

# Reset, re-run, and seed
php artisan migrate:fresh --seed
```

For Docker, prefix every command with `docker compose exec app`.

---

## Running the Tests

The test suite uses PHPUnit with an **in-memory SQLite** database — no additional database setup is needed.

```bash
# Run the full test suite
php artisan test

# Run a specific test file
php artisan test tests/Feature/PlayerProfileTest.php

# Run with verbose output
php artisan test --verbose
```

Inside Docker:

```bash
docker compose exec app php artisan test
```

### Test coverage overview

| Test file | Area covered |
|---|---|
| `Auth/` | Registration, login, and role selection |
| `PlayerProfileTest.php` | Player profile CRUD and authorization |
| `ScoutProfileTest.php` | Scout profile CRUD and authorization |
| `PlayerSearchTest.php` | Player search filters and scout-only access |
| `ScoutingInterestTest.php` | Interest creation, duplication, and authorization |
| `NotificationTest.php` | Notification creation and mark-as-read |
| `DashboardTest.php` | Role-based dashboard content |
| `AdminTest.php` | Admin panel access and user management |

---

## Project Structure

```
atlas11/
├── app/
│   ├── Http/
│   │   ├── Controllers/          # Feature controllers
│   │   └── Middleware/           # EnsureUserIsAdmin, etc.
│   ├── Models/                   # Eloquent models
│   └── Notifications/            # Laravel notification classes
├── database/
│   ├── factories/                # Model factories
│   ├── migrations/               # Database migrations
│   └── seeders/                  # Database seeders
├── resources/
│   └── views/                    # Blade templates
├── routes/
│   └── web.php                   # Application routes
├── tests/
│   └── Feature/                  # Feature test suite
├── Dockerfile
├── docker-compose.yml
└── .env.example
```

---

## User Roles

| Role | Capabilities |
|---|---|
| `player` | Create/edit own profile, view scouting interests, receive notifications |
| `scout` | Create/edit own profile, search players, express scouting interest |
| `admin` | View and manage all platform users, access admin dashboard |

Select your role during registration on the sign-up form.

---

## Development Commands

```bash
# Start development server with hot-reload assets
composer run dev

# Run Pint (code style fixer)
./vendor/bin/pint

# Run tests
composer run test
```

---

## Author

**Oussama Malih**