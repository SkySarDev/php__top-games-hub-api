<?php

function getHome(): array {
  $page_size = 'page=1&page_size=6';
  $today = date('Y-m-d');
  $next_month = date('Y-m-d', strtotime('+1 month'));
  $start_year = date('Y-m-d', mktime(0, 0, 0, 1, 1, date('Y')));
  $end_year = date('Y-m-d', mktime(0, 0, 0, 12, 31, date('Y')));

  $new_releases_query = 'dates='.$today.','.$next_month.'&ordering=-rating&'.$page_size;
  $popular_genres_query = 'ordering=-games_count&'.$page_size;
  $top_games_query = 'dates='.$start_year.','.$end_year.'&ordering=-metacritic&'.$page_size;

  $urls = [
    'new_releases' => getUrl('games', $new_releases_query),
    'popular_genres' => getUrl('genres', $popular_genres_query),
    'top_games' => getUrl('games', $top_games_query),
    'tags' => getUrl('tags', $page_size)
  ];

  $data = fetchMultiData($urls);

  if(isset($data['error'])) {
    return $data;
  }

  return [
    'title' => 'Home page',
    'description' => 'Top Games Hub is a video game database with over 700,000 games!',
    'topGames' => getExtractedGamesList($data['top_games']['results']),
    'newReleases' => getExtractedGamesList($data['new_releases']['results']),
    'popularGenres' => getExtractedCommonsList($data['popular_genres']['results']),
    'tags' => getExtractedCommonsList($data['tags']['results'])
  ];
}
