<?php

function getReleases(): array {
  $start = date('Y-m-d');
  $end = date('Y-m-d', strtotime('+1 month'));
  $query = BASE_PAGE_SIZE.'&dates='.$start.','.$end.'&ordering=released';
  $url = getUrl('games', $query);
  $response = fetchData($url);

  return [
    'title' => 'Release calendar: Upcoming releases',
    'description' => 'Top Games Hub. List of upcoming games releases',
    'background_image' => getBackgroundImage('calendar.jpg'),
    'games_count' => $response['count'],
    'games_list' => getExtractedGamesList($response['results']),
    'next_page' => getNextPageString($response['next'])
  ];
}

function getReleasesByDate(string $date): array {
  if (!preg_match('/^\d{4}-\d{2}-\d{2}$/', $date)) {
    responseError(400, 'Bad request');
  }

  $title = date('d F Y', strtotime($date));
  $query = BASE_PAGE_SIZE.'&dates='.$date.','.$date.'&ordering=released';
  $url = getUrl('games', $query);
  $response = fetchData($url);

  return [
    'title' => 'Games released: '.$title,
    'description' => 'Top Games Hub. List of games released '.$title,
    'background_image' => getBackgroundImage('calendar.jpg'),
    'games_count' => $response['count'],
    'games_list' => getExtractedGamesList($response['results']),
    'next_page' => getNextPageString($response['next'])
  ];
}