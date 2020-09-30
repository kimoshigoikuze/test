<?php
require __DIR__ . '/vendor/autoload.php';

session_start();

$env = Dotenv\Dotenv::createImmutable(__DIR__);
$env->load();

$router = new Mvc\Router();
$router->add('/', ['controller' => 'Landing', 'action' => 'index']);
$router->add('/api/sofs', ['controller' => 'Api', 'action' => 'sofs']);
$router->add('/api/sofs/events', ['controller' => 'Api', 'action' => 'sofsEvents']);

$router->dispatch();