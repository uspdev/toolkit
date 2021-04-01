<table class="table table-stripped table-hover table-bordered no-footer">
  <tr>
    <th>Chave</th>
    <th>Valor</th>
  </tr>
  @foreach ($data as $key => $val)
    <tr>
      <td>{{ $key }}</td>
      <td>
        @if (is_array($val))
          <pre>{{ json_encode($val, JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE) }}</pre>
        @else
          {{ $val }}
        @endif
      </td>
    </tr>
  @endforeach
</table>
