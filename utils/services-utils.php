<?php

function getGamePlatform(array $platform): array {
  extract($platform['platform']);

  return compact('id', 'slug', 'name');
}

function getRawString(string $str): string {
  $str = strip_tags($str);
  $str = str_replace(PHP_EOL, ' ', $str);

  return htmlspecialchars_decode($str);
}

function getBackgroundImage(string $file_name): string {
  $protocol = $_SERVER['REQUEST_SCHEME'].'://';
  $host = $_SERVER['HTTP_HOST'];

  return $protocol.$host.'/static/images/backgrounds/'.$file_name;
}