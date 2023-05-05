<form class="form-inline" method="POST" action="library/{{ $library }}/{{ $class }}/{{ $m->getName() }}">
  @csrf
  @forelse ($m->getParameters() as $i => $p)
    <div class="input-group input-group-sm mx-sm-2">
      @includeWhen (!$p->isOptional(), 'library.partials.obrigatorio')
      <input class="form-control" size="8" type="text" name="{{ $p->name }}" value="{{ $params[$i] ?? '' }}"
        placeholder="{{ $p->name }}" {{ $p->isOptional() ? '' : 'required' }}>
      @include('partials.param-default-value')
    </div>
  @empty
    <span class="badge badge-primary mx-2">Sem parâmetros</span>
  @endforelse
  <button class="btn submit_btn p-0" data-toggle="tooltip" data-placement="right" title="Executa o método">
    <i class="fas fa-lg fa-chevron-circle-right text-success"></i>
  </button>
</form>
