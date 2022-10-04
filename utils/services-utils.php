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
  $str = preg_replace(['/\s+/', '/\/n/'], ' ', $str);

  return htmlspecialchars_decode($str);
}

function getBackgroundImage(string $file_name): string {
  $protocol = $_SERVER['REQUEST_SCHEME'];
  $host = $_SERVER['HTTP_HOST'];

  return $protocol . '://' . $host . '/static/images/backgrounds/' . $file_name;
}

function getExtractedGamesList(array $games_list): array {
  $result = [];

  if (count($games_list)) {
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

function getNextPageString(?string $next_page): ?string {
  if (!isset($next_page)) {
    return null;
  }

  $api_url = getenv('API_URL');
  $api_key = 'key='.getenv('API_KEY');

  return str_replace([$api_url, $api_key], '', $next_page);
}