<?php

require_once 'services/home.php';

$method = $_SERVER['REQUEST_METHOD'];

if ($method === 'GET') {
  $data = getHomeData();

  echo json_encode($data, JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE);
}

