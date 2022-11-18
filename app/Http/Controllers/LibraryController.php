<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Library;
use Illuminate\Http\Request;

class LibraryController extends Controller
{
    public static function index($library)
    {
        $classes = Library::listarClasses($library);
        return view('library.index', [
            'classes' => $classes,
            'library' => $library,
        ]);
    }

    public function methods($library, $class)
    {
        $classe = Library::listarMetodos($library, $class);
        return view('library.methods', [
            'classe' => $classe,
            'library' => $library,
        ]);
    }

    public function show(Request $request, $library, $class, $method)
    {
        $data = [];
        $paramString = '';
        $keys = [];
        $type = '';
        $exectime = 0;
        if ($request->isMethod('post')) {
            $inputs = $request->all();
            unset($inputs['_token']);
            list($params, $paramString) = SELF::params($inputs);
            $exectime = -microtime(true);
            $data = SELF::exec($library, $class, $method, $params);
            $exectime += microtime(true);
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
            'data' => $data,
            'paramString' => $paramString,
            'keys' => $keys,
            'library' => $library,
            'execTime' => number_format($exectime, 3),
        ]);

    }

    protected static function exec($library, $classe, $metodo, $params)
    {
        $className = 'Uspdev\\' . $library . '\\' . $classe;
        // dd($className,$metodo,$params);
        // $r = \Uspdev\Replicado\Graduacao::listarDisciplinasAluno(12544097,1);
        // dd($r);
        return $className::$metodo(...$params);
    }

    /**
     * Pega os inputs do form e transforma em params e paramsString prontos para a query
     */
    protected static function params($inputs)
    {
        //dd($inputs);
        $params = [];
        $paramString = '';
        foreach ($inputs as $v) {
            if ($v !== null) {
                $v_array = json_decode($v, true);
                if (is_numeric($v) || $v === '0') { // é um número, nesse caso sempre inteiro
                    $paramString .= $v . ', ';
                    $v = intval($v);
                } elseif (json_last_error() === JSON_ERROR_NONE) { // é um json valido
                    $v = $v_array;
                    //dd($v);
                    // dd(json_encode(["nomabvset"=>"SET"]));
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
