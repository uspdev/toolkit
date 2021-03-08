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
