@echo off
echo ============================================
echo  Starting Laravel Development Server
echo ============================================
cd /d "C:\xampp\htdocs\CS2TP_G56"

echo.
echo Checking XAMPP MySQL is running...
C:\xampp\mysql\bin\mysqladmin.exe -u root ping >nul 2>&1
if %ERRORLEVEL% NEQ 0 (
    echo.
    echo ERROR: XAMPP MySQL is not running!
    echo.
    echo To fix this:
    echo   1. Open the XAMPP Control Panel
    echo   2. Click Start next to MySQL
    echo.
    echo If MySQL starts then stops immediately, run fix_mysql.bat
    echo to diagnose and fix port conflicts.
    echo.
    pause
    exit /b 1
)
echo MySQL is running.

echo.
echo Checking .env file...
if not exist ".env" (
    echo WARNING: .env file not found. Copying from .env.example...
    copy ".env.example" ".env"
    php artisan key:generate
    echo .env created. You may need to run setup.bat to create the database.
)

echo.
echo Starting PHP server at http://localhost:8000
echo Starting Vite dev server...
echo.
echo Press Ctrl+C to stop.
echo.

:: Run both servers concurrently
start "Vite Dev Server" cmd /k "npm run dev"
php artisan serve
