# 🚀 Guia de Deploy - Automo BackOffice React

## 📋 Índice

1. [Pré-requisitos](#pré-requisitos)
2. [Configuração de Ambiente](#configuração-de-ambiente)
3. [Build de Produção](#build-de-produção)
4. [Deploy com Docker](#deploy-com-docker)
5. [Deploy em Servidores Web](#deploy-em-servidores-web)
6. [Integração com Backend](#integração-com-backend)
7. [Troubleshooting](#troubleshooting)

---

## 🔧 Pré-requisitos

### Software Necessário
- **Node.js**: v18.x ou superior
- **npm**: v9.x ou superior
- **Docker**: v20.x ou superior (opcional)
- **Git**: Para clonagem do repositório

### Verificar Versões
```bash
node --version   # >= v18.0.0
npm --version    # >= 9.0.0
docker --version # >= 20.0.0
```

---

## ⚙️ Configuração de Ambiente

### 1. Variáveis de Ambiente

Crie o arquivo `.env` na raiz do projeto `react-frontend/`:

```env
# API Configuration
VITE_API_BASE_URL=http://localhost:8080

# Application
VITE_APP_NAME=Automo BackOffice
VITE_APP_VERSION=2.0.0

# Environment
NODE_ENV=production
```

### 2. Variáveis por Ambiente

#### Desenvolvimento
```env
VITE_API_BASE_URL=http://localhost:8080
NODE_ENV=development
```

#### Produção
```env
VITE_API_BASE_URL=https://api.automo.com
NODE_ENV=production
```

#### Staging
```env
VITE_API_BASE_URL=https://api-staging.automo.com
NODE_ENV=staging
```

---

## 🏗️ Build de Produção

### 1. Instalar Dependências

```bash
cd react-frontend
npm install --production=false
```

### 2. Executar Build

```bash
npm run build
```

**Output esperado:**
```
✓ 193 modules transformed
dist/index.html                   0.70 kB │ gzip:   0.42 kB
dist/assets/index-CzFi6b20.css   30.74 kB │ gzip:   5.54 kB
dist/assets/index-DN7dTSU5.js   602.56 kB │ gzip: 182.33 kB
✓ built in 6.83s
```

### 3. Verificar Build

```bash
npm run preview
```

Acesse: `http://localhost:4173`

---

## 🐳 Deploy com Docker

### 1. Dockerfile

Crie `react-frontend/Dockerfile`:

```dockerfile
# Multi-stage build
FROM node:18-alpine AS builder

WORKDIR /app

# Copy package files
COPY package*.json ./

# Install dependencies
RUN npm ci --production=false

# Copy source code
COPY . .

# Build application
RUN npm run build

# Production stage
FROM nginx:alpine

# Copy built files
COPY --from=builder /app/dist /usr/share/nginx/html

# Copy nginx configuration
COPY nginx.conf /etc/nginx/conf.d/default.conf

# Expose port
EXPOSE 80

# Health check
HEALTHCHECK --interval=30s --timeout=3s \
  CMD wget --quiet --tries=1 --spider http://localhost || exit 1

CMD ["nginx", "-g", "daemon off;"]
```

### 2. Nginx Configuration

Crie `react-frontend/nginx.conf`:

```nginx
server {
    listen 80;
    server_name localhost;
    root /usr/share/nginx/html;
    index index.html;

    # Gzip compression
    gzip on;
    gzip_vary on;
    gzip_min_length 1024;
    gzip_types text/plain text/css text/xml text/javascript
               application/x-javascript application/xml+rss
               application/javascript application/json;

    # Cache static assets
    location ~* \.(js|css|png|jpg|jpeg|gif|ico|svg|woff|woff2|ttf|eot)$ {
        expires 1y;
        add_header Cache-Control "public, immutable";
    }

    # SPA routing - redirect all requests to index.html
    location / {
        try_files $uri $uri/ /index.html;
    }

    # API proxy (optional)
    location /api {
        proxy_pass http://backend:8080;
        proxy_http_version 1.1;
        proxy_set_header Upgrade $http_upgrade;
        proxy_set_header Connection 'upgrade';
        proxy_set_header Host $host;
        proxy_cache_bypass $http_upgrade;
    }

    # Security headers
    add_header X-Frame-Options "DENY" always;
    add_header X-Content-Type-Options "nosniff" always;
    add_header X-XSS-Protection "1; mode=block" always;
    add_header Referrer-Policy "no-referrer-when-downgrade" always;
}
```

### 3. Docker Compose

Crie `react-frontend/docker-compose.yml`:

```yaml
version: '3.8'

services:
  frontend:
    build:
      context: .
      dockerfile: Dockerfile
    container_name: automo-frontend
    ports:
      - "3000:80"
    environment:
      - VITE_API_BASE_URL=http://localhost:8080
    networks:
      - automo-network
    restart: unless-stopped

networks:
  automo-network:
    external: true
```

### 4. Build e Run Docker

```bash
# Build image
docker build -t automo-frontend:latest .

# Run container
docker-compose up -d

# View logs
docker-compose logs -f

# Stop
docker-compose down
```

---

## 🌐 Deploy em Servidores Web

### Apache

#### 1. Build e Copy

```bash
npm run build
cp -r dist/* /var/www/html/automo/
```

#### 2. Apache Configuration

```apache
<VirtualHost *:80>
    ServerName automo.com
    DocumentRoot /var/www/html/automo

    <Directory /var/www/html/automo>
        Options -Indexes +FollowSymLinks
        AllowOverride All
        Require all granted

        # SPA Routing
        RewriteEngine On
        RewriteBase /
        RewriteRule ^index\.html$ - [L]
        RewriteCond %{REQUEST_FILENAME} !-f
        RewriteCond %{REQUEST_FILENAME} !-d
        RewriteRule . /index.html [L]
    </Directory>

    # Gzip Compression
    <IfModule mod_deflate.c>
        AddOutputFilterByType DEFLATE text/html text/plain text/xml text/css text/javascript application/javascript application/json
    </IfModule>

    # Cache Control
    <IfModule mod_expires.c>
        ExpiresActive On
        ExpiresByType image/jpg "access plus 1 year"
        ExpiresByType image/jpeg "access plus 1 year"
        ExpiresByType image/gif "access plus 1 year"
        ExpiresByType image/png "access plus 1 year"
        ExpiresByType text/css "access plus 1 month"
        ExpiresByType application/javascript "access plus 1 month"
    </IfModule>
</VirtualHost>
```

### Nginx

#### 1. Build e Copy

```bash
npm run build
cp -r dist/* /var/www/automo/
```

#### 2. Nginx Configuration

```nginx
server {
    listen 80;
    server_name automo.com;
    root /var/www/automo;
    index index.html;

    location / {
        try_files $uri $uri/ /index.html;
    }

    # Static assets caching
    location ~* \.(js|css|png|jpg|jpeg|gif|ico|svg)$ {
        expires 1y;
        add_header Cache-Control "public, immutable";
    }
}
```

---

## 🔗 Integração com Backend

### 1. Endpoints Necessários

O frontend React espera os seguintes endpoints do backend:

#### Autenticação
```
POST   /auth/login/backoffice/request-otp
POST   /auth/login/backoffice/verify-otp
POST   /auth/forgot-password
POST   /auth/reset-password
```

#### Clientes
```
GET    /clients
GET    /clients/:id
POST   /clients
PUT    /clients/:id
DELETE /clients/:id
```

#### Mensagens
```
GET    /messages
GET    /messages/:id
POST   /messages
PUT    /messages/:id
DELETE /messages/:id
PATCH  /messages/:id/read
GET    /messages/stats
```

#### Finanças
```
GET    /finances/transactions
GET    /finances/transactions/:id
POST   /finances/transactions
PUT    /finances/transactions/:id
DELETE /finances/transactions/:id
GET    /finances/summary
GET    /finances/transactions/export
```

#### Faturas
```
GET    /invoices
GET    /invoices/:id
POST   /invoices
PUT    /invoices/:id
DELETE /invoices/:id
POST   /invoices/:id/send
GET    /invoices/:id/pdf
GET    /invoices/summary
```

#### Contas
```
GET    /accounts
GET    /accounts/:id
POST   /accounts
PUT    /accounts/:id
DELETE /accounts/:id
PATCH  /accounts/:id/status
PATCH  /accounts/:id/permissions
GET    /accounts/summary
```

### 2. CORS Configuration

O backend deve permitir requests do frontend:

```javascript
// Backend CORS config
const corsOptions = {
  origin: ['http://localhost:5173', 'https://automo.com'],
  credentials: true,
  methods: ['GET', 'POST', 'PUT', 'DELETE', 'PATCH'],
  allowedHeaders: ['Content-Type', 'Authorization']
};
```

### 3. JWT Token

- Token armazenado em `localStorage` com chave `auth_token`
- Enviado em todas as requests via header: `Authorization: Bearer <token>`
- Timeout de sessão: 4 horas (configurável)

---

## 🐛 Troubleshooting

### Build Errors

**Problema:** `Module not found`
```bash
# Solução
rm -rf node_modules package-lock.json
npm install
npm run build
```

**Problema:** `Out of memory`
```bash
# Solução
export NODE_OPTIONS="--max-old-space-size=4096"
npm run build
```

### Runtime Errors

**Problema:** API calls failing (CORS)
- Verificar configuração CORS no backend
- Verificar `VITE_API_BASE_URL` no `.env`

**Problema:** 404 em rotas SPA
- Verificar configuração do servidor web (Apache/Nginx)
- Garantir que `try_files` redireciona para `index.html`

**Problema:** Token expired
- Verificar `SESSION_LIFETIME` no backend
- Implementar refresh token se necessário

### Docker Issues

**Problema:** Container não inicia
```bash
# Ver logs
docker logs automo-frontend

# Verificar porta em uso
lsof -i :3000
```

**Problema:** Build lento
```bash
# Usar cache do Docker
docker build --cache-from automo-frontend:latest -t automo-frontend:latest .
```

---

## 📊 Performance Checklist

- [ ] Gzip compression habilitado
- [ ] Cache headers configurados
- [ ] CDN para assets estáticos (opcional)
- [ ] Lazy loading implementado (futuro)
- [ ] Bundle size otimizado (<200KB gzipped)
- [ ] API response caching (TanStack Query)
- [ ] Images otimizadas
- [ ] HTTP/2 habilitado no servidor

---

## 🔐 Security Checklist

- [ ] HTTPS obrigatório em produção
- [ ] Security headers configurados
- [ ] CORS restrito a domínios válidos
- [ ] JWT tokens com expiração
- [ ] XSS protection (React built-in)
- [ ] CSRF tokens em requests
- [ ] Input validation no frontend e backend
- [ ] Secrets em variáveis de ambiente

---

## 📈 Monitoring

### Health Check Endpoint

```bash
# Verificar se aplicação está rodando
curl http://localhost:3000

# Deve retornar 200 OK e HTML
```

### Logs

```bash
# Docker
docker logs -f automo-frontend

# Nginx
tail -f /var/log/nginx/access.log
tail -f /var/log/nginx/error.log
```

---

## 🎯 Próximos Passos

1. Configure ambiente de staging
2. Implemente CI/CD pipeline
3. Configure monitoring e alertas
4. Documente processo de rollback
5. Crie backup strategy
6. Implemente feature flags (opcional)

---

**Última atualização:** Janeiro 2025
**Versão:** 2.0.0
