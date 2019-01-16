


@section('title', 'Sesión Terminada')

@section('message', 'Redirigiendo a la pagina de inicio.')
<div style="width: 1200px; margin: auto; text-align: center;">
    <br><br><br><br>
<h2>Redirigiendo a la pagina de inicio.</h2>
<img src="{{ asset('img/loading.gif') }}">
</div>
<meta http-equiv="refresh" content="1; URL='http://127.0.0.1:8000/'" />