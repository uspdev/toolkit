<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Contracts\View\View;
use Illuminate\Http\Request;

class ApiKeysController extends Controller
{
    /** Exibe a área de API do Toolkit para o usuário autenticado. */
    public function __invoke(Request $request): View
    {
        /** @var User $user */
        $user = $request->user();

        return view('api-keys.index', [
            'user' => $user,
            'userEndpoint' => route('toolkit.api.current-user'),
            'usersEndpoint' => route('toolkit.api.users'),
            'queryParameter' => config('api-keys.query_parameter.name', 'api_key'),
            'apiKeyRoles' => [
                [
                    'name' => 'personal',
                    'label' => 'Pessoal',
                    'abilities' => ['user.read'],
                    'parent_permission' => '—',
                    'endpoints' => [route('toolkit.api.current-user')],
                ],
                [
                    'name' => 'directory',
                    'label' => 'Diretório',
                    'abilities' => ['user.read', 'users.read.any'],
                    'parent_permission' => 'administrativa',
                    'endpoints' => [
                        route('toolkit.api.current-user'),
                        route('toolkit.api.users'),
                    ],
                ],
            ],
        ]);
    }
}
