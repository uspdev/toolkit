@php
$factory = \phpDocumentor\Reflection\DocBlockFactory::createInstance();
$docblock = $factory->create($m->getDocComment());
$serializer = new \phpDocumentor\Reflection\DocBlock\Serializer();
@endphp
{{-- {{ $serializer->getDocComment($docblock) }}<br> --}}
{{ Str::limit($docblock->getSummary(),70) }}<br>
{{-- {{ $docblock->getDescription() }}<br>
@foreach ($docblock->getTags() as $tag)
  {{ $tag }}<br>
@endforeach --}}
