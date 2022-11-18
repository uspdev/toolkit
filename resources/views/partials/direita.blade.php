<h4>Foto</h4>
<ul>
  <li>
    <a href="Wsfoto/obter">Uspdev\Wsfoto::obter</a>
  </li>
</ul>

@foreach (\App\Models\Library::libs as $library)
  <h4>{{ $library }} </h4>
  <ul>
    @foreach ($classes[$library] as $classe)
      <li>
        <a
          href="library/{{ $library }}/{{ substr($classe, strrpos($classe, '\\') + 1, strlen($classe)) }}">{{ $classe }}</a>
      </li>
    @endforeach
  </ul>
@endforeach

