<?php

require_once 'utils/services-utils.php';

function getHomeData(): array {
  $default_page_size = 'page=1&page_size=6';
  $today = date('Y-m-d');
  $next_month = date('Y-m-d', strtotime('+1 month'));
  $start_year = date('Y-m-d', mktime(0, 0, 0, 1, 1, date('Y')));
  $end_year = date('Y-m-d', mktime(0, 0, 0, 12, 31, date('Y')));

  $new_releases_query = 'dates=' . $today . ',' . $next_month . '&ordering=released&' . $default_page_size;
  $popular_genres_query = 'ordering=-games_count&' . $default_page_size;
  $top_games_query = 'dates=' .$start_year . ',' . $end_year . '&ordering=-metacritic&' . $default_page_size;

  $urls = [
    'newReleases' => getUrl('games', $new_releases_query),
    'popularGenres' => getUrl('genres', $popular_genres_query),
    'topGames' => getUrl('games', $top_games_query),
    'tags' => getUrl('tags', $default_page_size)
  ];

  $data = fetchMultiData($urls);

  if(isset($data['error'])) {
    return $data;
  }

  return [
    'title' => 'Home page',
    'description' => 'Top Games Hub is a video game database with over 700,000 games!',
    'top_games' => getExtractedGamesList($data['topGames']['results']),
    'new_releases' => getExtractedGamesList($data['newReleases']['results']),
    'popular_genres' => getExtractedCommonsList($data['popularGenres']['results']),
    'tags' => getExtractedCommonsList($data['tags']['results'])
  ];
}
