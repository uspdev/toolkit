@extends('laravel-usp-theme::master')

@section('title', 'Sistemas USPDev')

@section('content')

  <h4>Laravel USP Theme</h4>

  Visualize a página de demo incluída no theme. Há exemplos de uso do datatables, datepicker,
  select2 e mask.
  <ul>
    <li><a href="theme">Theme</a></li>
  </ul>

  <h4>Replicado</h4>
  <ul>
    @foreach ($classes as $classe)
      <li>
        <a href="Replicado/{{ substr($classe, strrpos($classe, '\\') + 1, strlen($classe)) }}">{{ $classe }}</a>
      </li>
    @endforeach
  </ul>

  <h4>Foto</h4>
  <ul>
    <li>
      <a href="Wsfoto/obter">Uspdev\Wsfoto::obter</a>
    </li>
  </ul>

  <h4>Utils</h4>
  <ul>
    @foreach ($classes as $classe)
      <li>
        <a href="Replicado/{{ substr($classe, strrpos($classe, '\\') + 1, strlen($classe)) }}">{{ $classe }}</a>
      </li>
    @endforeach
  </ul>


@endsection
