@extends('laravel-usp-theme::master')

@section('title', 'Sistemas USPDev')

@section('content')

<h4>Laravel USP Theme</h4>
<form method="POST" action="theme-skin-change" class="form-inline">
    @csrf
    <label class="mr-3">Skins disponíveis</label>
    <select name="skin" class="form-control form-control-sm skin-select">
        @foreach(config('laravel-usp-theme.available-skins') as $sk)
        <option value="{{ $sk }}" {{ (session('laravel-usp-theme.skin') == $sk or $skin == $sk) ? 'selected' : '' }}>
            {{ $sk }} {{ config('laravel-usp-theme.skin') == $sk ? '(.env)' : ''}}
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

<h4>Senha única</h4>

<ul>
    <li>O login/logout não afeta a funcionalidade desse sistema.</li>
</ul>


<h4>Foto</h4>
<ul>
    <li>
        <a href="Wsfoto/obter">Uspdev\Wsfoto::obter</a>
    </li>
</ul>

@foreach (\App\Models\Library::libs as $library)
<h4>{{ $library }} </h4>
<ul>
    @foreach ($classes[$library] as $classe)
    <li>
        <a href="library/{{$library}}/{{ substr($classe, strrpos($classe, '\\') + 1, strlen($classe)) }}">{{ $classe }}</a>
    </li>
    @endforeach
</ul>
@endforeach


@endsection

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
