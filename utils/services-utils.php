<?php

function getGamePlatform(array $platform): array {
  extract($platform['platform']);

  return compact('id', 'slug', 'name');
}

function getFormattedDesc(string $description): string {
  return preg_replace(["/<(\/?)pre>/", "/<(\/?)code>/"], "",  $description);
}

function getRawString(string $str): string {
  $str = strip_tags($str);
  $str = str_replace(PHP_EOL, ' ', $str);

  return htmlspecialchars_decode($str);
}

function getBackgroundImage(string $file_name): string {
  $protocol = $_SERVER['REQUEST_SCHEME'];
  $host = $_SERVER['HTTP_HOST'];

  return $protocol . '://' . $host . '/static/images/backgrounds/' . $file_name;
}

function getExtractedGamesList(array $games_list): array {
  $result = [];

  foreach ($games_list as $game) {
    extract($game);
    $result[] = compact(
      'slug',
      'name',
      'released',
      'background_image',
      'metacritic',
      'genres'
    );
  }

  return $result;
}

function getExtractedCommonsList(array $list): array {
  $result = [];

  foreach ($list as $item) {
    extract($item);
    $result[] = compact(
      'id',
      'name',
      'games_count',
      'image_background',
    );
  }

  return $result;
}