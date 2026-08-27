<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use OpenApi\Attributes as OA;
use Symfony\Component\HttpFoundation\Response;

#[OA\Get(
    path: '/toolkit/user',
    operationId: 'getCurrentApiKeyOwner',
    summary: 'Retorna o usuário proprietário da API Key',
    description: 'O middleware exige a ability user.read, concedida pelos papéis personal ou directory, antes de executar o controller. Autentique preferencialmente por Bearer; api_key é um fallback de demonstração.',
    tags: ['API Keys'],
    security: [
        ['bearerAuth' => []],
        ['apiKeyQuery' => []],
    ],
    responses: [
        new OA\Response(
            response: 200,
            description: 'Usuário proprietário da chave',
            content: new OA\JsonContent(ref: '#/components/schemas/CurrentUserResponse')
        ),
        new OA\Response(
            response: 401,
            description: 'Chave ausente, inválida, expirada ou revogada',
            content: new OA\JsonContent(
                ref: '#/components/schemas/ErrorResponse',
                example: ['message' => 'Unauthenticated.']
            )
        ),
        new OA\Response(
            response: 403,
            description: 'A chave foi autenticada, mas não possui a ability user.read',
            content: new OA\JsonContent(ref: '#/components/schemas/ErrorResponse')
        ),
    ]
)]
#[OA\Get(
    path: '/toolkit/users',
    operationId: 'listApiKeyUsers',
    summary: 'Lista usuários do diretório',
    description: 'O middleware exige a ability users.read.any antes de executar o controller. O endpoint retorna uma página de até 15 usuários com somente id, name e email; esse escopo global é concedido ao papel directory enquanto o owner possuir a permissão-pai administrativa ou o Gate hierárquico admin. Autentique preferencialmente por Bearer; api_key é um fallback de demonstração.',
    tags: ['API Keys'],
    security: [
        ['bearerAuth' => []],
        ['apiKeyQuery' => []],
    ],
    responses: [
        new OA\Response(
            response: 200,
            description: 'Página do diretório de usuários',
            content: new OA\JsonContent(ref: '#/components/schemas/DirectoryUsersResponse')
        ),
        new OA\Response(
            response: 401,
            description: 'Chave ausente, inválida, expirada ou revogada',
            content: new OA\JsonContent(
                ref: '#/components/schemas/ErrorResponse',
                example: ['message' => 'Unauthenticated.']
            )
        ),
        new OA\Response(
            response: 403,
            description: 'A chave foi autenticada, mas não possui users.read.any ou o owner perdeu a autorização elevada',
            content: new OA\JsonContent(ref: '#/components/schemas/ErrorResponse')
        ),
    ]
)]
class UserApiController extends Controller
{
    /** Retorna em JSON somente o usuário proprietário da API Key autenticada. */
    public function current(Request $request): JsonResponse
    {
        // Pega a API Key do request, que foi adicionada pelo middleware de autenticação de API Key.
        /** @var \Uspdev\ApiKeys\Models\ApiKey|null $apiKey */
        $apiKey = $request->attributes->get(
            config('api-keys.middleware.request_attribute', 'apiKey')
        );

        // Apenas valida se a API Key estiver associada a um usuário;
        // A ability user.read já foi autorizada pelo middleware da rota; aqui
        // só preservamos a invariante de que a API Key pertence a um usuário.
        abort_unless($apiKey?->owner instanceof User, Response::HTTP_FORBIDDEN);

        $user = $apiKey->owner;

        return response()->json([
            'data' => [
                'id' => $user->id,
                'name' => $user->name,
                'email' => $user->email,
            ],
        ]);
    }

    /**
     * Retorna uma página do diretório público permitido pela API Key.
     *
     * O escopo é global deliberadamente concedido pela ability elevada,
     * permitindo que a API Key leia qualquer usuário do sistema.
     */
    public function index(): JsonResponse
    {
        $users = User::query()
            ->select(['id', 'name', 'email'])
            ->paginate(15);

        return response()->json($users);
    }
}
