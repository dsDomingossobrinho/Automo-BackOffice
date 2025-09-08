# SSL Certificates for Production

Place your SSL certificates in this directory for production deployment.

## Required Files

- `cert.pem` - Your SSL certificate (or certificate chain)
- `key.pem` - Your private key

## Getting SSL Certificates

### Option 1: Let's Encrypt (Free)
```bash
# Using certbot
certbot certonly --webroot -w /var/www/html/public -d your-domain.com

# Copy certificates
cp /etc/letsencrypt/live/your-domain.com/fullchain.pem ./docker/ssl/cert.pem
cp /etc/letsencrypt/live/your-domain.com/privkey.pem ./docker/ssl/key.pem
```

### Option 2: Self-signed (Development/Testing)
```bash
# Generate self-signed certificate (for testing only)
openssl req -x509 -nodes -days 365 -newkey rsa:2048 \
  -keyout ./docker/ssl/key.pem \
  -out ./docker/ssl/cert.pem \
  -subj "/C=US/ST=State/L=City/O=Organization/CN=localhost"
```

### Option 3: Commercial Certificate
1. Generate Certificate Signing Request (CSR)
2. Purchase certificate from CA (Sectigo, DigiCert, etc.)
3. Download and place files as `cert.pem` and `key.pem`

## File Permissions

Ensure proper permissions for security:
```bash
chmod 600 ./docker/ssl/key.pem
chmod 644 ./docker/ssl/cert.pem
```

## Production Deployment

After placing certificates, deploy with:
```bash
docker-compose -f docker-compose.prod.yml up -d
```

The nginx service will automatically use these certificates for HTTPS.