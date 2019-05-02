<?php

use App\Router\Router;
use Tracy\Debugger;

require_once "../vendor/autoload.php";

Debugger::enable();

$router = new Router(isset($_GET['url']) ? $_GET['url'] : 'index');

$router->get('/user/edit/:id', 'User#updateUser');
$router->get('/user/:id', 'User#userIndex');
$router->get('/authentification', 'User#authentification');
$router->get('/', 'Index#index');

$router->post('/authentification', 'User#authentification');

$router->run();