<?php

require_once 'utils/services-utils.php';

function getGenres(): array {
  $url = getUrl('genres', 'ordering=-games_count');
  $response = fetchData($url);

  if (isset($response['error'])) {
    return $response;
  }

  return [
    'background_image' => getBackgroundImage('all-genres.jpg'),
    'genres' => $response['results']
  ];
}

function getGenreById(string $id): array {
  $urls = [
    'genre_info' => getUrl('genres/' . $id),
    'games_list' => getUrl('games', 'page=1&page_size=15&genres=' . $id)
  ];

  $data = fetchMultiData($urls);

  if(isset($data['error'])) {
    return $data;
  }

  extract($data['genre_info']);
  $games_list = getExtractedGamesList($data['games_list']['results']);

  return [
    'name' => $name,
    'background_image' => $image_background,
    'description' => $description,
    'description_raw' => getRawString($description),
    'games_count' => $games_count,
    'games_list' => $games_list,
  ];
}
