<?php

return [
    'paths' => ['api/*', 'sanctum/csrf-cookie'],
    'allowed_methods' => ['*'],
    'allowed_origins' => [
        'http://localhost:5173',
        'https://vastrika-nx-frontend.vercel.app',                                    // ← add this
        'https://vastrika-nx-frontend-git-main-rahulyts5s-projects.vercel.app',
        'https://vastrika-nx-frontend-4hjya41zn-rahulyts5s-projects.vercel.app',      // ← add this (preview URL)
    ], 
    'allowed_origins_patterns' => [
        '#^https://vastrika-nx-frontend-.*\.vercel\.app$#',   // ← covers ALL future preview URLs
    ],
    'allowed_headers' => ['*'],
    'exposed_headers' => [],
    'max_age' => 0,
    'supports_credentials' => true,
];