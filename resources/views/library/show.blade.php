@extends('laravel-usp-theme::master')

@section('title', $metodo . ' | '. $library)

@section('styles')
{{-- repetido do methods.blade.php
seria legal juntar e dar include --}}
<style>
    a.nostyle:link {
        text-decoration: inherit;
        color: inherit;
    }

    a.nostyle:visited {
        text-decoration: inherit;
        color: inherit;
    }

    /* https://stackoverflow.com/questions/14596743/how-do-you-change-the-width-and-height-of-twitter-bootstraps-tooltips */
    .tooltip-inner {
        max-width: 800px;
        color: #000;
        background-color: #B2EBF2;
        border-radius: .25rem;
        font-size: 15px;
    }

    .docblock_content {
        background-color: #B2EBF2;
        font-size: 15px;
    }

</style>
@endsection

@section('content')
<div class="row">
    <div class="col-12">
        <div class="form-inline float-left">
            <span class="h4">
                <a href="library/{{ $library }}/{{ $classe->getShortName() }}"> {{ $classe->getShortName() }}</a>
                <i class="fas fa-angle-right"></i>
                <a href="#" class="nostyle" data-toggle="tooltip" data-placement="top" title="@include('partials.docblock', ['m'=>$methodReflection])">
                    {{ $metodo }} 
                </a>
                <button class="badge badge-info badge-pill docblock_btn">doc <i class="fas fa-caret-down"></i></button>
                ({{ $paramString }})
            </span>
            @include('library.partials.params', ['m'=>$methodReflection])
        </div>
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
            @includewhen(!empty($exectime),'partials.exectime')
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
        $('.docblock_btn').click(function(e) {
            e.preventDefault()
            $('.docblock').slideToggle()
        })

        // tooltip
        $('[data-toggle="tooltip"]').tooltip({
            html: true
            , boundary: 'window'
        })

    });

</script>

@endsection
