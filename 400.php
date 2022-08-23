<?php

http_response_code(400);

echo json_encode([
  'message' => 'Bad request'
], JSON_UNESCAPED_UNICODE);
