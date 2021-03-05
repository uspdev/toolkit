@extends('laravel-usp-theme::master')

@section('title', $metodo)

@section('content')
  <div class="form-inline">
    Chamada: <b>{{ $classe }}::{{ $metodo }}({{ implode(',', $params) }})</b>
    @include('partials.params', ['m'=>$methodReflection])
  </div>
  <div>Resultado</div>
  @if ($type == 'multi_array')
    <table class="table table-stripped table-hover table-bordered datatable-custom no-footer">
      <thead>
        <tr>
          @foreach ($keys as $key)
            <th>
              {{ $key }}
            </th>
          @endforeach
      </thead>
      <tbody>
        @foreach ($data as $row)
          <tr>
            @foreach ($row as $col)
              <td>
                {{ $col }}
              </td>
            @endforeach
          </tr>
        @endforeach
      </tbody>
    </table>
  @endif
  @if ($type == 'simple_array')
    <table class="table table-stripped table-hover table-bordered no-footer">
      <tr>
        <th>Chave</th>
        <th>Valor</th>
      </tr>
      @foreach ($data as $key => $val)
        <tr>
          <td>{{ $key }}</td>
          <td>{{ $val }}</td>
        </tr>
      @endforeach
    </table>
  @endif
  @if($type == 'string')
  {{ $data }}
  @endif
  @if($type == 'boolean')
  Booleano: 
  @if($data === true) Verdadeiro @endif
  @if($data === false) Falso @endif
  @endif
@endsection

@section('javascripts_bottom')
  @parent
  @include('partials.params-js')
  <script>
      $(document).ready(function() {
        $('.datatable-custom').DataTable( {
            dom: 'fitp', // https://datatables.net/examples/basic_init/dom.html
            paginate: false,
            "buttons": [
            'excelHtml5'
            , 'csvHtml5'
        ]
        } );
    } );
  </script>

@endsection
