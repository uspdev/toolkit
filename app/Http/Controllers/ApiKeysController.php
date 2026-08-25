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

        $canIssueDirectory = $user->can('administrativa') || $user->can('admin');

        return view('api-keys.index', [
            'user' => $user,
            'canIssueDirectory' => $canIssueDirectory,
            'userEndpoint' => route('toolkit.api.current-user'),
            'usersEndpoint' => route('toolkit.api.users'),
            'queryParameter' => config('api-keys.query_parameter.name', 'api_key'),
        ]);
    }
}
