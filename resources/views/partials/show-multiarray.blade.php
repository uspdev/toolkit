<table class="table table-stripped table-hover table-bordered resultado-multiarray no-footer">
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

@section('javascripts_bottom')
  @parent
  <script>
    $(document).ready(function() {

      oTable = $('.resultado-multiarray').DataTable({
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
