<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Library;

class MainController extends Controller
{

    private $baseNamespace = 'Uspdev\\';

    public function index()
    {
        $classes = []; 
        foreach(Library::libs as $library){
            $classes[$library] = Library::listarClasses($library);
        }
        return view('index', [
            'libs' => Library::libs,
            'classes' => $classes
        ]);
    }

}
