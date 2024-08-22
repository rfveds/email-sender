# Start the Docker services
start:
	docker-compose up -d

# Stop the Docker services
stop:
	docker-compose down

# Build the Docker images
build:
	docker-compose build

# Install PHP dependencies using Composer
composer-install:
	docker-compose exec php bash -c "cd app && composer install"

# Run database migrations
migrate:
	docker-compose exec php bash -c "cd app &&  php bin/console doctrine:migrations:migrate --no-interaction"

# Load database fixtures
fixtures:
	docker-compose exec php bash -c "cd app &&  php bin/console doctrine:fixtures:load --no-interaction"

## Run tests
#test:
#	docker-compose run --rm php ./vendor/bin/phpunit


