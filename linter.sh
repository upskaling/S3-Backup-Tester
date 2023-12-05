./vendor/bin/php-cs-fixer fix --allow-risky=yes
./bin/console lint:yaml config --parse-tags
./bin/console lint:twig templates --env=prod
./bin/console lint:xliff translations
./bin/console lint:container --no-debug
./bin/console doctrine:schema:validate --skip-sync -vvv --no-interaction
composer validate --strict
composer audit
./vendor/bin/phpstan analyze
./bin/phpunit