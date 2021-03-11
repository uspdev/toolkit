<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class MainController extends Controller
{

    private $baseNamespace = 'Uspdev\\';

    public function index()
    {

        $classes = ReplicadoController::listarClasses(true);
        return view('index', compact('classes'));
    }

    public function listarMetodos($nameSpace, $classe)
    {
        $classe = UspdevController::listarMetodos($nameSpace, $classe);
        return view('classe', compact('classe'));
    }

    public function show(Request $request, $nameSpace, $classe, $metodo)
    {
        $data = [];
        $paramString = '';
        $keys = [];
        $type = '';
        if ($request->isMethod('post')) {
            $inputs = $request->all();
            unset($inputs['_token']);
            list($params, $paramString) = UspdevController::params($inputs);
            $data = UspdevController::show($nameSpace . '\\' . $classe, $metodo, $params);
            list($type, $keys) = UspdevController::tipoDados($data);
        }

        $className = 'Uspdev\\' . $nameSpace . '\\' . $classe;
        $classe = new \ReflectionClass($className);
        $methodReflection = new \ReflectionMethod($className, $metodo);

        return view('show', compact('type', 'methodReflection', 'classe', 'metodo', 'data', 'paramString', 'keys'));

    }

}
