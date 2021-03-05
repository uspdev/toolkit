@extends('laravel-usp-theme::master')

@section('title') Sistema USP @endsection

@section('content')
  <h4>Pessoa</h4>

  <table class="table table-stripped table-hover table-bordered datatable no-footer">
    <thead>
      <tr>
        <th>
          Método
        </th>
        <th>
          Parametros</th>
      </tr>
    </thead>
    <tbody>
      @foreach ($classe->getMethods() as $m)
        <tr>
          <td class="form-inline">
            {{ $m->getName() }} @include('partials.params')
          </td>
          <td style="width:40%">
            @include('partials.docblock')
          </td>
        </tr>
      @endforeach
    </tbody>
  </table>

@endsection

@section('footer')
  {{-- Seu código --}}
@endsection

@section('javascripts_bottom')
  @parent
  {{-- Seu código .js --}}
@endsection

@section('javascripts_bottom')
  @parent
  @include('partials.params-js')

@endsection
