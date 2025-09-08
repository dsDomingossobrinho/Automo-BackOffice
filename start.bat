@echo off
echo 🚀 Starting Automo BackOffice...

REM Check if .env exists, if not create from example
if not exist .env (
    echo 📋 Creating .env file from example...
    copy .env.example .env
    echo ✅ .env file created. Please review and update settings if needed.
)

REM Create necessary directories
echo 📁 Creating necessary directories...
if not exist storage\logs mkdir storage\logs
if not exist public\uploads mkdir public\uploads

REM Check if automo-network exists
docker network inspect automo-network >nul 2>&1
if %errorlevel% neq 0 (
    echo 🌐 Creating automo-network...
    docker network create automo-network
    echo ✅ Network created successfully.
) else (
    echo ✅ Network automo-network already exists.
)

REM Start services
echo 🐳 Starting Docker containers...

if "%1"=="--with-backend" (
    echo 🔗 Using backend integration mode...
    docker-compose -f docker-compose.backend-integration.yml up -d
) else (
    echo 🏠 Using standalone mode...
    docker-compose up -d
)

echo.
echo ✅ Automo BackOffice started successfully!
echo.
echo 📍 Access points:
echo    - BackOffice: http://localhost:3000
echo    - Backend API: http://localhost:8080 (must be running separately)
echo    - Redis Cache: localhost:6379
echo.
echo 📊 Check status:
echo    docker-compose ps
echo.
echo 📜 View logs:
echo    docker-compose logs -f backoffice-app
echo.
echo 🛑 Stop services:
echo    docker-compose down
echo.
pause