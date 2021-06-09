<?php

$right_menu = [
    [
        'text' => '<i class="fas fa-cog"></i>',
        'title' => 'Configurações',
        'url' => '',
    ],
];

$menu = [
    [
        'text' => 'Está logado',
        'url' => '',
        'can' => 'user',
    ],
    [
        'text' => 'É gerente',
        'url' => '',
        'can' => 'gerente',
    ],
    [
        'text' => 'É admin',
        'url' => '',
        'can' => 'admin',
    ],
];

# dashboard_url renomeado para app_url
# USPTHEME_SKIN deve ser colocado no .env da aplicação

return [
    'title' => config('app.name'),
    'skin' => env('USP_THEME_SKIN', 'uspdev'),
    'app_url' => config('app.url'),
    'logout_method' => 'POST',
    'logout_url' => 'logout',
    'login_url' => 'login',
    'menu' => $menu,
    'right_menu' => $right_menu,
];
