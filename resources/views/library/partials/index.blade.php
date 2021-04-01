<div class="card">
<div class="card-header h4">
  <div class="form-inline">
    {{ $library }}
  </div>
</div>
<div class="card-body">
  <table class="table table-stripped table-hover table-bordered listar-metodos no-footer">
    <tr>
      <th>
        Classes
      </th>
      @foreach ($classes as $classe)
    <tr>
      <td>
        <a href="library/{{$library}}/{{ substr($classe, strrpos($classe, '\\') + 1, strlen($classe)) }}">
          {{ $classe }}
        </a>
      </td>
    </tr>
    @endforeach
  </table>
</div>
</div>
