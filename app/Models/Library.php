<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use HaydenPierce\ClassFinder\ClassFinder;

class Library extends Model
{
    public static function listarClasses($library)
    {
        $baseNamespace = "Uspdev\\{$library}\\";
        return ClassFinder::getClassesInNamespace($baseNamespace);
    }
}
