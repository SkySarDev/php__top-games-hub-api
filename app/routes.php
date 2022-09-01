<?php

$router = new \Bramus\Router\Router();
$router->setNamespace('\AppController');

$router->get('/home', 'Controller@home');
$router->get('/games', 'Controller@games');
$router->get('/games/{id}', 'Controller@gameById');
$router->set404('Controller@error');

$router->run();
