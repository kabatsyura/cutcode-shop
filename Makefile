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

# NOTE: for me, what I've installed
install-starter:
	composer require barryvdh/laravel-debugbar --dev
	composer require laravel/telescope
	./vendor/bin/sail telescope:install
	./vendor/bin/sail migrate
	npm install -D taillwindcss
	npm install @tailwindcss/line-clamp
	npm install sass
