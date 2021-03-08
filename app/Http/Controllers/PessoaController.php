<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use HaydenPierce\ClassFinder\ClassFinder;
use Illuminate\Http\Request;

class PessoaController extends Controller
{

    public function listarClasses()
    {
        $classes = ClassFinder::getClassesInNamespace('Uspdev\Replicado');
        return view('index', compact('classes'));
    }

    public function listarMetodos($classe)
    {
        $classe = new \ReflectionClass('Uspdev\\Replicado\\' . $classe);
        return view('classe', compact('classe'));
    }

    public function show(Request $request, $classe, $metodo)
    {
        $className = 'Uspdev\\Replicado\\' . $classe;
        $classe = new \ReflectionClass($className);
        $methodReflection = new \ReflectionMethod($className, $metodo);
        $keys = $data = [];
        $type = '';
        $params = [];
        $paramString = '';

        if ($request->isMethod('post')) {

            $inputs = $request->all();
            unset($inputs['_token']);
            foreach ($inputs as $v) {
                if (is_numeric($v)) { // é um número, nesse caso sempre inteiro
                    $v = intval($v);
                } elseif (substr($v, 0, 1) == '[') { // é um array
                    $v = json_decode("{$v}", true);
                }
                if ($v) {
                    array_push($params, $v);
                }
            }

            // vamos executar o método e guardar a saída
            $data = $className::$metodo(...$params);

            // vamos avaliar o tipo da saída para renderizar corretamente na view
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

            foreach ($params as $p) {
                if (is_array($p)) {
                    $paramString .= '[' . implode(',', $p) . '], ';
                } else {
                    $paramString .= $p . ', ';
                }
            }
            $paramString = substr($paramString, 0, -2);
        }

        return view('show', compact('type', 'methodReflection', 'classe', 'metodo', 'data', 'paramString', 'keys'));
    }
}
