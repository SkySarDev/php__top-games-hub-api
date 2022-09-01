<?php

namespace AppController;

class Controller {
  public function home(): void {
    require_once 'services/home.php';

    $data = getHomeData();
    sendResponse($data);
  }

  public function games(): void {
    require_once 'services/games.php';

    $data = getAllGames();
    sendResponse($data);
  }

  public function gameById(string $id): void {
    require_once 'services/games.php';


    $data = getGameById($id);
    sendResponse($data);
  }

  public function error(): void {
    http_response_code(400);

    echo json_encode([
      'message' => 'Bad request'
    ], JSON_UNESCAPED_UNICODE);
  }
}