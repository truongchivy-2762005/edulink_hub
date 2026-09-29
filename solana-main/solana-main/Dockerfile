FROM php:8.3-cli

# Install system dependencies & PHP extensions
RUN apt-get update && apt-get install -y \
    libpng-dev \
    libonig-dev \
    libxml2-dev \
    zip \
    unzip \
    git \
    curl \
    && docker-php-ext-install pdo_mysql mbstring bcmath

# Get latest Composer
COPY --from=composer:latest /usr/bin/composer /usr/bin/composer

WORKDIR /app

# Copy all project files into container
COPY . .

# Smart detection: Locate composer.json and move Laravel files to /app root
RUN if [ -f "composer.json" ]; then \
        echo "==> composer.json found in current directory"; \
    elif [ -f "EduLink Hub/composer.json" ]; then \
        echo "==> Moving EduLink Hub contents to /app"; \
        cp -r "EduLink Hub/"* ./ && cp -r "EduLink Hub/".* ./ 2>/dev/null || true; \
    elif [ -f "solana-main/solana-main/EduLink Hub/composer.json" ]; then \
        echo "==> Moving nested EduLink Hub contents to /app"; \
        cp -r "solana-main/solana-main/EduLink Hub/"* ./ && cp -r "solana-main/solana-main/EduLink Hub/".* ./ 2>/dev/null || true; \
    fi

# Install PHP dependencies with --ignore-platform-reqs for Laravel 12 compatibility
RUN composer install --no-dev --optimize-autoloader --ignore-platform-reqs

# Set permissions for Laravel
RUN chmod -R 777 storage bootstrap/cache

# Expose Render default port
EXPOSE 10000

# Start command (skip db:seed to prevent duplicate entry errors)
CMD php artisan config:clear && php artisan cache:clear && php artisan migrate --force && php artisan serve --host=0.0.0.0 --port=${PORT:-10000}
