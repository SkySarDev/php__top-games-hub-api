<?php

$router = new \Bramus\Router\Router();
$router->setNamespace('\AppController');

$router->get('/home', 'Controller@home');
$router->get('/games', 'Controller@games');
$router->get('/games/{id}', 'Controller@gameById');;
$router->get('/platforms', 'Controller@platforms');
$router->get('/platforms/{id}', 'Controller@platformById');
$router->get('/genres', 'Controller@genres');
$router->get('/genres/{id}', 'Controller@genreById');
$router->get('/tags', 'Controller@tags');
$router->get('/tags/{id}', 'Controller@tagById');
$router->get('/developers', 'Controller@developers');
$router->get('/developers/{id}', 'Controller@developerById');
$router->get('/publishers', 'Controller@publishers');
$router->get('/publishers/{id}', 'Controller@publisherById');
$router->get('/search/{text}', 'Controller@search');
$router->set404('Controller@error');

$router->run();
