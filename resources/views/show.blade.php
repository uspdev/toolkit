@extends('laravel-usp-theme::master')

@section('title', $metodo)

@section('content')
  <div class="form-inline">
    <span class="h4"><a href="{{ $classe }}"> {{ $classe }}</a>
      <i class="fas fa-angle-right"></i> {{ $metodo }}({{ implode(',', $params) }})</span>
    @include('partials.params', ['m'=>$methodReflection])
  </div>
  <div>
    <button class="btn btn-sm btn-primary docblock_btn">Docblock</button>
    <div class="docblock d-none">
      @include('partials.docblock',['m'=>$methodReflection, 'showall'=>true])
    </div>
  </div>
  <div class="h4">Resultado</div>
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
  @if ($type == 'string')
    {{ $data }}
  @endif
  @if ($type == 'boolean')
    Booleano:
    @if ($data === true) Verdadeiro @endif
    @if ($data === false) Falso @endif
  @endif
@endsection

@section('javascripts_bottom')
  @parent
  @include('partials.params-js')
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
        $('.docblock').toggleClass('d-none')
      })

    });

  </script>

@endsection
