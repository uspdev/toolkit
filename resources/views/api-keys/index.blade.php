@extends('laravel-usp-theme::master')

@include('laravel-usp-theme::blocos.datatable-simples')

@section('title', 'API do Toolkit')

@section('content')
  @include('api-keys.partials.header')
  @include('api-keys.partials.integration')
  @include('api-keys.partials.help-modal')
  @include('api-keys.partials.manager')
@endsection

@section('javascripts_bottom')
  @parent
  @include('api-keys.partials.scripts')
@endsection
