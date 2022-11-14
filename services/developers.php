<?php

use AppCache\Cache;

function getDevelopers(): array {
  $cache = new Cache('cache/developers.json', 3600 * 24);

  if ($cache->checkCache()) {
    return $cache->getCache();
  }

  $url = getUrl('developers', BASE_PAGE_SIZE);
  $response = fetchData($url);

  if (isset($response['error'])) {
    return $response;
  }

  $developers_list = [];

  foreach ($response['results'] as $developer) {
    extract($developer);
    $developers_list[] = compact(
      'id',
      'name',
      'slug',
      'games_count',
      'image_background'
    );
  }

  $result = [
    'title' => 'Game developers',
    'description' => 'Top Games Hub. List of video game developers.',
    'background_image' => getBackgroundImage('developers.jpg'),
    'list' => $developers_list,
    'next_page' => getNextPageString($response['next'])
  ];

  $cache->setCache($result);

  return $result;
}

function getDeveloperById(string $id): array {
  $urls = [
    'developer_info' => getUrl('developers/'.$id),
    'games_list' => getUrl('games', BASE_PAGE_SIZE.'&developers='.$id)
  ];

  $data = fetchMultiData($urls);

  if(isset($data['error'])) {
    return $data;
  }

  extract($data['developer_info']);
  $games_list = getExtractedGamesList($data['games_list']['results']);

  return [
    'title' => 'Developed by '.$name,
    'description' => $description,
    'description_raw' => getRawString($description),
    'background_image' => $image_background,
    'games_count' => $games_count,
    'games_list' => $games_list,
    'next_page' => getNextPageString($data['games_list']['next'])
  ];
}
