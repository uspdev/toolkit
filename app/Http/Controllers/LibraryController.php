<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Library;
use App\Models\Metodo;
use Illuminate\Http\Request;

class LibraryController extends Controller
{

    /**
     * Dado uma biblioteca $library, retorna a lista as classes disponíveis
     * 
     * @param string $library Nome da biblioteca
     */
    public static function index($library)
    {
        \UspTheme::activeUrl('library/' . $library);

        $classes = Library::listarClasses($library);
        return view('library.index', [
            'classes' => $classes,
            'library' => $library,
        ]);
    }

    /**
     * Dado a biblioteca e a classe, retorna a lista de métodos disponíveis
     * 
     * @param string $library Nome da biblioteca
     * @param string $class Nome da classe
     */
    public function methods($library, $class)
    {
        \UspTheme::activeUrl('library/' . $library);

        return view('library.methods', [
            'classReflection' => Library::listarMetodos($library, $class),
            'class' => $class,
            'library' => $library,
        ]);
    }

    /**
     * Mostra as informações de um método
     */
    public function show(Request $request, $library, $class, $method)
    {
        \UspTheme::activeUrl('library/' . $library);

        $metodo = new Metodo("Uspdev\\{$library}\\" . $class, $method);

        if ($request->isMethod('post')) {
            // todos os parametros do método
            $inputs = $request->all();
            unset($inputs['_token']);

            $metodo->atribuirParams($inputs);
            $data = $metodo->exec();
            list($type, $keys) = SELF::tipoDados($data);
        }

        return view('library.show', [
            'library' => $library,
            'class' => $class,
            'metodo' => $metodo,
            'methodReflection' => $metodo->obterReflection(),
            'type' => $type ?? '',
            'keys' => $keys ?? [],
        ]);
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
