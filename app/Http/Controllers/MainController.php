<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Library;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;
use Illuminate\Validation\Rule;

class MainController extends Controller
{

    private $baseNamespace = 'Uspdev\\';

    public function index()
    {
        $replicado =
            [
            [
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
            ],
            [
                'text' => 'segundo menu',
                'url' => '',
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

    public function themeSkinChange(Request $request)
    {
        $request->validate([
            'skin' => [
                'required:',
                Rule::in(config('laravel-usp-theme.available-skins')),
            ],
        ]);

        \UspTheme::setSkin($request->skin);
        return back();
    }

    public function senhaDeApp(Request $request)
    {
        $to_name = 'Masaki';
        $to_email = 'kawabata@usp.br';
        $data = array('name' => 'Ogbonna Vitalis(sender_name)', 'body' => 'A test mail');
        Mail::send(['text' => 'mail'], $data, function ($message) use ($to_name, $to_email) {
            $message->to($to_email, $to_name)->subject('Laravel Test Mail');
            $message->from('chamados+from@eesc.usp.br', 'Test Mail');
        });
        echo "Basic Email Sent. Check your inbox.";
    }

    public function theme()
    {
        return view('theme');
    }

}
