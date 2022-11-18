@extends('laravel-usp-theme::master')

@section('title', 'Sistemas USPDev')

@section('content')

  <div>
    <p>Toolkit é uma ferramenta para testar diversas funcinalidades das bibliotecas USPDev.</p>
    <p>Ela é voltada para desenvolvedores a fim de testar métodos e funcionalidades específicas.</p>
  </div>
  <hr>
  <div class="row">
    <div class="col-md-7">
      @include('partials.esquerda')
    </div>
    <div class="col-md-5">
      @include('partials.direita')
    </div>
  </div>

@endsection
