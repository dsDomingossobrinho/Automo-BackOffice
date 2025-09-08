#!/bin/bash

echo "🔧 Fixing permissions for Automo BackOffice..."

# Fix permissions inside the container
docker-compose exec backoffice-app bash -c "
    echo 'Fixing file permissions...'
    chown -R www-data:www-data /var/www/html
    chmod -R 755 /var/www/html
    chmod -R 755 /var/www/html/public
    chmod -R 755 /var/www/html/public/assets
    chmod -R 775 /var/www/html/storage
    
    echo 'Verifying assets directory...'
    ls -la /var/www/html/public/
    echo ''
    ls -la /var/www/html/public/assets/
    
    echo 'Testing Apache configuration...'
    apache2ctl -t
    
    echo 'Reloading Apache...'
    service apache2 reload
"

echo "✅ Permissions fixed!"
echo "🌐 Test access: http://localhost:3000"