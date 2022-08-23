<?php

function sendResponse(array $data): void {
  if (isset($data['error'])) {
    http_response_code($data['error']);
  }

  echo json_encode($data, JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE);
}
