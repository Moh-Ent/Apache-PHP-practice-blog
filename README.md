# MyApp — Full Stack PHP Community Platform

A full stack web application built from scratch with PHP, MySQL, and Apache.

## Features

- User registration and login with secure session management
- Password hashing with bcrypt
- CSRF protection on all forms
- Post creation, editing, and deletion
- Commenting system
- Admin panel with user and post management
- Role based access control (user / admin)
- Clean URL routing via Apache mod_rewrite
- Responsive dark theme UI

## Security Implementations

- PDO prepared statements (SQL injection prevention)
- `htmlspecialchars()` on all output (XSS prevention)
- CSRF tokens on every form
- `password_hash()` / `password_verify()` with bcrypt
- Session regeneration on login (session fixation prevention)
- Principle of least privilege (dedicated DB user)
- Security headers (X-Frame-Options, X-XSS-Protection, X-Content-Type-Options)
- Hidden admin panel (returns 404 to non-admins)

## Tech Stack

- **Backend:** PHP 8
- **Database:** MySQL with PDO
- **Server:** Apache 2.4 with mod_rewrite
- **Frontend:** HTML, CSS (no frameworks)

## Setup

1. Clone the repo
2. Copy `config/database.example.php` to `config/database.php`
3. Fill in your database credentials
4. Import the database schema from `database.sql`
5. Configure Apache virtual host to point to `/public`
6. Visit `http://localhost`

## Project Structure

```
myapp/
├── config/
│   └── database.php        # DB credentials (not in repo)
├── src/
│   ├── Auth.php            # Authentication logic
│   ├── Post.php            # Posts and comments logic
│   ├── Admin.php           # Admin panel logic
│   └── helpers.php         # CSRF, redirect, sanitize helpers
└── public/
    ├── index.php           # Front controller
    ├── .htaccess           # URL routing
    ├── assets/
    │   └── css/style.css   # Stylesheet
    └── views/              # HTML templates
```
