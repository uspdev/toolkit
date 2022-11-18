<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Library extends Model
{
    const libs = [
        'Replicado',
        'Utils',
    ];

    /**
     * Lista as classes do namespace Uspdev\$library com base no autoload_classmap do composer
     *
     * @param String $library
     * @return Array
     */
    public static function listarClasses($library)
    {
        $classMap = include base_path('vendor/composer/autoload_classmap.php');
        return array_values(preg_grep("/^Uspdev\\\\$library\\\\/", array_keys($classMap)));
    }

    /**
     * Lista os métodos de uma classe
     */
    public static function listarMetodos($library, $classe)
    {
        return new \ReflectionClass("Uspdev\\{$library}\\$classe");
    }
}
