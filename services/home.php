<?php

function getHomeData(): array {
  $default_page_size = 'page=1&page_size=6';
  $today = date('Y-m-d');
  $next_month = date('Y-m-d', strtotime('+1 month'));
  $start_year = date('Y-m-d', mktime(0, 0, 0, 1, 1, date('Y')));
  $end_year = date('Y-m-d', mktime(0, 0, 0, 12, 31, date('Y')));

  $new_releases_query = 'dates=' . $today . ',' . $next_month . '&ordering=released&' . $default_page_size;
  $popular_genres_query = 'ordering=-games_count&' . $default_page_size;
  $top_games_query = 'dates=' .$start_year . ',' . $end_year . '&ordering=-metacritic&' . $default_page_size;

  $urls = array(
    'newReleases' => getUrl('games', $new_releases_query),
    'popularGenres' => getUrl('genres', $popular_genres_query),
    'topGames' => getUrl('games', $top_games_query),
    'tags' => getUrl('tags', $default_page_size)
  );

  $data =  fetchMultiData($urls);

  $result = [];
  $result['newReleases'] = $data['newReleases']['results'];
  $result['popularGenres'] = $data['popularGenres']['results'];
  $result['topGames'] = $data['topGames']['results'];
  $result['tags'] = $data['tags']['results'];

  return $result;
}
