<?php

use GuzzleHttp\Client;
use GuzzleHttp\Promise;
use GuzzleHttp\Exception\BadResponseException;

function getUrl(string $category, string $query = ''): string {
  return API_URL.$category.'?key='.API_KEY.'&'.$query;
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