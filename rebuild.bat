@echo off
echo 🔧 Rebuilding Automo BackOffice with fixes...

echo 📋 Stopping existing containers...
docker-compose down -v

echo 🧹 Cleaning up old images...
docker image rm automo-backoffice-backoffice-app:latest 2>nul

echo 🔨 Building new image...
docker-compose build --no-cache --progress=plain

echo 🚀 Starting services...
docker-compose up -d

echo ⏳ Waiting for services to start...
timeout /t 10 /nobreak >nul

echo 📊 Checking service status...
docker-compose ps

echo 📜 Checking logs...
docker-compose logs backoffice-app --tail=20

echo 🧪 Testing access...
curl -I http://localhost:3000/ 2>nul
curl -I http://localhost:3000/assets/css/app.css 2>nul

echo.
echo ✅ Rebuild completed!
echo 📍 Access: http://localhost:3000
echo 🔧 Test page: http://localhost:3000/test-assets.php
echo.
echo 📊 Monitor logs: docker-compose logs -f backoffice-app
echo 🛑 Stop services: docker-compose down
echo.
pause