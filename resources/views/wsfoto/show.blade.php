@extends('laravel-usp-theme::master')

@section('title', 'Wsfoto::obter')

@section('content')
  <div class="row">
    <div class="col-12">
      <div class="form-inline float-left">
        <span class="h4">Wsfoto
          <i class="fas fa-angle-right"></i> obter({{ $paramString }})</span>
        <form class="form-inline" method="POST" action="Wsfoto/obter">
          @csrf
          <div class="input-group input-group-sm mx-sm-2">
            <input class="form-control" type="text" name="codpes" placeholder="codpes" value="" required>
          </div>
          <button class="btn submit_btn p-0"><i class="fas fa-lg fa-chevron-circle-right text-success"></i></button>
        </form>
      </div>
      <div class="float-right"><button class="btn btn-sm btn-primary docblock_btn">Docblock</button></div>
    </div>
  </div>
  <div>
    <div class="docblock my-2" style="display:none">
      @include('partials.docblock',['m'=>$methodReflection, 'showall'=>true])
    </div>
  </div>
  <div class="card mt-2">
    <div class="card-header h4">
      <div class="form-inline">
        Resultado
      </div>
      <div class="card-body">
        @if ($data)
          <img src="data: image/jpeg; base64, {{ $data }}">
        @endif
      </div>
    </div>
  @endsection

  @section('javascripts_bottom')
    @parent
    {{-- @include('partials.params-js') --}}
    <script>
      $(document).ready(function() {

        // Botão para mostrar o docblock
        $('.docblock_btn').click(function() {
          $('.docblock').slideToggle()
        })

      });

    </script>

  @endsection
