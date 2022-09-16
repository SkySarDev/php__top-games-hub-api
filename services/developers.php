<?php

require_once 'utils/services-utils.php';

function getDevelopers(): array {
  $url = getUrl('developers', 'page=1&page_size=15');
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

  return [
    'title' => 'Game developers',
    'description' => 'Top Games Hub. List of video game developers.',
    'background_image' => getBackgroundImage('developers.jpg'),
    'list' => $developers_list
  ];
}

function getDeveloperById(string $id): array {
  $urls = [
    'developer_info' => getUrl('developers/' . $id),
    'games_list' => getUrl('games', 'page=1&page_size=15&developers=' . $id)
  ];

  $data = fetchMultiData($urls);

  if(isset($data['error'])) {
    return $data;
  }

  extract($data['developer_info']);
  $games_list = getExtractedGamesList($data['games_list']['results']);

  return [
    'title' => 'Developed by ' . $name,
    'description' => $description,
    'description_raw' => getRawString($description),
    'background_image' => $image_background,
    'games_count' => $games_count,
    'games_list' => $games_list,
  ];
}
