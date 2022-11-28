<h4>Laravel USP Theme</h4>

{{-- {{ json_encode(get_latest_release()) }} --}}

<div class="ml-3">
  <form method="GET" action="theme-skin-change" class="form-inline">
    @csrf
    <label class="mr-3">Skins disponíveis</label>
    <select name="skin" class="form-control form-control-sm skin-select">
      @foreach (config('laravel-usp-theme.available-skins') as $sk)
        <option value="{{ $sk }}" {{ $skin == $sk ? 'selected' : '' }}>
          {{ $sk }} {{ config('laravel-usp-theme.skin') == $sk ? '(.env)' : '' }}
        </option>
      @endforeach
    </select>
  </form>
  <br>
  Visualize a página de demo incluída no theme. Há exemplos de uso do datatables, datepicker,
  select2 e mask.

  <ul>
    <li><a href="theme">Theme</a></li>
  </ul>

  O Theme, em conjunto com a senha única e permisssion pode mostrar menus de acordo com os gates pré-definidos: user,
  gerente e admin.<br>
</div>
<br>
<h4>Senha única</h4>

<ul>
  <li>
    O login mostrará menus com gates específicos para gerente e admin.
    Pode-se utilizar o <a href="https://github.com/uspdev/senhaunica-faker">senhaunica-faker</a> para testes.
  </li>
  <li>
    <a href="@if (config('senhaunica.prefix')) {{ config('senhaunica.prefix') }}/loginas @else loginas @endif">
      Gerenciador de usuários
    </a>
    interno da biblioteca
  </li>
</ul>
<div class="ml-3">
  <h5>Assumir identidade (somente admins)</h5>
  <div class="ml-3">
    Usuário corrente: {{ $user->codpes ?? 'Não logado' }} - {{ $user->name ?? '' }} - {{ $user->email ?? '' }}
    <form class="form-inline" method="POST" action="loginas">
      @csrf
      informe o codpes: <input class="form-control form" type="text" name="codpes" value="{{ old('codpes') }}">
      <input class="btn btn-primary" type="submit" name="OK" value="OK">
      @error('codpes')
        <span class="alert alert-danger ml-3"
          style="height: 40px; line-height:40px; margin-bottom: 1px; padding:0px 20px;">{{ $message }}</span>
      @enderror
    </form>
  </div>
</div>
<br>

<h4>
  Senha de APP Google
</h4>
<form method="POST" action="senha-de-app">
  @csrf
  E-mail: <input type="email" name="email">
  Senha: <input type="password" name="senha"><br>
  Servidor: <input type="text" name="servidor" value="smtp.googlemail.com">
  Porta: <input type="text" name="porta" value="465">
  Segurança: <input type="text" name="seguranca" value="ssl"><br>
  <input type="submit">
</form>


@section('javascripts_bottom')
  <script>
    // autosubmit para skin changer
    $(document).ready(function() {
      $('.skin-select').change(function() {
        this.form.submit()
      })
    })
  </script>
@endsection
