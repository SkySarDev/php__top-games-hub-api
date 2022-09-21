<?php

function getPublishers(): array {
  $url = getUrl('publishers', BASE_PAGE_SIZE);
  $response = fetchData($url);

  if (isset($response['error'])) {
    return $response;
  }

  $publishers_list = [];

  foreach ($response['results'] as $publisher) {
    extract($publisher);
    $publishers_list[] = compact(
      'id',
      'name',
      'slug',
      'games_count',
      'image_background'
    );
  }

  return [
    'title' => 'Game publishers',
    'description' => 'Top Games Hub. List of video game publishers.',
    'background_image' => getBackgroundImage('developers.jpg'),
    'list' => $publishers_list
  ];
}

function getPublisherById(string $id): array {
  $urls = [
    'publisher_info' => getUrl('publishers/'.$id),
    'games_list' => getUrl('games', BASE_PAGE_SIZE.'&publishers='.$id)
  ];

  $data = fetchMultiData($urls);

  if (isset($data['error'])) {
    return $data;
  }

  extract($data['publisher_info']);
  $games_list = getExtractedGamesList($data['games_list']['results']);

  return [
    'title' => 'Published by '.$name,
    'description' => $description,
    'description_raw' => getRawString($description),
    'background_image' => $image_background,
    'games_count' => $games_count,
    'games_list' => $games_list,
  ];
}
