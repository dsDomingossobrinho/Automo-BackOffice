# Automo BackOffice - Deployment Guide

## 🔧 Environment Configurations

### Development (Local)
```bash
# Simplified Docker setup - only PHP/Apache container
docker-compose up -d
```
- **Frontend**: http://localhost:3000
- **Backend**: Auto-detected via Docker Gateway (172.17.0.1:8080)
- **Sessions**: File-based storage in `storage/sessions/`
- **Debug Mode**: Enabled

### Production (Hosting)
```bash
# Use production configuration with Nginx SSL termination
docker-compose -f docker-compose.prod.yml up -d
```
- **Frontend**: Your domain (configure BASE_URL)
- **Backend**: Your backend URL (configure API_BASE_URL)
- **Sessions**: File-based storage in `storage/sessions/`
- **SSL**: Nginx with certificates
- **Debug Mode**: Disabled

## 📝 Environment Variables

### Required for Production
```env
# .env.production
DEBUG_MODE=false
BASE_URL=https://your-domain.com
API_BASE_URL=https://your-backend-domain.com
```

### Optional Configuration
```env
API_TIMEOUT=30
SESSION_LIFETIME=14400
UPLOAD_MAX_SIZE=5242880
```

## 🚀 Deployment Steps

### 1. Local Development
```bash
# Clone and setup
git clone <repo>
cd Automo-BackOffice

# Start development environment
docker-compose up -d

# Access: http://localhost:3000
```

### 2. Production Deployment
```bash
# Create production environment file
cp .env.production .env

# Edit with your actual URLs
nano .env

# Deploy with production configuration
docker-compose -f docker-compose.prod.yml up -d

# Setup SSL certificates in docker/ssl/
```

### 3. Environment Auto-Detection

The application automatically detects the environment:

- **Development**: Uses Docker Gateway (172.17.0.1:8080)
- **Production**: Uses configured API_BASE_URL
- **Container**: Auto-detects Docker environment
- **Local**: Falls back to localhost:8080

## 🔄 Migration from Development to Production

No code changes needed! Just:

1. Update environment variables
2. Use production docker-compose file
3. Configure SSL certificates
4. Set proper domain names

## 🐛 Troubleshooting

### Development Issues
```bash
# Check network connectivity
docker-compose exec backoffice-app curl -s http://172.17.0.1:8080/health

# View logs
docker-compose logs -f backoffice-app
```

### Production Issues
```bash
# Check production connectivity
docker-compose -f docker-compose.prod.yml exec backoffice-app curl -s $API_BASE_URL/health

# View production logs
docker-compose -f docker-compose.prod.yml logs -f backoffice-app
docker-compose -f docker-compose.prod.yml logs -f nginx
```

## 📊 Network Architecture

### Development
```
Frontend (localhost:3000) 
    ↓ AJAX
BackOffice Container 
    ↓ HTTP via 172.17.0.1:8080 (Docker Gateway)
Backend Container (automo-app)
```

### Production
```
Internet
    ↓ HTTPS
Nginx (SSL Termination)
    ↓ HTTP
BackOffice Container
    ↓ HTTPS/HTTP
External Backend API
```

## 🔒 Security

### Development
- Debug mode enabled
- HTTP connections
- Docker Gateway access

### Production
- Debug mode disabled
- HTTPS enforced
- SSL certificates required
- Security headers enabled
- File-based session storage

## ✅ Production Checklist

Before deploying to production:

1. **Environment File**: Copy and configure `.env.production`
2. **SSL Certificates**: Place `cert.pem` and `key.pem` in `docker/ssl/`
3. **Domain Configuration**: Update `BASE_URL` and `API_BASE_URL`
4. **Firewall**: Ensure ports 80 and 443 are open
5. **Storage Permissions**: Ensure write access to `storage/logs/` and `storage/sessions/`
6. **Monitoring**: Set up log monitoring for `storage/logs/`

## 📋 Network Isolation

### Local Development Network
- Uses external networks: `automo-network` and `automo-backend_automo-network`
- Shares network with backend containers
- Port 3000 for easy access

### Production Network  
- Uses dedicated `backoffice-network`
- Completely isolated from development
- Nginx handles SSL termination and reverse proxy
- No network conflicts with other services