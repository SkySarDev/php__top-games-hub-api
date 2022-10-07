<?php

function getAllGames(): array {
  $url = getUrl('games', BASE_PAGE_SIZE);
  $response = fetchData($url);

  return [
    'title' => 'Games',
    'description' => 'Top Games Hub. List of video games.',
    'background_image' => getBackgroundImage('games.jpg'),
    'games_count' => $response['count'],
    'games_list' => getExtractedGamesList($response['results']),
    'next_page' => getNextPageString($response['next'])
  ];
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




