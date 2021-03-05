<form class="form-inline" method="POST" action="Pessoa/{{ $m->getName() }}">
  @csrf
  @foreach ($m->getParameters() as $p)
    @php
      $required = $p->isOptional() ? '' : 'required';
    @endphp
    <div class="input-group input-group-sm mx-sm-2">
      @if (!$p->isOptional())
        <div class="input-group-prepend">
          <div class="input-group-text"><i class="fas fa-asterisk text-danger"></i></div>
        </div>
      @endif
      <input class="form-control" type="text" name="{{ $p->name }}" 
      placeholder="{{ $p->name }}" value="@include('partials.param-default-value')"
        {{ $required }}>
    </div>
  @endforeach
  <button class="btn btn-sm btn-light submit_btn">OK</button>
</form>
