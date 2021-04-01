@extends('laravel-usp-theme::master')

@section('title') Sistema USP @endsection

@section('content')
  <div class="card">
    <div class="card-header h4">
      <div class="form-inline">
        <a href="">Home</a> <i class="fas fa-angle-right mx-1"></i> {{ $classe->getShortName() }}
        @include('partials.datatable-totalbox')
        @include('partials.datatable-filterbox')
      </div>
    </div>
    <div class="card-body">
      <table class="table table-stripped table-hover table-bordered listar-metodos no-footer">
        <thead>
          <tr>
            <th>
              Método
            </th>
            <th>
              Docblock</th>
          </tr>
        </thead>
        <tbody>
          @foreach ($classe->getMethods() as $m)
            <tr>
              <td class="form-inline">
                {{ $m->getName() }} @include('library.partials.params')
              </td>
              <td style="width:40%">
                @include('partials.docblock')
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
        dom: 't',
        "paging": false,
        "sort": true,
        "order": [
          [0, "asc"]
        ]
      })

    })

  </script>
@endsection
