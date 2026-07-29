<?php

/*
|--------------------------------------------------------------------------
| Configuração da interface de API Keys
|--------------------------------------------------------------------------
| Este arquivo sobrescreve a configuração publicada pelo package para esta
| aplicação hospedeira.
*/

return [
    'owners' => [
        'user' => App\Models\User::class,
    ],

    'prefix' => 'api-keys',

    'credential_prefix' => env('API_KEYS_CREDENTIAL_PREFIX', 'gpp'),
    'public_prefix_length' => (int) env('API_KEYS_PUBLIC_PREFIX_LENGTH', 6),
    'secret_bytes' => (int) env('API_KEYS_SECRET_BYTES', 32),

    'middleware' => [
        'alias' => env('API_KEYS_MIDDLEWARE_ALIAS', 'uspdevApiKeys'),
        'request_attribute' => env('API_KEYS_REQUEST_ATTRIBUTE', 'apiKey'),
    ],

    'query_parameter' => [
        // Esta aplicação também disponibiliza a credencial na query string para
        // integrações que não conseguem enviar o cabeçalho Authorization.
        'enabled' => (bool) env('API_KEYS_QUERY_PARAMETER_ENABLED', true),
        'name' => env('API_KEYS_QUERY_PARAMETER_NAME', 'api_key'),
    ],

    'management' => [
        'middleware' => [
            'web',
            'auth',
        ],
        'ability' => 'manageApiKeys',
    ],

    'interface' => [
        'purposes' => [
            'integration' => 'Integração',
        ],
        'roles' => [
            'user' => 'Usuário',
        ],
    ],
];
