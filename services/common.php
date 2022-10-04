<?php

function getNextPage(string $query): array {
  if (!isset($query)) {
    responseError(400, 'Bad request');
  }

  $url_arr = explode('?', $query);
  $url = getUrl($url_arr[0], $url_arr[1]);
  $response = fetchData($url);

  return [
    'list' => getExtractedGamesList($response['results']),
    'next_page' => getNextPageString($response['next'])
  ];
}
