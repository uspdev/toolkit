@extends('laravel-usp-theme::master')

@section('title', 'Sistemas USPDev')

@section('content')

<h4>Laravel USP Theme</h4>

Visualize a página de demo incluída no theme. Há exemplos de uso do datatables, datepicker,
select2 e mask. Ajuste o USP_THEME_SKIN para ver outros skins.
<ul>
    <li><a href="theme">Theme</a></li>
</ul>

<h4>Senha única</h4>

<ul>
    <li>O login/logout não afeta a funcionalidade desse sistema.</li>
</ul>


<h4>Foto</h4>
<ul>
    <li>
        <a href="Wsfoto/obter">Uspdev\Wsfoto::obter</a>
    </li>
</ul>

@foreach (\App\Models\Library::libs as $library)
<h4>{{ $library }} </h4>
<ul>
    @foreach ($classes[$library] as $classe)
    <li>
        <a href="library/{{$library}}/{{ substr($classe, strrpos($classe, '\\') + 1, strlen($classe)) }}">{{ $classe }}</a>
    </li>
    @endforeach
</ul>
@endforeach


@endsection
