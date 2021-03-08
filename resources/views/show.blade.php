@extends('laravel-usp-theme::master')

@section('title', $metodo)

@section('content')
  <div class="row">
    <div class="col-12">
      <div class="form-inline float-left">
        <span class="h4"><a href="Replicado/{{ $classe->getShortName() }}"> {{ $classe->getShortName() }}</a>
          <i class="fas fa-angle-right"></i> {{ $metodo }}({{ implode(',', $params) }})</span>
        @include('partials.params', ['m'=>$methodReflection])
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
      Resultado @include('partials.tipos')
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
      $('.datatable-custom').DataTable({
        dom: 'fitp', // https://datatables.net/examples/basic_init/dom.html
        paginate: false,
        "buttons": [
          'excelHtml5', 'csvHtml5'
        ]
      });

      $('.docblock_btn').click(function() {
        $('.docblock').slideToggle()
      })

    });

  </script>

@endsection
