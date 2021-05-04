@extends('laravel-usp-theme::master')

@section('title', $metodo)

@section('content')
<div class="row">
    <div class="col-12">
        <div class="form-inline float-left">
            <span class="h4">
                {{-- {{ $library }} <i class="fas fa-angle-right"></i> --}}
                <a href="library/{{ $library }}/{{ $classe->getShortName() }}"> {{ $classe->getShortName() }}</a>
                <i class="fas fa-angle-right"></i>
                {{ $metodo }}({{ $paramString }})
            </span>
            @include('library.partials.params', ['m'=>$methodReflection])
        </div>
        <div class="float-right"><button class="btn btn-sm btn-primary docblock_btn">Docblock</button></div>
    </div>
</div>
<div>
    <div class="docblock my-2" style="display:none">
        @include('partials.docblock',['m'=>$methodReflection, 'showall'=>true])
    </div>
</div>
<div class="card mt-2">
    <div class="card-header h4">
        <div class="form-inline">
            Resultado @include('partials.tipos')
            @includewhen($type == 'multi_array','partials.datatable-totalbox')
            @includewhen($type == 'multi_array','partials.datatable-filterbox')
            @include('partials.exectime')
        </div>
    </div>
    <div class="card-body">
        @if ($type == 'multi_array')
        @include('partials.show-multiarray')
        @endif
        @if ($type == 'simple_array')
        @include('partials.show-simplearray')
        @endif
        @if ($type == 'string')
        {{ $data }}
        @endif
        @if ($type == 'boolean')
        Booleano:
        @if ($data === true) Verdadeiro @endif
        @if ($data === false) Falso @endif
        @endif
    </div>
</div>
@endsection

@section('javascripts_bottom')
@parent
{{-- @include('partials.params-js') --}}
<script>
    $(document).ready(function() {

        // Botão para mostrar o docblock
        $('.docblock_btn').click(function() {
            $('.docblock').slideToggle()
        })

    });

</script>

@endsection
