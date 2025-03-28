up:
	./vendor/bin/sail up

stop:
	./vendor/bin/sail stop

tinker:
	./vendor/bin/sail artisan tinker

lint-fix:
	composer exec php-cs-fixer fix -- --diff --dry-run -v
	# php vendor/bin/php-cs-fixer fix --dry-run -v

migrate:
	./vendor/bin/sail artisan migrate

migrate-fresh:
	./vendor/bin/sail artisan migrate:fresh

shell:
	./vendor/bin/sail bash

down:
	./vendor/bin/sail down

test:
	./vendor/bin/sail artisan test

prepare-test:
	echo "Preparing test environment..."
	./vendor/bin/sail up -d
	./vendor/bin/sail exec mysql \
		mysql -u root -ppassword -e " \
			CREATE DATABASE IF NOT EXISTS cutcode_shop_test; \
			GRANT ALL PRIVILEGES ON cutcode_shop_test.* TO 'sail'@'%'; \
			FLUSH PRIVILEGES; \
		"
	./vendor/bin/sail artisan migrate:fresh --env=testing
	SEEDS_IMPORT=1 ./vendor/bin/sail artisan db:seed --env=testing
	@echo "✓ Test environment ready!"

# NOTE: for me, what I've installed
install-starter:
	composer require barryvdh/laravel-debugbar --dev
	composer require laravel/telescope
	./vendor/bin/sail telescope:install
	./vendor/bin/sail migrate
	npm install -D taillwindcss
	npm install @tailwindcss/line-clamp
	npm install sass
