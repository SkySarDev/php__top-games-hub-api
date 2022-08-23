<?php

function getUrl(string $category, string $query): string {
  $api_url = getenv('API_URL');
  $api_key = getenv('API_KEY');

  return $api_url . $category . '?key=' . $api_key . '&' . $query;
}

function fetchData(string $url): mixed {
  $ch = curl_init($url);
  curl_setopt($ch, CURLOPT_HEADER, false);
  curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
  curl_setopt($ch, CURLOPT_TIMEOUT, 10);
  curl_setopt($ch, CURLOPT_FOLLOWLOCATION, true);
  curl_setopt($ch, CURLOPT_FAILONERROR, true);

  $response = curl_exec($ch);

  curl_close($ch);

  if (curl_errno($ch)) {
    $status_code = curl_getinfo($ch, CURLINFO_HTTP_CODE);

    return [
      'error' => $status_code,
      'message' => curl_error($ch)
    ];
  } else {
    return json_decode($response, true);
  }
}

function fetchMultiData(array $urls): array {
  $res = array();
  $conn = array();
  $mh = curl_multi_init();

  foreach ($urls as $i => $url) {
    $conn[$i] = curl_init();
    curl_setopt($conn[$i], CURLOPT_URL, $url);
    curl_setopt($conn[$i], CURLOPT_HEADER, 0);
    curl_setopt($conn[$i], CURLOPT_RETURNTRANSFER, 1);
    curl_setopt($conn[$i], CURLOPT_TIMEOUT, 10);
    curl_setopt($conn[$i], CURLOPT_FOLLOWLOCATION, 1);
    curl_multi_add_handle($mh, $conn[$i]);
  }

  $active = 0;

  do {
    $mrc = curl_multi_exec($mh, $active);
  } while ($mrc == CURLM_CALL_MULTI_PERFORM);

  while ($active && $mrc == CURLM_OK) {
    if (curl_multi_select($mh) != -1) {
      do {
        $mrc = curl_multi_exec($mh, $active);
      } while ($mrc == CURLM_CALL_MULTI_PERFORM);
    }
  }

  foreach ($urls as $i => $url) {
    $res[$i] = json_decode(curl_multi_getcontent($conn[$i]), true);
    curl_multi_remove_handle($mh, $conn[$i]);
    curl_close($conn[$i]);
  }
  curl_multi_close($mh);

  return $res;
}