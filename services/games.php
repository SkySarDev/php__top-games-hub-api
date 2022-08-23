<?php

function getAllGames(): array {
  $url = getUrl('games', 'page=1&page_size=15');

  return fetchData($url);
}

function getGameById(string $id): array {
  $url = getUrl('games/'.$id, '');
  return fetchData($url);
}