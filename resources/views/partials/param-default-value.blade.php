@if($p->isDefaultValueAvailable())
  {{ json_encode($p->getDefaultValue()) }}
@endif
