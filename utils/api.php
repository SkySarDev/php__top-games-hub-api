<?php

use GuzzleHttp\Client;
use GuzzleHttp\Promise;
use GuzzleHttp\Exception\BadResponseException;

function getUrl(string $category, string $query = ''): string {
  $api_url = getenv('API_URL');
  $api_key = getenv('API_KEY');

  return $api_url . $category . '?key=' . $api_key . '&' . $query;
}

function responseError(int $status, string $message): array {
  http_response_code($status);

  return [
    'error' => $status,
    'message' => $message
  ];
}

function fetchData(string $url): array {
  $client = new Client();

  try {
    $response = $client->get($url);

    return json_decode($response->getBody(), true);
  } catch (BadResponseException $ex) {
    $status = $ex->getCode();
    $message = $ex->getResponse()->getBody()->getContents();

    return responseError($status, $message);
  }
}

function fetchMultiData(array $urls): array {
  $client = new Client();
  $promises = [];

  foreach ($urls as $i => $url) {
    $promises[$i] = $client->getAsync($url);
  }

  try {
    $responses = Promise\Utils::unwrap($promises);

    return array_map(function ($response) {
      return json_decode($response->getBody(), true);
    }, $responses);
  } catch (BadResponseException $ex) {
    $status = $ex->getCode();
    $message = $ex->getResponse()->getBody()->getContents();

    return responseError($status, $message);
  }
}