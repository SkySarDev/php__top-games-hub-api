<?php

function getNextPage(string $query): array {
  if (!isset($query)) {
    responseError(400, 'Bad request');
  }

  $url_arr = explode('?', $query);
  $url = getUrl($url_arr[0], $url_arr[1]);
  $response = fetchData($url);

  $list = $url_arr[0] === 'games'
          ? getExtractedGamesList($response['results'])
          : getExtractedCommonsList($response['results']);

  return [
    'list' => $list,
    'next_page' => getNextPageString($response['next'])
  ];
}
