@php
$factory = \phpDocumentor\Reflection\DocBlockFactory::createInstance();
$docblock = $factory->create($m->getDocComment());
$serializer = new \phpDocumentor\Reflection\DocBlock\Serializer();
@endphp
@if($showall ?? false)
<pre>{{ $serializer->getDocComment($docblock) }}</pre><br>
@else
{{ Str::limit($docblock->getSummary(),70) }}<br>
@endif
{{-- {{ $docblock->getDescription() }}<br>
@foreach ($docblock->getTags() as $tag)
  {{ $tag }}<br>
@endforeach --}}
