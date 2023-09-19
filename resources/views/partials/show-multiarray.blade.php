<table
  class="table table-stripped table-hover table-bordered resultado-multiarray dt-buttons dt-fixed-header datatable-simples">
  <thead>
    <tr>
      @foreach ($keys as $key)
        <th>
          {{ $key }}
        </th>
      @endforeach
  </thead>
  <tbody>
    @foreach ($metodo->exec as $row)
      <tr>
        @foreach ($row as $col)
          <td>
            @if (is_array($col))
              <pre>{{ json_encode($col, JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE) }}</pre>
            @else
              {{ $col }}
            @endif
          </td>
        @endforeach
      </tr>
    @endforeach
  </tbody>
</table>
