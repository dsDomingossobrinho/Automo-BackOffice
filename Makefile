# Automo BackOffice Makefile

.PHONY: help start stop restart logs ps clean build setup network

# Default target
help: ## Show this help message
	@echo "🚀 Automo BackOffice - Available Commands:"
	@echo ""
	@grep -E '^[a-zA-Z_-]+:.*?## .*$$' $(MAKEFILE_LIST) | awk 'BEGIN {FS = ":.*?## "}; {printf "\033[36m%-15s\033[0m %s\n", $$1, $$2}'
	@echo ""

setup: ## Initial setup - create network and directories
	@echo "📋 Setting up Automo BackOffice..."
	@if [ ! -f .env ]; then cp .env.example .env && echo "✅ .env created"; fi
	@docker network inspect automo-network >/dev/null 2>&1 || (docker network create automo-network && echo "✅ Network created")
	@mkdir -p storage/logs public/uploads
	@chmod 755 storage/logs public/uploads
	@echo "✅ Setup completed!"

start: setup ## Start all services
	@echo "🐳 Starting Automo BackOffice..."
	@docker-compose up -d
	@echo "✅ Services started!"
	@echo "📍 Access: http://localhost:3000"

start-backend: setup ## Start with backend integration
	@echo "🔗 Starting with backend integration..."
	@docker-compose -f docker-compose.backend-integration.yml up -d
	@echo "✅ Services started with backend integration!"

stop: ## Stop all services
	@echo "🛑 Stopping services..."
	@docker-compose down
	@echo "✅ Services stopped!"

restart: ## Restart all services
	@make stop
	@make start

build: ## Build containers
	@echo "🔨 Building containers..."
	@docker-compose build
	@echo "✅ Build completed!"

logs: ## Show logs
	@docker-compose logs -f

logs-app: ## Show app logs only
	@docker-compose logs -f backoffice-app

ps: ## Show running containers
	@docker-compose ps

clean: ## Clean containers and volumes
	@echo "🧹 Cleaning up..."
	@docker-compose down -v
	@docker system prune -f
	@echo "✅ Cleanup completed!"

network: ## Create network manually
	@docker network create automo-network || echo "Network already exists"

shell: ## Access app container shell
	@docker-compose exec backoffice-app /bin/bash

redis-cli: ## Access Redis CLI
	@docker-compose exec cache redis-cli

prod: setup ## Start production environment
	@echo "🚀 Starting production environment..."
	@docker-compose --profile production up -d
	@echo "✅ Production services started!"
	@echo "📍 Access: http://localhost:3000"
	@echo "📍 Nginx: http://localhost:8081"

# Development helpers
dev: start logs-app ## Start in development mode with logs

test: ## Run basic connectivity tests
	@echo "🧪 Testing connectivity..."
	@curl -s -o /dev/null -w "BackOffice: %{http_code}\n" http://localhost:3000/login || echo "❌ BackOffice not responding"
	@curl -s -o /dev/null -w "Backend: %{http_code}\n" http://localhost:8080/actuator/health || echo "❌ Backend not responding"
	@docker-compose exec -T cache redis-cli ping || echo "❌ Redis not responding"

status: ## Show status of all services
	@echo "📊 Service Status:"
	@docker-compose ps
	@echo ""
	@echo "🌐 Network Status:"
	@docker network ls | grep automo || echo "❌ automo-network not found"
	@echo ""
	@make test