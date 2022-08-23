<?php

require_once 'services/home.php';

$method = $_SERVER['REQUEST_METHOD'];

if ($method === 'GET') {
  $data = getHomeData();

  sendResponse($data);
}

