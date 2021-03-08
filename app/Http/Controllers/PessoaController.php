<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Uspdev\Replicado\Pessoa;
use HaydenPierce\ClassFinder\ClassFinder;

class PessoaController extends Controller
{

    public function listarClasses() {
        $classes = ClassFinder::getClassesInNamespace('Uspdev\Replicado');
        return view('index', compact('classes'));
    }

    public function listarMetodos($classe) {
        $classe = new \ReflectionClass('Uspdev\\Replicado\\'.$classe);
        return view('classe', compact('classe'));
    }

    public function show(Request $request, $classe, $metodo)
    {
        $inputs = $request->all();
        unset($inputs['_token']);
        $params = [];
        foreach ($inputs as $v) {
            if (is_numeric($v)) {
                array_push($params, intval($v));
            } else {
                if($v)
                array_push($params, $v);
            }

        }
        //$params = array_values($inputs);
        $className = 'Uspdev\\Replicado\\'.$classe;
        $data = $className::$metodo(...$params);
        $keys = [];

        //dd($data);
        if (is_array($data)) {
            if (isset($data[0]) && is_array($data[0])) {
                $keys = array_keys($data[0]);
                $type = 'multi_array';
            } else {
                $type = 'simple_array';
            }
        } else {
            $type = 'string';
            if ($data === true) {
                $type = 'boolean';
            }
            if ($data === false) {
                $type = 'boolean';
            }
        }

        $classe = new \ReflectionClass('Uspdev\\Replicado\\'.$classe);
        $methodReflection = new \ReflectionMethod($className, $metodo);
        return view('show', compact('type', 'methodReflection', 'classe', 'metodo', 'data', 'params', 'keys'));
    }

}
