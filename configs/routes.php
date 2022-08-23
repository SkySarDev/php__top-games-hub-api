<?php

$route = new Router();

$route->add('/', 'controllers/about.php');
$route->add('/home', 'controllers/home.php');
$route->add('/games', 'controllers/games.php');
$route->add('/games/{id}', 'controllers/games.php');
$route->add('/test', 'controllers/test.php');
$route->badRequest('400.php');
