<form class="form-inline" method="POST" action="library/{{ $library }}/{{ $class }}/{{ $m->getName() }}">
  @csrf
  @forelse ($m->getParameters() as $i => $p)
    <div class="input-group input-group-sm mx-sm-2">

      {{-- mostrando * se for campo obrigatório --}}
      @if (!$p->isOptional())
        <div class="input-group-prepend">
          <div class="input-group-text"><i class="fas fa-asterisk text-danger"></i></div>
        </div>
      @endif

      {{-- O campo a ser preenchido --}}
      <input class="form-control" size="8" type="text" name="{{ $p->name }}" value="{{ $params[$i] ?? '' }}"
        placeholder="{{ $p->name }}" {{ $p->isOptional() ? '' : 'required' }}>

      {{-- mostrando valores default se houver --}}
      @if ($p->isDefaultValueAvailable())
        <span class="mt-1 ml-1">({{ json_encode($p->getDefaultValue()) }})</span>
      @endif

    </div>
  @empty
    <span class="badge badge-primary mx-2">Sem parâmetros</span>
  @endforelse
  <button class="btn submit_btn p-0" data-toggle="tooltip" data-placement="right" title="Executa o método">
    <i class="fas fa-lg fa-chevron-circle-right text-success"></i>
  </button>
</form>
