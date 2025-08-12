<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class WsfotoController extends Controller
{
    public function show(Request $request)
    {
        \UspTheme::activeUrl('Wsfoto/obter');
        
        $data = [];
        $paramString = '';
        if ($request->isMethod('post')) {
            $data = SELF::exec('obter', [$request->codpes]);
            $paramString = $request->codpes;
        }
        $methodReflection = new \ReflectionMethod('Uspdev\\Wsfoto', 'obter');
        return view('wsfoto.show', compact('methodReflection', 'data', 'paramString'));
    }

    protected function exec($metodo, $params)
    {
        $className = 'Uspdev\Wsfoto';
        $data = $className::$metodo(...$params);
        return $data;
    }
}
