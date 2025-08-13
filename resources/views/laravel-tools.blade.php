@extends('laravel-usp-theme::master')

@section('content')

<h2>Laravel Tools - Helpers</h2>

<div>
  <b>HasReplicado</b>: {{ hasReplicado() ? 'Sim' : 'Não' }}<br>
  <b>HasUspTheme</b>: {{ hasUspTheme() ? 'Sim' : 'Não' }}<br>
  <b>HasSenhaunica</b>: {{ hasSenhaunica() ? 'Sim' : 'Não' }}<br>
  <b>AppVersion</b>: {{ appVersion() }}<br>
  <b>Linkify</b>: 'https://www.uspdigital.usp.br' -> {!! linkify('https://www.uspdigital.usp.br') !!}<br>
  <b>Markdown to HTML</b>: <br>
  '## Título\n\nTexto em **negrito** e *itálico*'<br>
  {!! md2html("## Título 2\n\nTexto em **negrito** e *itálico*") !!}<br>
</div>

@endsection