<?php

namespace App\Models;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Uspdev\ApiKeys\Traits\HasApiAbilities;
use Uspdev\ApiKeys\Traits\HasApiKeys;

class User extends Authenticatable
{
    use HasApiAbilities, HasApiKeys, HasFactory, Notifiable;
    use \Spatie\Permission\Traits\HasRoles;
    use \Uspdev\SenhaunicaSocialite\Traits\HasSenhaunica;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name',
        'email',
        'password',
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    /**
     * Retorna as abilities efetivas para o papel armazenado na API Key.
     *
     * As abilities user.read e users.read.any são definidas neste método pelo
     * contrato da API do Toolkit; elas não são permissões cadastradas no
     * Spatie.
     *
     * A permissão administrativa é consultada a cada uso da chave para que
     * o papel directory não preserve acesso depois que a permissão for
     * removida do usuário.
     *
     * @return list<string>
     */
    public function abilities(string $role): array
    {
        // Se o papel for directory, verifica se o usuário ainda tem a permissão administrativa
        return match ($role) {
            'personal' => ['user.read'],
            'directory' => $this->can('administrativa')
                ? ['user.read', 'users.read.any']
                : [],
            default => [],
        };
    }
}
