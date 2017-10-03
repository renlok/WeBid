<?php

$config = [
    'settings' => [
        'displayErrorDetails' => true,
    ],
];
$app = new \Slim\App($config);

// Get container
$container = $app->getContainer();

// Register component on container
$container['view'] = function ($container) {
    $view = new \Slim\Views\Twig('../templates', [
        'cache' => '../cache/templates'
    ]);

    // Instantiate and add Slim specific extension
    $basePath = rtrim(str_ireplace('index.php', '', $container['request']->getUri()->getBasePath()), '/');
    $view->addExtension(new Slim\Views\TwigExtension($container['router'], $basePath));

    return $view;
};
$container['em'] = function ($container) {
    $settings = include '../config/connection.php';

    $config = \Doctrine\ORM\Tools\Setup::createAnnotationMetadataConfiguration(
        $settings['meta']['entity_path'],
        $settings['meta']['auto_generate_proxies'],
        $settings['meta']['proxy_dir'],
        $settings['meta']['cache'],
        false
    );

    return \Doctrine\ORM\EntityManager::create($settings['connection'], $config);
};

$app->get('/', '\WeBid\Controllers\HomeController:home');

$app->group('/users', function () {
    // ...
    $this->get('/', function(){ echo 1; });
});

$app->get('/test', function(){
    $user = new \WeBid\AdminUsers;
    $user->setUsername('Mr.Right'.rand(0,99));
    $user->setPassword('password'.rand(0,99));
    $user->setHash(rand(0,99));
    $this->em->persist($user);
    $this->em->flush();

    $admin = $this->em->find('\WeBid\AdminUsers', $user->getAdminUserId());
    print_r($admin);
});

$app->run();