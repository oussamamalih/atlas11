# Atlas11

Description du projet

## Technologies

- Laravel 13
- PHP 8.3
- MySQL 8.4
- Docker
- Docker Compose

## Installation

### 1. Clone

git clone ...

### 2. Configuration

cp .env.example .env

### 3. Docker

docker compose build
docker compose up -d

### 4. Migration

docker compose exec app php artisan migrate

### 5. Access

http://localhost:8000

## Docker Services

| Service | Port |
|---------|------|
| Laravel | 8000 |
| MySQL | 3308 |

## Author

Oussama Malih