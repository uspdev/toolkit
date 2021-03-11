<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use HaydenPierce\ClassFinder\ClassFinder;
use Illuminate\Http\Request;

class ReplicadoController extends Controller
{
    private static $baseNamespace = 'Uspdev\\Replicado\\';

    public static function listarClasses($api=false)
    {
        $classes = ClassFinder::getClassesInNamespace(SELF::$baseNamespace);
        if ($api) {
            return $classes;
        }
        return view('replicado.list', compact('classes'));
    }

    public function listarMetodos($classe)
    {
        $classe = new \ReflectionClass(SELF::$baseNamespace . $classe);
        return view('classe', compact('classe'));
    }

    public function show(Request $request, $classe, $metodo)
    {
        $data = [];
        $paramString = '';
        $keys = [];
        $type = '';
        if ($request->isMethod('post')) {
            $inputs = $request->all();
            unset($inputs['_token']);
            list($params, $paramString) = SELF::params($inputs);
            $data = SELF::exec($classe, $metodo, $params);
            list($type, $keys) = SELF::tipoDados($data);
        }

        $className = 'Uspdev\\Replicado\\' . $classe;
        $classe = new \ReflectionClass($className);
        $methodReflection = new \ReflectionMethod($className, $metodo);
        $ns = 'Replicado';

        return view('show', compact('type', 'methodReflection', 'classe', 'metodo', 'data', 'paramString', 'keys'));

    }

    public static function exec($classe, $metodo, $params)
    {
        $className = SELF::$baseNamespace . $classe;
        $data = $className::$metodo(...$params);
        return $data;
    }

    public static function params($inputs)
    {
        $params = [];
        $paramString = '';
        foreach ($inputs as $v) {
            if ($v !== NUll) {
                if (is_numeric($v) || $v === '0') { // é um número, nesse caso sempre inteiro
                    $paramString .= $v . ', ';
                    $v = intval($v);
                } elseif (substr($v, 0, 1) == '[') { // é um array
                    $paramString .= $v . ', ';
                    # se [teste] dá erro, pois deveria ser ["teste"] !!!!!
                    $v = json_decode("{$v}", true);
                } else {
                    $paramString .= $v . ', ';
                }
                array_push($params, $v);
            }
        }
        $paramString = substr($paramString, 0, -2);
        return [$params, $paramString];
    }

    public static function tipoDados($data)
    {
        $keys = [];
        if (is_array($data)) {
            if (isset($data[0]) && is_array($data[0])) {
                $keys = array_keys($data[0]);
                $type = 'multi_array';
            } else {
                $type = 'simple_array';
            }
        } elseif ($data === true || $data === false) {
            $type = 'boolean';
        } else {
            $type = 'string';
        }

        return [$type, $keys];
    }
}
