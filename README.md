# 🚀 Blog Project – Laravel 12 + Docker + JWT Auth + Swagger

This is a Dockerized Laravel 12 REST API for a simple blogging system

---

## 📦 Tech Stack

- PHP 8.2 (via Docker)
- Laravel 12
- MySQL 8 (Docker)
- JWT Authentication (tymon/jwt-auth)
- Swagger (l5-swagger)
- Postman / CURL friendly
- phpMyAdmin (via Docker)
- Docker Compose

---

## 🧰 Prerequisites

- [Docker Desktop](https://www.docker.com/products/docker-desktop) – Installed & running
- No need to install PHP, Composer, or MySQL manually

---

## 🚀 Getting Started

### 1️⃣ Clone the project

```bash
git clone https://github.com/your-username/blog-project.git
cd blog-project

## 2️⃣ Start the Docker containers

docker compose up -d --build

## 3️⃣ Run migrations & seeders

docker compose exec app php artisan migrate --seed

🧪 Running Tests

docker compose exec app php artisan test

🔍 API Documentation: http://localhost:8000/api/documentation

🌐 phpMyAdmin: http://localhost:8080
