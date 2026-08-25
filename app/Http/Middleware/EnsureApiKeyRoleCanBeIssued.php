<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

/**
 * Protege a emissão de chaves cujo papel exige a permissão administrativa.
 *
 * O package valida se `role` é um papel configurado e, separadamente, verifica
 * se o usuário autenticado pode gerenciar o owner. Essas duas validações não
 * respondem à regra desta aplicação: uma chave `directory` só pode ser
 * criada ou renovada quando o próprio owner possui `administrativa` ou é
 * administrador hierárquico (`admin`).
 */
class EnsureApiKeyRoleCanBeIssued
{
    /**
     * Restringe a criação/renovação de keys "directory" a owners com
     * a permissão administrativa exigida pela aplicação.
     *
     * O package valida se o papel é válido; a aplicação valida se o owner
     * possui permissão para utilizá-lo. O Gate `admin` é a autoridade comum
     * para administradores definidos pelo senhaunica-socialite, inclusive os
     * administradores gerenciados pelo ambiente.
     */
    public function handle(Request $request, Closure $next): Response
    {
        // Só exige permissão administrativa ao criar ou renovar
        // uma API key com o papel "directory".
        if (
            ! $request->routeIs('api-keys.keys.store', 'api-keys.keys.renew')
            || $request->input('role') !== 'directory'
        ) {
            return $next($request);
        }

        $owner = $this->resolveOwner($request);

        if (
            $owner !== null
            && method_exists($owner, 'can')
            && ! $owner->can('administrativa')
            && ! $owner->can('admin')
        ) {
            abort(403);
        }

        return $next($request);
    }
    /**
     * Tenta descobrir e carregar o owner a partir dos parâmetros da rota,
     * retornando um Model do Laravel ou null se algo não estiver válido.
     */
    private function resolveOwner(Request $request): ?Model
    {
        $ownerAlias = $request->route('ownerAlias');
        $ownerKey = $request->route('owner');
        // Garante que os parâmetros necessários para identificar o owner
        // foram recebidos corretamente pela rota.
        if (
            ! is_string($ownerAlias)
            || ! is_string($ownerKey)
        ) {
            return null;
        }

        $ownerClass = config('api-keys.owners.' . $ownerAlias);
        // O alias deve estar configurado e apontar para um Model válido.
        if (
            ! is_string($ownerClass)
            || ! is_a($ownerClass, Model::class, true)
        ) {
            return null;
        }
        // Resolve o owner usando o mesmo mecanismo de route model binding do Laravel.
        $owner = (new $ownerClass())->resolveRouteBinding($ownerKey);
        // Retorna null quando o registro não existe ou não pôde ser resolvido.
        return $owner instanceof Model ? $owner : null;
    }
}
