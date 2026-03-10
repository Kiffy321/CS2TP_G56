@echo off
echo ============================================
echo  XAMPP MySQL Diagnostic and Fix Tool
echo ============================================
echo.
echo This script helps fix MySQL stopping on startup.
echo The most common cause is a port 3306 conflict.
echo.

echo [1] Checking what is using port 3306...
netstat -aon | findstr ":3306" >nul 2>&1
if %ERRORLEVEL% EQU 0 (
    echo Port 3306 is in use by:
    netstat -aon | findstr ":3306"
    echo.
    echo If you see a PID that is NOT from XAMPP MySQL, a separate MySQL
    echo service is conflicting. See OPTION A or OPTION B below.
) else (
    echo Port 3306 is free. MySQL should be able to start.
    echo Try starting MySQL from the XAMPP Control Panel now.
    pause
    exit /b 0
)

echo.
echo ============================================
echo  COMMON FIX OPTIONS
echo ============================================
echo.
echo OPTION A - Stop the conflicting Windows MySQL service (recommended):
echo   1. Press Win+R, type: services.msc, press Enter
echo   2. Find "MySQL" or "MySQL80" in the list
echo   3. Right-click it and select "Stop"
echo   4. Right-click it and select "Properties"
echo   5. Set "Startup type" to "Manual" so it does not start again
echo   6. Now start MySQL from the XAMPP Control Panel
echo.
echo OPTION B - Change XAMPP MySQL to use port 3307 instead:
echo   1. Open C:\xampp\mysql\bin\my.ini in a text editor
echo   2. Find the line: port=3306
echo   3. Change it to: port=3307
echo   4. Save the file
echo   5. Update your .env file: DB_PORT=3307
echo   6. Restart MySQL from the XAMPP Control Panel
echo.
echo OPTION C - Kill the conflicting process (temporary fix):
echo   Run this command as Administrator to find and kill the PID shown above:
echo   taskkill /PID [PID_NUMBER] /F
echo.
pause