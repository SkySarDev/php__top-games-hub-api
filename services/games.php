<?php

use AppCache\Cache;

function getAllGames(): array {
  $cache = new Cache('cache/games.json', 3600 * 24);

  if ($cache->checkCache()) {
    return $cache->getCache();
  }

  $url = getUrl('games', BASE_PAGE_SIZE);
  $response = fetchData($url);

  if (isset($response['error'])) {
    return $response;
  }

  $result = [
    'title' => 'Games',
    'description' => 'Top Games Hub. List of video games.',
    'background_image' => getBackgroundImage('games.jpg'),
    'games_count' => $response['count'],
    'games_list' => getExtractedGamesList($response['results']),
    'next_page' => getNextPageString($response['next'])
  ];

  $cache->setCache($result);

  return $result;
}

function getGameById(string $id): array {
  $urls = [
    'game_info' => getUrl('games/'.$id),
    'screenshots' => getUrl('games/'.$id.'/screenshots')
  ];

  $data = fetchMultiData($urls);

  if (isset($data['error'])) {
    return $data;
  }

  $game_data = $data['game_info'];
  $screenshots = $data['screenshots']['results'];

  extract($game_data);

  $platforms = array_map('getGamePlatform', $parent_platforms);
  $description = getFormattedDesc($description);
  $description_raw = isset($description_raw) ? getRawString($description_raw) : getRawString($description);

  return compact(
    'id',
    'slug',
    'name',
    'description',
    'description_raw',
    'playtime',
    'released',
    'background_image',
    'website',
    'metacritic',
    'genres',
    'platforms',
    'developers',
    'publishers',
    'tags',
    'screenshots'
  );
}




