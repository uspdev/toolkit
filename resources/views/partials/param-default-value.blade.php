@if ($p->isDefaultValueAvailable())
  <span class="mt-1 ml-1">({{ json_encode($p->getDefaultValue()) }})</span>
@endif
