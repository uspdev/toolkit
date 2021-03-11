<span class="badge badge-pill badge-primary ml-2" id="oTable-total">- carregando -</span>

@section('javascripts_bottom')
  @parent
  {{-- @include('partials.params-js') --}}
  <script>
    $(document).ready(function() {

      $('#oTable-total').html(oTable.rows({
        search: 'applied'
      }).count())

      oTable.on('search', function() {
        $('#oTable-total').html(oTable.rows({
          search: 'applied'
        }).count())
      })

    })

  </script>
@endsection
