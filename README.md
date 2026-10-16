# MyApp — Full Stack PHP Community Platform

A full-stack web application built with PHP, MySQL, and Apache, containerized with Docker Compose for easy local setup.

## Features

- User registration and login with session management
- Password hashing with bcrypt
- CSRF protection on forms
- Post creation, editing, and deletion
- Commenting system
- Admin panel with user and post management
- Role-based access control (user / admin)
- Clean URL routing with Apache `mod_rewrite`
- Responsive dark-theme UI

## Security Implementations

- PDO prepared statements to help prevent SQL injection
- Output escaping with `htmlspecialchars()` to help prevent XSS
- CSRF tokens on forms
- Password hashing and verification with `password_hash()` and `password_verify()`
- Session regeneration on login
- Dedicated database user with restricted privileges
- Security headers
- Admin panel access restrictions

## Tech Stack

- **Backend:** PHP 8.3
- **Database:** MySQL 8.4
- **Web server:** Apache 2.4
- **Database access:** PDO
- **Frontend:** HTML and CSS
- **Containerization:** Docker and Docker Compose

## Requirements

- Docker Engine or Docker Desktop
- Docker Compose

## Getting Started with Docker

### 1. Clone the repository

```bash
git clone https://github.com/Moh-Ent/Apache-PHP-practice-blog
cd Apache-PHP-practice-blog
```

Replace the placeholders with your repository URL and directory name.

### 2. Configure environment variables

Create your local environment file:

```bash
cp .env.example .env
```

Edit `.env` and replace the example passwords with strong, unique passwords.

**Important:** Never commit `.env` or share its real credentials. The repository includes `.env.example` as a template.

### 3. Build and start the application

```bash
docker compose up --build -d
```

Docker Compose builds the PHP/Apache image and starts the MySQL database. On the first initialization, MySQL creates the database and imports the schema from `database.sql`.

### 4. Open the application

Visit:

**http://localhost:8080**

Register a test account to verify that the application and database are working together.

### 5. View logs and service status

Check running services:

```bash
docker compose ps
```

View application logs:

```bash
docker compose logs -f web
```

View database logs:

```bash
docker compose logs -f db
```

### 6. Stop the application

```bash
docker compose down
```

This stops and removes the containers while preserving the named database volume, so your data remains available when you start the project again.

To start it later:

```bash
docker compose up -d
```

**Warning:** Avoid `docker compose down -v` unless you intentionally want to delete the database volume and its stored data.

## Database Initialization

The `database.sql` file is automatically imported when MySQL initializes a fresh data directory.

If the database volume already exists, changing `database.sql` will not automatically re-import it. Existing database data is preserved across ordinary container restarts.

## Project Structure

```text
myapp/
├── config/
│   ├── database.example.php
│   └── database.php          # Local configuration; not committed
├── src/
│   ├── Auth.php
│   ├── Post.php
│   ├── Admin.php
│   └── helpers.php
├── public/
│   ├── index.php
│   ├── .htaccess
│   ├── assets/
│   └── views/
├── database.sql
├── Dockerfile
├── compose.yaml
├── .dockerignore
├── .env.example
└── README.md
```

## Troubleshooting

**The application cannot connect to MySQL**

Check that both services are running and inspect the logs:

```bash
docker compose ps
docker compose logs --tail=100 db web
```

Inside Docker Compose, the application connects to the database service using the hostname `db`, not `localhost`.

**The database schema did not initialize**

MySQL initialization scripts run when the database data directory is first created. If the named volume already contains data, the initialization script will not run again automatically.

For a fresh test, use a separate Compose project or remove the existing database volume only after confirming that its data can be safely discarded.

## License

Add your chosen license here if you intend to distribute the project publicly.
