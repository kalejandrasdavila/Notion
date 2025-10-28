#!/bin/bash

echo "=== Production Setup for File Uploads ==="

# 1. Update Nginx configuration
echo "Step 1: Copy the nginx configuration"
echo "Run: sudo cp nginx-site.conf /etc/nginx/sites-available/sistemainfo.lat"
echo ""

# 2. Test and reload Nginx
echo "Step 2: Test and reload Nginx"
echo "Run: sudo nginx -t"
echo "If OK, run: sudo systemctl reload nginx"
echo ""

# 3. Navigate to project directory
echo "Step 3: Navigate to project directory"
cd /var/www/html/Notion/laravel-app

# 4. Create necessary directories
echo "Step 4: Creating storage directories..."
mkdir -p storage/app/public/uploads

# 5. Create storage symlink
echo "Step 5: Creating storage symlink..."
php artisan storage:link

# 6. Set proper permissions
echo "Step 6: Setting permissions..."
sudo chmod -R 775 storage
sudo chmod -R 775 bootstrap/cache
sudo chmod -R 775 storage/app/public
sudo chmod -R 775 storage/app/public/uploads

# 7. Set ownership
echo "Step 7: Setting ownership to www-data..."
sudo chown -R www-data:www-data storage
sudo chown -R www-data:www-data bootstrap/cache
sudo chown -R www-data:www-data public/storage

# 8. Clear Laravel caches
echo "Step 8: Clearing Laravel caches..."
php artisan config:clear
php artisan cache:clear
php artisan route:clear
php artisan view:clear

# 9. Optimize Laravel
echo "Step 9: Optimizing Laravel..."
php artisan config:cache
php artisan route:cache

# 10. Create test file
echo "Step 10: Creating test file..."
echo "Test file content" | sudo tee storage/app/public/test.txt > /dev/null
sudo chown www-data:www-data storage/app/public/test.txt

echo ""
echo "=== Setup Complete! ==="
echo ""
echo "Test your setup by visiting:"
echo "https://sistemainfo.lat/storage/test.txt"
echo ""
echo "If you see 'Test file content', everything is working!"
echo "If you get 404 or Forbidden, check the nginx error logs:"
echo "sudo tail -f /var/log/nginx/error.log"