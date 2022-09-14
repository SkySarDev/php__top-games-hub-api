<?php

require_once 'utils/services-utils.php';

function getTags(): array {
  $url = getUrl('tags', 'page=1&page_size=15');
  $response = fetchData($url);

  if (isset($response['error'])) {
    return $response;
  }

  $tags_list = [];

  foreach ($response['results'] as $tag) {
    extract($tag);
    $tags_list[] = compact(
      'id',
      'name',
      'slug',
      'games_count',
      'image_background'
    );
  }

  return [
    'title' => 'Game tags',
    'description' => 'Top Games Hub. List of video game tags.',
    'background_image' => getBackgroundImage('all-tags.jpg'),
    'list' => $tags_list
  ];
}

function getTagById(string $id): array {
  $urls = [
    'tag_info' => getUrl('tags/' . $id),
    'games_list' => getUrl('games', 'page=1&page_size=15&tags=' . $id)
  ];

  $data = fetchMultiData($urls);

  if(isset($data['error'])) {
    return $data;
  }

  extract($data['tag_info']);
  $games_list = getExtractedGamesList($data['games_list']['results']);

  return [
    'title' => $name . ' games',
    'description' => $description,
    'description_raw' => getRawString($description),
    'background_image' => $image_background,
    'games_count' => $games_count,
    'games_list' => $games_list,
  ];
}