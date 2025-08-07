#!/bin/bash
set -e

echo "➤ Caching config..."
php artisan config:cache

echo "➤ Clearing views..."
php artisan view:clear

echo "➤ Clearing routes..."
php artisan route:clear


echo "➤ Creating session table (if needed)..."
php artisan session:table || echo "Session table already exists or skipped"

echo "➤ Running migrations..."
until php artisan migrate:fresh; do
  echo "⚠️ Waiting for the database to be ready..."
  sleep 3
done

echo "➤ Seeding database..."
php artisan db:seed --force

echo "➤ Linking storage..."
php artisan storage:link

echo "➤ Generating Swagger documentation..."
php artisan l5-swagger:generate || echo "⚠️ Swagger generation failed (check annotations?)"

echo "✅ Starting Apache..."
exec apache2-foreground