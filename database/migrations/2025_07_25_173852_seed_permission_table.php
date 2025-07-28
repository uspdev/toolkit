<?php

use Spatie\Permission\Models\Role;
use Illuminate\Support\Facades\Schema;
use Spatie\Permission\Models\Permission;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class SeedPermissionTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        // criando algumas permissões a serem utilizadas pela aplicação
        // e que podem ser atribuídas aos usuários
        Permission::firstOrCreate(['name' => 'grad']);
        Permission::firstOrCreate(['name' => 'posgrad']);
        Permission::firstOrCreate(['name' => 'academica']);
        Permission::firstOrCreate(['name' => 'financeira']);
        Permission::firstOrCreate(['name' => 'administrativa']);

        $role = Role::firstOrCreate(['name' => 'diretoria']);
        $role->givePermissionTo(['academica', 'financeira', 'administrativa']);
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        //
    }
}
