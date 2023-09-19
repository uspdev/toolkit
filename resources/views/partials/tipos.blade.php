<span class="badge badge-primary ml-2">
  @switch($type)
    @case('multi_array')
      Lista
    @break

    @case('simple_array')
      Registro
    @break

    @case('string')
      Valor
    @break

    @case('boolean')
      Verdadeiro/Falso
    @break
  @endswitch
</span>
