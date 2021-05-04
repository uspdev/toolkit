@extends('laravel-usp-theme::master')

@section('title') Sistema USP @endsection

@section('styles')
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
<div class="card">
    <div class="card-header h4">
        <div class="form-inline">
            {{ $library }} <i class="fas fa-angle-right mx-1"></i>
            {{ $classe->getShortName() }}
            @include('partials.datatable-totalbox')
            @include('partials.datatable-filterbox')
        </div>
    </div>
    <div class="card-body">
        <table class="table table-stripped table-hover table-bordered listar-metodos no-footer">
            <thead>
                <tr>
                    <th>Método</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($classe->getMethods() as $m)
                <tr>
                    <td>
                        <div class="form-inline">
                            {{-- vamos ajudar o datatables a ordenar --}}
                            <span style="display:none">{{ $m->getName() }}</span>

                            <a href="#" class="docblock_btn nostyle" data-toggle="tooltip" data-placement="top" title="@include('partials.docblock')">
                                {{ $m->getName() }}
                            </a>
                            @include('library.partials.params')
                        </div>
                        <div class="docblock_div my-2" style="display:none">
                            @include('partials.docblock',['showall'=>true])
                        </div>
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</div>

@endsection

@section('javascripts_bottom')
@parent
<script>
    $(document).ready(function() {

        oTable = $('.listar-metodos').DataTable({
            dom: 't'
            , "paging": false
            , "sort": true
            , "order": [
                [0, "asc"]
            ]
        })

        // Botão para mostrar o docblock
        $('.docblock_btn').click(function(e) {
            e.preventDefault()
            $(this).closest('td').find('.docblock_div').slideToggle()
        })

        $('[data-toggle="tooltip"]').tooltip({
            html: true
            , boundary: 'window'
        })

    })

</script>
@endsection
