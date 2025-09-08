#!/bin/bash

echo "🔧 Rebuilding Automo BackOffice with fixes..."

echo "📋 Stopping existing containers..."
docker-compose down -v

echo "🧹 Cleaning up old images..."
docker image rm automo-backoffice-backoffice-app:latest 2>/dev/null || true

echo "🔨 Building new image..."
docker-compose build --no-cache --progress=plain

echo "🚀 Starting services..."
docker-compose up -d

echo "⏳ Waiting for services to start..."
sleep 10

echo "📊 Checking service status..."
docker-compose ps

echo "📜 Checking logs..."
docker-compose logs backoffice-app --tail=20

echo "🧪 Testing access..."
echo "Main page:"
curl -I http://localhost:3000/ 2>/dev/null || echo "❌ Main page not accessible"
echo ""
echo "CSS file:"
curl -I http://localhost:3000/assets/css/app.css 2>/dev/null || echo "❌ CSS not accessible"

echo ""
echo "✅ Rebuild completed!"
echo "📍 Access: http://localhost:3000"
echo "🔧 Test page: http://localhost:3000/test-assets.php"
echo ""
echo "📊 Monitor logs: docker-compose logs -f backoffice-app"
echo "🛑 Stop services: docker-compose down"
echo ""