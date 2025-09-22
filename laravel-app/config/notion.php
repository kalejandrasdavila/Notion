<?php

return [
    'api_token' => env('NOTION_API_TOKEN'),
    'database_id' => env('NOTION_DATABASE_ID'),
    'version' => env('NOTION_VERSION', '2022-06-28'),
    'base_url' => 'https://api.notion.com/v1',
    
    'headers' => [
        'Authorization' => 'Bearer ' . env('NOTION_API_TOKEN'),
        'Notion-Version' => env('NOTION_VERSION', '2022-06-28'),
        'Content-Type' => 'application/json',
    ],
    
    'database_fields' => [
        'title' => 'title',
        'status' => 'STATUS',
        'fecha_planeada' => 'FECHA PLANEADA',
        'tipo' => 'TIPO',
        'quien_solicita' => 'QUIEN SOLICITA',
        'prioridad' => 'PRIORIDAD',
        'medio' => 'MEDIO ',
        'indicaciones' => 'INDICACIONES',
    ],
];
