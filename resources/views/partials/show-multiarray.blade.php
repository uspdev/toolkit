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
