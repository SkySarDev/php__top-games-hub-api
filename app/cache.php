<?php

namespace AppCache;

class Cache {
  private string $file;
  private int $cache_time;

  function __construct($file, $cache_time = 3600) {
    $this->file = $file;
    $this->cache_time = $cache_time;
  }

  public function getCache(): array {
    return json_decode(file_get_contents($this->file), true);
  }

  public function setCache(array $data): void {
    file_put_contents($this->file, json_encode($data), LOCK_EX);
  }

  public function checkCache(): bool {
    return file_exists($this->file) && (time() - $this->cache_time < filemtime($this->file));
  }
}