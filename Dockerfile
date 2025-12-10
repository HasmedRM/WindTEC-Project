# Multi-stage Dockerfile for Laravel + Vite (production)
# Stage 1: build frontend (Vite)
FROM node:18-bullseye AS node_builder
WORKDIR /app
# copy package files and install deps
COPY package*.json ./
RUN npm ci --ignore-scripts
# Copy the rest of the project into the node builder (respects `.dockerignore`).
# We keep the earlier `package*.json` copy + `npm ci` to leverage Docker cache,
# then copy the remaining files required for the Vite build and run the build.
COPY . .
# ensure .env.build to avoid errors if build references env variables (optional)
# build assets (assumes `npm run build` writes to `public/build`)
RUN npm run build

# Stage 2: install PHP deps (composer) and prepare application
FROM php:8.4-fpm-bullseye AS php_builder
WORKDIR /app

# install system dependencies required for ext installations
RUN apt-get update \
    && apt-get install -y --no-install-recommends \
        git \
        unzip \
        ca-certificates \
        libzip-dev \
        libpng-dev \
        libjpeg-dev \
        libfreetype6-dev \
        libonig-dev \
        libxml2-dev \
        libpq-dev \
        zip \
        curl \
    && rm -rf /var/lib/apt/lists/*

# configure and install PHP extensions
RUN docker-php-ext-configure gd --with-jpeg --with-freetype \
    && docker-php-ext-install -j$(nproc) gd pdo pdo_mysql pdo_pgsql zip bcmath opcache

# install composer
COPY --from=composer:2 /usr/bin/composer /usr/bin/composer

# copy composer files and install PHP dependencies
COPY composer.json composer.lock ./
RUN composer install --no-dev --optimize-autoloader --no-interaction --prefer-dist

# copy the application source
COPY . ./
# copy built frontend from node_builder (if present)
# npm run build should create "public/build" — copy if exists
COPY --from=node_builder /app/public /app/public

# remove dev artifacts and caches that shouldn't be in final image
RUN rm -rf node_modules src tests

# Stage 3: final image with nginx + php-fpm
FROM php:8.4-fpm-bullseye
WORKDIR /var/www/html

# Install runtime packages (nginx + supervisor to run both processes)
RUN apt-get update \
    && apt-get install -y --no-install-recommends \
        nginx \
        supervisor \
        procps \
    && rm -rf /var/lib/apt/lists/*

# PHP extensions (reinstall if needed)
RUN apt-get update \
    && apt-get install -y --no-install-recommends \
        libzip-dev \
        libpng-dev \
        libjpeg-dev \
        libfreetype6-dev \
        libonig-dev \
        libxml2-dev \
        libpq-dev \
    && docker-php-ext-configure gd --with-jpeg --with-freetype \
    && docker-php-ext-install -j$(nproc) gd pdo pdo_mysql pdo_pgsql zip bcmath opcache \
    && rm -rf /var/lib/apt/lists/*

# Copy application from builder
COPY --from=php_builder /app /var/www/html

# copy nginx and supervisor configuration
COPY docker/nginx.conf /etc/nginx/sites-available/default
COPY docker/supervisord.conf /etc/supervisor/conf.d/supervisord.conf

# create storage/logs and bootstrap cache directories and set permissions
RUN mkdir -p /var/www/html/storage /var/www/html/bootstrap/cache \
    && chown -R www-data:www-data /var/www/html

# expose port
EXPOSE 80

# healthcheck (optional)
HEALTHCHECK --interval=30s --timeout=10s --start-period=20s --retries=3 CMD curl -f http://localhost/ || exit 1

# run supervisord (will start nginx and php-fpm)
CMD ["/usr/bin/supervisord","-n","-c","/etc/supervisor/conf.d/supervisord.conf"]
