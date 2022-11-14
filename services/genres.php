<?php

use AppCache\Cache;

function getGenres(): array {
  $cache = new Cache('cache/genres.json', 3600 * 24);

  if ($cache->checkCache()) {
    return $cache->getCache();
  }

  $url = getUrl('genres', 'ordering=-games_count');
  $response = fetchData($url);

  if (isset($response['error'])) {
    return $response;
  }

  $result = [
    'title' => 'Game genres',
    'description' => 'Top Games Hub. List of video game genres.',
    'background_image' => getBackgroundImage('genres.jpg'),
    'list' => $response['results'],
    'next_page' => getNextPageString($response['next'])
  ];

  $cache->setCache($result);

  return $result;
}

function getGenreById(string $id): array {
  $urls = [
    'genre_info' => getUrl('genres/'.$id),
    'games_list' => getUrl('games', BASE_PAGE_SIZE.'&genres='.$id)
  ];

  $data = fetchMultiData($urls);

  if(isset($data['error'])) {
    return $data;
  }

  extract($data['genre_info']);
  $games_list = getExtractedGamesList($data['games_list']['results']);

  return [
    'title' => $name.' games',
    'description' => $description,
    'description_raw' => getRawString($description),
    'background_image' => $image_background,
    'games_count' => $games_count,
    'games_list' => $games_list,
    'next_page' => getNextPageString($data['games_list']['next'])
  ];
}
