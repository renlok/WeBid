Naming convention:

PHP
* Variables: camalCase
* functions: camalCase
* classes: CamalCase

MySQL
* tables: plural/collective names, use underscores

DB Changes:
* accesseshistoric -> viewing_statistics
* counters moved to settings
* lots of others...


TODO
* everything



INSTALL
1. php vendor/doctrine/orm/bin/doctrine orm:schema-tool:create

UPDATE
1. php vendor/doctrine/orm/bin/doctrine orm:schema-tool:update