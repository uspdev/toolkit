<div class="card mt-2">
  <div class="card-header h4">
    <div class="form-inline">
      Resultado
      @include('partials.tipos')
      {{-- @includewhen($type == 'multi_array', 'partials.datatable-totalbox') --}}
      {{-- @includewhen($type == 'multi_array', 'partials.datatable-filterbox') --}}
      <span class="badge badge-info ml-2"><i class="far fa-hourglass"></i> {{ $metodo->exectime }} s</span>
      @if ($metodo->paramString)
        <small class="ml-3">(Parametros: {{ $metodo->paramString }})</small>
      @endif
    </div>
  </div>
  <div class="card-body">
    @if ($type == 'multi_array')
      @include('partials.show-multiarray')
    @endif
    @if ($type == 'simple_array')
      @include('partials.show-simplearray')
    @endif
    @if ($type == 'string')
      {{ $metodo->exec }}
    @endif
    @if ($type == 'boolean')
      Booleano:
      @if ($metodo->exec === true)
        Verdadeiro
      @endif
      @if ($metodo->exec === false)
        Falso
      @endif
    @endif
  </div>
</div>
