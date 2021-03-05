@extends('laravel-usp-theme::master')

@section('title') Sistema USP @endsection

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