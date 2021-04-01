<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use HaydenPierce\ClassFinder\ClassFinder;
use Illuminate\Http\Request;
use App\Models\Library;

class LibraryController extends Controller
{
    public static function index($library)
    {
        $classes = Library::listarClasses($library);       
        return view('library.index', [
            'classes' => $classes,
            'library' => $library 
        ]);
    }

    public function methods($library, $class)
    {
        $classe = Library::listarMetodos($library,$class);       
        return view('library.methods', [
            'classe' => $classe,
            'library' => $library 
        ]);
    }

    public function show(Request $request, $library, $class, $method)
    {
        $data = [];
        $paramString = '';
        $keys = [];
        $type = '';
        if ($request->isMethod('post')) {
            $inputs = $request->all();
            unset($inputs['_token']);
            list($params, $paramString) = SELF::params($inputs);
            $data = SELF::exec($library, $class, $method, $params);
            list($type, $keys) = SELF::tipoDados($data);
        }

        $className = "Uspdev\\{$library}\\" . $class;
        $classe = new \ReflectionClass($className);
        $methodReflection = new \ReflectionMethod($className, $method);
        $ns = $library;

        return view('library.show', [
            'type' => $type,
            'methodReflection' => $methodReflection,
            'classe' => $classe,
            'metodo' => $method,
            'data'   => $data,
            'paramString' => $paramString,
            'keys'        => $keys,
            'library'     => $library
        ]);

    }

    public static function exec($library, $classe, $metodo, $params)
    {
        $className = 'Uspdev\\' . $library . '\\' . $classe;
        return $className::$metodo(...$params);
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
