@extends('laravel-usp-theme::master')

{{-- Blocos do laravel-usp-theme --}}

{{-- Target:card-header; class:card-header-sticky --}}
@include('laravel-usp-theme::blocos.sticky')

{{-- Target: button, a; class: btn-spinner, spinner --}}
@include('laravel-usp-theme::blocos.spinner')

{{-- Target: table; class: datatable-simples --}}
@include('laravel-usp-theme::blocos.datatable-simples')
{{-- @include('laravel-usp-theme::blocos.datatable-responsive-system-wide') --}}
{{-- @include('laravel-usp-theme::blocos.datatable-language-system-wide') --}}

{{-- Fim de blocos do laravel-usp-theme --}}


@section('title')
  Sistema USP
@endsection

@section('content')
  @parent
@endsection

@section('footer')
  {{-- Seu código --}}
@endsection

@section('javascripts_bottom')
  @parent
  {{-- Seu código .js --}}
@endsection
