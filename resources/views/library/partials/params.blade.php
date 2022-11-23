@if($m->isPublic())
<form class="form-inline" method="POST" action="library/{{ $library }}/{{ $class }}/{{ $m->getName() }}">
    @csrf
    @forelse ($m->getParameters() as $p)
    @php( $required = $p->isOptional() ? '' : 'required' )
    <div class="input-group input-group-sm mx-sm-2">
        @if (!$p->isOptional())
        <div class="input-group-prepend">
            <div class="input-group-text"><i class="fas fa-asterisk text-danger"></i></div>
        </div>
        @endif
        <input class="form-control" type="text" name="{{ $p->name }}" placeholder="{{ $p->name }}" value="" {{ $required }}> @include('partials.param-default-value')
    </div>
    @empty
    <span class="badge badge-primary mx-2">Sem parâmetros</span>
    @endforelse
    <button class="btn submit_btn p-0" data-toggle="tooltip" data-placement="right" title="Executa o método">
        <i class="fas fa-lg fa-chevron-circle-right text-success"></i>
    </button>
</form>
@else
<span class="badge badge-warning ml-2">Método privado</span>
@endif
