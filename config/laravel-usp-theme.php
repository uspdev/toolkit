<?php

$admin = [
    [
        'text' => '<i class="fas fa-atom"></i>  SubItem 1',
        'url' => 'subitem1',
    ],
    [
        'text' => 'SubItem 2',
        'url' => '/subitem2',
        'can' => 'admin',
    ],
    [
        'type' => 'divider',
    ],
    [
        'type' => 'header',
        'text' => 'Cabeçalho',
    ],
    [
        'text' => 'SubItem 3',
        'url' => 'subitem3',
    ],
];

$submenu2 = [
    [
        'text' => 'SubItem 1',
        'url' => 'subitem1',
    ],
    [
        'text' => 'SubItem 2',
        'url' => 'subitem2',
        'can' => 'admin',
    ],
];
$menu = [
    [
        'text' => 'Permissions',
        'url' => 'permission',
    ],
    // [
    //     'text' => 'Gates',
    //     'url' => 'gates',
    // ],
    // [
    //     'key' => 'replicado',
    // ],
    // [
    //     'key' => 'nada',
    // ],
    // [
    //     'text' => 'Drop Down',
    //     'submenu' => $submenu2,
    //     'can' => '',
    // ],
    [
        'text' => 'Replicado',
        'url' => 'library/Replicado', // com caminho absoluto
        'can' => 'admin',
    ],
    [
        'text' => 'Utils',
        'url' => 'library/Utils',
        'can' => 'admin',
    ],
    [
        'text' => 'Foto',
        'url' => 'Wsfoto/obter',
        'can' => 'admin',
    ],
    [
        'text' => 'Theme',
        'url' => 'theme',
        'can' => '',
    ],
    [
        'text' => 'Laravel Tools',
        'url' => 'laravel-tools',
        'can' => '',
    ],
    [
        'text' => 'Forms',
        'url' => 'uspdev-forms/definitions',
        'can' => '',
    ],
];

$right_menu = [
    [
        'key' => 'theme',
    ],
        [
        'key' => 'uspdev-forms',
    ],
    [
        'key' => 'senhaunica-socialite',
    ],
    [
        'key' => 'laravel-tools',
    ],
    [
        'text' => '<i class="fas fa-cog"></i>',
        'title' => 'Configurações',
        'target' => '_blank',
        'url' => config('app.url') . '/item1',
        'align' => 'right',
    ],
];

# dashboard_url renomeado para app_url
# USP_THEME_SKIN deve ser colocado no .env da aplicação

return [
    # valor default para a tag title, dentro da section title.
    # valor pode ser substituido pela aplicação.
    'title' => config('app.name'),

    # USP_THEME_SKIN deve ser colocado no .env da aplicação
    'skin' => env('USP_THEME_SKIN', 'uspdev'),

    # chave da sessão. Troque em caso de colisão com outra variável de sessão.
    'session_key' => 'laravel-usp-theme',

    # usado na tag base, permite usar caminhos relativos nos menus e demais elementos html
    # na versão 1 era dashboard_url
    'app_url' => config('app.url'),

    # login e logout
    'logout_method' => 'POST',
    'logout_url' => 'logout',
    'login_url' => 'login',

    # menus
    'menu' => $menu,
    'right_menu' => $right_menu,

    # mensagens flash - https://uspdev.github.io/laravel#31-mensagens-flash
    'mensagensFlash' => true,

    # container ou container-fluid
    'container' => 'container-fluid',
];
