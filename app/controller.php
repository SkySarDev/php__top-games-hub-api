<?php

namespace AppController;

class Controller {
  public function home(): void {
    require_once 'services/home.php';

    $result = getHomeData();
    sendResponse($result);
  }

  public function games(): void {
    require_once 'services/games.php';

    $result = getAllGames();
    sendResponse($result);
  }

  public function gameById(string $id): void {
    require_once 'services/games.php';

    $result = getGameById($id);
    sendResponse($result);
  }

  public function platforms(): void {
    require_once 'services/platforms.php';

    $result = getPlatforms();
    sendResponse($result);
  }

  public function platformById(string $id): void {
    require_once 'services/platforms.php';

    $result = getPlatformById($id);
    sendResponse($result);
  }

  public function error(): void {
    http_response_code(400);

    echo json_encode([
      'message' => 'Bad request'
    ], JSON_UNESCAPED_UNICODE);
  }
}