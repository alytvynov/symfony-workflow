db_install: db_cc db_mm db_fixtures

db_rrr: db_drop db_install

cc:
	php bin/console cache:clear --env=dev;

db_r:
	php bin/console -V;
	php bin/console doctrine:schema:drop --full-database --force;
	php bin/console doctrine:migrations:status;
	php bin/console doctrine:migrations:migrate -n;
	#php -d memory_limit=-4048M bin/console doctrine:fixtures:load --env=dev --append --group=dev;

db_drop:
	php bin/console doctrine:database:drop --force;

db_rr: db_ss db_fixtures

db_ss:
	php -d memory_limit=2048M bin/console doctrine:schema:drop --full-database --force;
	php -d memory_limit=2048M bin/console doctrine:migrations:status;
	php -d memory_limit=2048M bin/console doctrine:migrations:migrate -n;

db_create:
	php bin/console doctrine:database:create;

db_m:
	php bin/console make:migration;
	php bin/console doctrine:migrations:migrate;

db_mm:
	php bin/console make:migration;

db_fixtures:
	 php -d memory_limit=4096M bin/console doctrine:fixtures:load --env=dev --append;

server_start:
	php bin/console server:start;

server_stop:
	php bin/console server:stop;
