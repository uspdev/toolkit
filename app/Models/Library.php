<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use HaydenPierce\ClassFinder\ClassFinder;

class Library extends Model
{
    const libs = [
        'Replicado',
        'Utils'
    ];
    
    public static function listarClasses($library)
    {
        $baseNamespace = "Uspdev\\{$library}\\";
        return ClassFinder::getClassesInNamespace($baseNamespace);
    }

    public static function listarMetodos($library, $classe)
    {
        $baseNamespace = "Uspdev\\{$library}\\";
        return new \ReflectionClass($baseNamespace . $classe);
    }
}
