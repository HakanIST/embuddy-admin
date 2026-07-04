# EmBuddy Admin Panel

Laravel 12 + Filament 5 admin panel for managing **EmBuddy** — Üsküdar University's international student companion app.

🌐 **URL:** `http://embuddy-admin.tall.tr`

## Tech Stack

- **Framework:** Laravel 12 (PHP 8.3+)
- **Admin Panel:** Filament v5
- **Database:** MySQL 8 (shared with `embuddy-api` via Docker network)
- **Container:** PHP-FPM + Nginx + Supervisor

## Features

### Content Management
- 📖 **Guides** — Create/edit campus guides with markdown
- 🏷️ **Guide Categories** — Manage guide categories
- 📅 **Events** — University events management
- 📍 **Campus Locations** — Manage campus map locations
- 🎵 **Media Items** — Podcasts, books, videos
- 📝 **Word of the Day** — Daily Turkish vocabulary

### User Management
- 👥 **Students** — View/manage student profiles
- ❤️ **Mood Entries** — View student mood check-ins (read-only)

### Gamification
- 🏆 **Achievements** — Define achievement badges & XP rewards
- ✅ **Daily Tasks** — Configure daily task challenges

## Local Development

```bash
composer install
cp .env.example .env
php artisan key:generate
php artisan test
php artisan serve
```

## Docker Deployment

```bash
docker network create embuddy-net 2>/dev/null || true
docker compose up -d --build
```

## CI/CD

Automated via GitHub Actions (Test with MySQL → Deploy via SSH)

## Admin Login

- **Email:** admin@uskudar.edu.tr
- **Password:** admin123
