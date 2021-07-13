<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Library;
class MainController extends Controller
{

    private $baseNamespace = 'Uspdev\\';

    public function index()
    {
        $replicado = [
            'text' => 'Replicado',
            'url' => 'replicado',
            'submenu' => [
                [
                    'text' => 'submenu1',
                    'url' => 'submenu',
                ],
                [
                    'text' => 'submenu2',
                    'url' => '',
                ],
            ],
        ];
        \UspTheme::activeUrl('replicado');
        \UspTheme::addMenu('replicado', $replicado);



        $classes = [];
        foreach (Library::libs as $library) {
            $classes[$library] = Library::listarClasses($library);
        }
        return view('index', [
            'libs' => Library::libs,
            'classes' => $classes,
            'user' => \Auth()->user(),
        ]);
    }

}
