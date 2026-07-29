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
    description: 'A chave precisa possuir a permissão user.read. Autentique por Bearer ou pelo parâmetro api_key.',
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
            description: 'A chave não possui a permissão user.read',
            content: new OA\JsonContent(ref: '#/components/schemas/ErrorResponse')
        ),
    ]
)]
class CurrentUserController extends Controller
{
    /** Retorna em JSON somente o usuário proprietário da API Key autenticada. */
    public function __invoke(Request $request): JsonResponse
    {
        // Pega a API Key do request, que foi adicionada pelo middleware de autenticação de API Key.
        /** @var \Uspdev\ApiKeys\Models\ApiKey|null $apiKey */
        $apiKey = $request->attributes->get(
            config('api-keys.middleware.request_attribute', 'apiKey')
        );

        abort_unless($apiKey?->owner instanceof User, Response::HTTP_FORBIDDEN);
        abort_unless($apiKey->allows('user.read'), Response::HTTP_FORBIDDEN);

        $user = $apiKey->owner;

        return response()->json([
            'data' => [
                'id' => $user->id,
                'name' => $user->name,
                'email' => $user->email,
            ],
        ]);
    }
}
