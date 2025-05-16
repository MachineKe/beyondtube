# BeyondTube

BeyondTube is a full-featured video sharing platform inspired by YouTube, built with PHP and Yii2. It allows users to upload, view, like, and comment on videos, manage channels, and interact with content in a modern, multi-tier web application.

## Key Features

- User registration, authentication, and channel management
- Video upload, playback, and thumbnail generation
- Like/dislike system with AJAX support
- Video view tracking
- Studio backend for managing videos
- Responsive frontend for a seamless user experience
- Database migrations and easy local setup

## Getting Started

### 1. Clone the repository

```bash
git clone https://github.com/MachineKe/beyondtube.git
cd beyondtube
```

### 2. Install PHP dependencies

Make sure you have [Composer](https://getcomposer.org/) installed.

```bash
composer install
```

### 3. Set up the database

- Ensure your environment variables for the database connection are set (`DB_HOST`, `DB_NAME`, `DB_USER`, `DB_PASSWORD`) before running migrations.

- Run the Yii2 migrations to create all required tables:

```bash
php yii migrate
```

Alternatively, you can run migrations using your web browser. Simply use your frontend URL and visit the `migrate.php` route. For example:

```
frontendUrl/migrate.php
```

This will execute the migrations through a web interface, which can be useful if you do not have command-line access. Make sure your environment variables are set before using this method as well.

### 4. Set up web server or run locally

- For local development, you can use the built-in PHP server to run both the frontend and backend applications in separate terminals:

**Frontend:**
```bash
php yii serve --port=8080 --docroot=frontend/web
```
Access at: [http://localhost:8080/](http://localhost:8080/)

**Backend:**
```bash
php yii serve --port=8081 --docroot=backend/web
```
Access at: [http://localhost:8081/](http://localhost:8081/)

- Or configure Apache/Nginx to point the web root to `frontend/web` and `backend/web` for the respective applications.

### 5. Access the application

- Frontend: [http://localhost:8080/](http://localhost:8080/) (if using `php yii serve`)
- Backend: Configure your web server to point to `backend/web` and access via browser.

---

## Environment Variables

The application requires the following environment variables to be set (see the provided `example.env` file for examples):

### SMTP (Email) Configuration

- `SMTP_HOST` - SMTP server hostname
- `SMTP_PORT` - SMTP server port (e.g. 587)
- `SMTP_USER` - SMTP username (used by frontend config/controllers)
- `SMTP_PASS` - SMTP password (used by frontend config/controllers)
- `SMTP_FROM_EMAIL` - Default "from" email address for outgoing mail
- `SMTP_FROM_NAME` - Default "from" name for outgoing mail

### Database Connection (for backend/web/test-db.php)

- `DB_HOST` - Database server hostname
- `DB_NAME` - Database name
- `DB_USER` - Database username
- `DB_PASSWORD` - Database password

### Application URLs

- `FRONTEND_URL` - The base URL for the frontend application (e.g. `http://beyondtube.test`). Used in `common/config/params.php` and `backend/config/params.php` to generate links and references to the frontend from the backend or shared code.
- `BACKEND_URL` - The base URL for the backend application (e.g. `http://studio.beyondtube.test`). Used in `common/config/params.php` to generate links and references to the backend from the frontend or shared code.

These variables allow you to configure how the frontend and backend reference each other, which is especially useful when running in different environments (local, staging, production) or when using custom domains. Set these in your `.env` file to match your local or production setup.

All sensitive credentials and URLs should be set in your `.env` file in the project root. The application will read these variables at runtime for secure configuration.

---

## Optional: Setting up a Virtual Host (Apache Example)

For a more realistic development environment, you can set up Apache virtual hosts to serve the frontend and backend as separate subdomains or paths.

### Example Apache Configuration

Add the following to your Apache `httpd-vhosts.conf` (adjust paths as needed):

```apache
<VirtualHost *:80>
    ServerName beyondtube.test
    DocumentRoot "<path-to-project>/frontend/web"
    <Directory "<path-to-project>/frontend/web">
        AllowOverride All
        Require all granted
    </Directory>
</VirtualHost>

<VirtualHost *:80>
    ServerName studio.beyondtube.test
    DocumentRoot "<path-to-project>/backend/web"
    <Directory "<path-to-project>/backend/web">
        AllowOverride All
        Require all granted
    </Directory>
</VirtualHost>
```

### Update your hosts file

Add these lines to your system's `hosts` file:

```
127.0.0.1 beyondtube.test
127.0.0.1 studio.beyondtube.test
```

- On Windows: `C:\Windows\System32\drivers\etc\hosts`
- On Linux/Mac: `/etc/hosts`

### Restart Apache

After updating the configuration and hosts file, restart Apache. You can now access:
- Frontend: [http://beyondtube.test/](http://beyondtube.test/)
- Backend: [http://studio.beyondtube.test/](http://studio.beyondtube.test/)

---

DIRECTORY STRUCTURE
-------------------

```
common
    config/              contains shared configurations
    mail/                contains view files for e-mails
    models/              contains model classes used in both backend and frontend
    tests/               contains tests for common classes    
console
    config/              contains console configurations
    controllers/         contains console controllers (commands)
    migrations/          contains database migrations
    models/              contains console-specific model classes
    runtime/             contains files generated during runtime
backend
    assets/              contains application assets such as JavaScript and CSS
    config/              contains backend configurations
    controllers/         contains Web controller classes
    models/              contains backend-specific model classes
    runtime/             contains files generated during runtime
    tests/               contains tests for backend application    
    views/               contains view files for the Web application
    web/                 contains the entry script and Web resources
frontend
    assets/              contains application assets such as JavaScript and CSS
    config/              contains frontend configurations
    controllers/         contains Web controller classes
    models/              contains frontend-specific model classes
    runtime/             contains files generated during runtime
    tests/               contains tests for frontend application
    views/               contains view files for the Web application
    web/                 contains the entry script and Web resources
    widgets/             contains frontend widgets
vendor/                  contains dependent 3rd-party packages
environments/            contains environment-based overrides
```
# beyondtube
