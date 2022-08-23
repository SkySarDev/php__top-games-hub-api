<?php

require_once 'services/games.php';

$id = $params['id'];
$method = $_SERVER['REQUEST_METHOD'];

if ($method === 'GET') {
  if ($id) {
    $data = getGameById($id);
  } else {
    $data = getAllGames();
  }

  sendResponse($data);
}