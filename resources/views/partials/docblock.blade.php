@php
$factory = \phpDocumentor\Reflection\DocBlockFactory::createInstance();
$comment = $m->getDocComment() ? $m->getDocComment() : '-- vazio --';
$docblock = $factory->create($comment);
//$serializer = new \phpDocumentor\Reflection\DocBlock\Serializer();
@endphp
@if ($showall ?? false)
  <div class="card docblock_content">
    <div class="card-body">
      <pre>{{ $comment }}</pre>
    </div>
  </div>
@else
  {!! Str::limit($docblock->getSummary(), 120) !!}
@endif
{{-- {{ $docblock->getDescription() }}<br>
@foreach ($docblock->getTags() as $tag)
  {{ $tag }}<br>
@endforeach --}}
