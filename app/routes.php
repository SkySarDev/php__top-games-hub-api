<?php

$router = new \Bramus\Router\Router();
$router->setNamespace('\AppController');

$router->get('/home', 'Controller@home');
$router->get('/games', 'Controller@games');
$router->get('/games/{id}', 'Controller@gameById');;
$router->get('/platforms', 'Controller@platforms');
$router->get('/platforms/{id}', 'Controller@platformById');
$router->set404('Controller@error');

$router->run();
