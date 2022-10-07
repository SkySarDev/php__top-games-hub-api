<?php

function getSearch(string $text): array {
  $url = getUrl('games', BASE_PAGE_SIZE.'&search_exact=true&search='.$text);
  $response = fetchData($url);

  return [
    'games_count' => $response['count'],
    'games_list' => getExtractedGamesList($response['results']),
    'next_page' => getNextPageString($response['next'])
  ];
}