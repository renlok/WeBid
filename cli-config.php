<?php
// cli-config.php
require_once "vendor/autoload.php";

$settings = include 'config/connection.php';

$config = \Doctrine\ORM\Tools\Setup::createAnnotationMetadataConfiguration(
    $settings['meta']['entity_path'],
    $settings['meta']['auto_generate_proxies'],
    $settings['meta']['proxy_dir'],
    $settings['meta']['cache'],
    false
);

$entityManager = \Doctrine\ORM\EntityManager::create($settings['connection'], $config);

return \Doctrine\ORM\Tools\Console\ConsoleRunner::createHelperSet($entityManager);