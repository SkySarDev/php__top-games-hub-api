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

  public function genres(): void {
    require_once 'services/genres.php';

    $result = getGenres();
    sendResponse($result);
  }

  public function genreById(string $id): void {
    require_once 'services/genres.php';

    $result = getGenreById($id);
    sendResponse($result);
  }

  public function tags(): void {
    require_once 'services/tags.php';

    $result = getTags();
    sendResponse($result);
  }

  public function tagById(string $id): void {
    require_once 'services/tags.php';

    $result = getTagById($id);
    sendResponse($result);
  }

  public function developers(): void {
    require_once 'services/developers.php';

    $result = getDevelopers();
    sendResponse($result);
  }

  public function developerById(string $id): void {
    require_once 'services/developers.php';

    $result = getDeveloperById($id);
    sendResponse($result);
  }

  public function publishers(): void {
    require_once 'services/publishers.php';

    $result = getPublishers();
    sendResponse($result);
  }

  public function publisherById(string $id): void {
    require_once 'services/publishers.php';

    $result = getPublisherById($id);
    sendResponse($result);
  }

  public function error(): void {
    http_response_code(400);

    echo json_encode([
      'message' => 'Bad request'
    ], JSON_UNESCAPED_UNICODE);
  }
}