<?php

require_once 'utils/services-utils.php';

function getPlatforms(): array
{
  $url = getUrl('platforms/lists/parents');
  $response = fetchData($url);

  if (isset($response['error'])) {
    return $response;
  }

  $platforms_data = $response['results'];
  $platforms_list = [];

  foreach ($platforms_data as $platform) {
    extract($platform);

    $image_background = $platforms[0]['image_background'];
    $games_count = 0;

    foreach ($platforms as $item) {
      $games_count += $item['games_count'];
    }

    $platforms_list[] = compact(
      'id',
      'name',
      'slug',
      'games_count',
      'image_background'
    );
  }

  usort($platforms_list, function ($a, $b) {
    return $a['games_count'] < $b['games_count'];
  });

  return [
    'background_image' => getBackgroundImage('all-platforms.jpg'),
    'platforms' => $platforms_list
  ];
}

function getPlatformById(string $id): array
{
  $platforms_list = json_decode(file_get_contents('db/platforms-list.json'), true);
  $platform = $platforms_list[$id];

  if (!isset($platform)) {
    return [
      'error' => 400,
      'message' => 'Bad Request'
    ];
  }

  $url = getUrl('games', 'page=1&page_size=15&parent_platforms=' . $id);
  $response = fetchData($url);

  if (isset($response['error'])) {
    return $response;
  }

  $games_count = $response['count'];
  $games_list = getExtractedGamesList($response['results']);
  $background_image = $games_list[0]['background_image'];

  return [
    'name' => $platform['name'],
    'description' => $platform['description'],
    'games_count' => $games_count,
    'background_image' => $background_image,
    'games_list' => $games_list
  ];
}