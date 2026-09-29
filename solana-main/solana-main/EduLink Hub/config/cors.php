<?php

$configuredOrigins = array_filter(array_map('trim', explode(',', env('FRONTEND_URLS', env('FRONTEND_URL', '')))));

$defaultOrigins = [
    'http://localhost:3000',
    'http://127.0.0.1:3000',
];

$origins = array_values(array_unique(array_merge($defaultOrigins, $configuredOrigins)));

return [
    'paths' => ['api/*', 'sanctum/csrf-cookie', '*'],
    'allowed_methods' => ['*'],
    'allowed_origins' => count($configuredOrigins) > 0 ? $origins : ['*'],
    'allowed_origins_patterns' => [
        '#^https?://.*\.vercel\.app$#',
        '#^https?://.*\.onrender\.com$#',
        '#^https?://localhost(:[0-9]+)?$#',
        '#^https?://127\.0\.0\.1(:[0-9]+)?$#',
    ],
    'allowed_headers' => ['*'],
    'exposed_headers' => ['Content-Disposition', 'Authorization'],
    'max_age' => 0,
    'supports_credentials' => true,
];
