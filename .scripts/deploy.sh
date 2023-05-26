#!/bin/bash
set -e

echo "Deployment started ..."

# Enter maintenance mode or return true
# if already is in maintenance mode
(php82 artisan down) || true

# Pull the latest version of the app
#git pull minega main

# Install composer dependencies
php82 ~/composer.phar install
# Clear the old cache
php82 artisan clear-compiled

# Recreate cache
php82 artisan optimize

# Run database migrations
php82 artisan migrate --force

# Run database migrations
php82 artisan db:seed --force

# Exit maintenance mode
php82 artisan up

echo "Deployment finished!"