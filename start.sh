#!/bin/bash

echo "🚀 Starting Automo BackOffice..."

# Check if .env exists, if not create from example
if [ ! -f .env ]; then
    echo "📋 Creating .env file from example..."
    cp .env.example .env
    echo "✅ .env file created. Please review and update settings if needed."
fi

# Check if automo-network exists
if ! docker network inspect automo-network >/dev/null 2>&1; then
    echo "🌐 Creating automo-network..."
    docker network create automo-network
    echo "✅ Network created successfully."
else
    echo "✅ Network automo-network already exists."
fi

# Create necessary directories
echo "📁 Creating necessary directories..."
mkdir -p storage/logs
mkdir -p public/uploads
chmod 755 storage/logs
chmod 755 public/uploads

# Start services
echo "🐳 Starting Docker containers..."

# Check if we should use backend integration
if [ "$1" = "--with-backend" ]; then
    echo "🔗 Using backend integration mode..."
    docker-compose -f docker-compose.backend-integration.yml up -d
else
    echo "🏠 Using standalone mode..."
    docker-compose up -d
fi

echo ""
echo "✅ Automo BackOffice started successfully!"
echo ""
echo "📍 Access points:"
echo "   - BackOffice: http://localhost:3000"
echo "   - Backend API: http://localhost:8080 (must be running separately)"
echo "   - Redis Cache: localhost:6379"
echo ""
echo "📊 Check status:"
echo "   docker-compose ps"
echo ""
echo "📜 View logs:"
echo "   docker-compose logs -f backoffice-app"
echo ""
echo "🛑 Stop services:"
echo "   docker-compose down"
echo ""