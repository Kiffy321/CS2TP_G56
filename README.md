# Regulus Jewelry Store

A Laravel-based e-commerce application for a jewelry store, designed to run with XAMPP on Windows.

## XAMPP Setup (Windows)

### Prerequisites
- [XAMPP](https://www.apachefriends.org/) installed at `C:\xampp`
- PHP 8.2+ (included with XAMPP)
- [Composer](https://getcomposer.org/)
- [Node.js](https://nodejs.org/) and npm

### Step-by-Step Setup

1. **Place the project in XAMPP's htdocs folder:**
   ```
   C:\xampp\htdocs\CS2TP_G56
   ```

2. **Start XAMPP MySQL:**
   - Open the XAMPP Control Panel
   - Click **Start** next to **MySQL**
   - Wait until the status shows green / "Running"

3. **Enable `pdo_mysql` in PHP:**
   - Open `C:\xampp\php\php.ini` in a text editor
   - Find the line `;extension=pdo_mysql`
   - Remove the leading `;` to uncomment it: `extension=pdo_mysql`
   - Save the file and restart Apache in XAMPP Control Panel

4. **Install PHP dependencies:**
   ```cmd
   cd C:\xampp\htdocs\CS2TP_G56
   composer install
   ```

5. **Run the setup script:**
   Double-click `setup.bat` (or run it from the command prompt):
   ```cmd
   setup.bat
   ```
   This will:
   - Copy `.env.example` to `.env`
   - Generate the application key
   - Create the `regulus_jewelry` MySQL database
   - Run database migrations and seeders
   - Install npm dependencies and build frontend assets

6. **Start the development server:**
   Double-click `start_dev.bat`:
   ```cmd
   start_dev.bat
   ```

7. **Visit the application at:** http://localhost:8000

---

### Troubleshooting

**MySQL is not running:**
- Open XAMPP Control Panel and click **Start** next to **MySQL**.

**MySQL starts then immediately stops (most common issue):**
- This is almost always a **port 3306 conflict** with a separate MySQL/MySQL80 Windows service.
- Run `fix_mysql.bat` — it detects what is blocking port 3306 and shows three fix options:
  - **Option A (recommended):** Open `services.msc`, find the `MySQL` or `MySQL80` service, stop it and set it to Manual startup, then start XAMPP MySQL.
  - **Option B:** Change XAMPP MySQL to port 3307 by editing `C:\xampp\mysql\bin\my.ini` and setting `DB_PORT=3307` in your `.env` file.
  - **Option C:** Kill the conflicting process by PID using `taskkill /PID [number] /F`.

**`pdo_mysql` extension not found:**
- Edit `C:\xampp\php\php.ini`, find `;extension=pdo_mysql`, remove the `;` and restart Apache.

**Migration fails with "Access denied":**
- Check `DB_USERNAME` and `DB_PASSWORD` in your `.env` file match your XAMPP MySQL credentials (default: username `root`, password empty).

**Database does not exist:**
- Run manually: open XAMPP Control Panel → MySQL → Admin (phpMyAdmin), then create a database named `regulus_jewelry`.
- Or run: `php artisan migrate --force` after the database is created.

**After pulling new code updates:**
- If MySQL is running but the app breaks after a `git pull`, run: `php artisan migrate --force` to apply any new database migrations.

---

## About Laravel

Laravel is a web application framework with expressive, elegant syntax. We believe development must be an enjoyable and creative experience to be truly fulfilling. Laravel takes the pain out of development by easing common tasks used in many web projects, such as:

- [Simple, fast routing engine](https://laravel.com/docs/routing).
- [Powerful dependency injection container](https://laravel.com/docs/container).
- Multiple back-ends for [session](https://laravel.com/docs/session) and [cache](https://laravel.com/docs/cache) storage.
- Expressive, intuitive [database ORM](https://laravel.com/docs/eloquent).
- Database agnostic [schema migrations](https://laravel.com/docs/migrations).
- [Robust background job processing](https://laravel.com/docs/queues).
- [Real-time event broadcasting](https://laravel.com/docs/broadcasting).

Laravel is accessible, powerful, and provides tools required for large, robust applications.

## Learning Laravel

Laravel has the most extensive and thorough [documentation](https://laravel.com/docs) and video tutorial library of all modern web application frameworks, making it a breeze to get started with the framework. You can also check out [Laravel Learn](https://laravel.com/learn), where you will be guided through building a modern Laravel application.

If you don't feel like reading, [Laracasts](https://laracasts.com) can help. Laracasts contains thousands of video tutorials on a range of topics including Laravel, modern PHP, unit testing, and JavaScript. Boost your skills by digging into our comprehensive video library.

## Laravel Sponsors

We would like to extend our thanks to the following sponsors for funding Laravel development. If you are interested in becoming a sponsor, please visit the [Laravel Partners program](https://partners.laravel.com).

### Premium Partners

- **[Vehikl](https://vehikl.com)**
- **[Tighten Co.](https://tighten.co)**
- **[Kirschbaum Development Group](https://kirschbaumdevelopment.com)**
- **[64 Robots](https://64robots.com)**
- **[Curotec](https://www.curotec.com/services/technologies/laravel)**
- **[DevSquad](https://devsquad.com/hire-laravel-developers)**
- **[Redberry](https://redberry.international/laravel-development)**
- **[Active Logic](https://activelogic.com)**

## Contributing

Thank you for considering contributing to the Laravel framework! The contribution guide can be found in the [Laravel documentation](https://laravel.com/docs/contributions).

## Code of Conduct

In order to ensure that the Laravel community is welcoming to all, please review and abide by the [Code of Conduct](https://laravel.com/docs/contributions#code-of-conduct).

## Security Vulnerabilities

If you discover a security vulnerability within Laravel, please send an e-mail to Taylor Otwell via [taylor@laravel.com](mailto:taylor@laravel.com). All security vulnerabilities will be promptly addressed.

## License

The Laravel framework is open-sourced software licensed under the [MIT license](https://opensource.org/licenses/MIT).
