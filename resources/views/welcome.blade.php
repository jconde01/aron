@extends('layouts.app')

@section('title','Bienvenido a Aron')
@section('body-class','')

@section('content')
<div class="row">
    <div class="col-md-10 col-md-offset-1">
        <div class="jumbotron" id="jumbotron2">
            <h1 class="titulo">Bienvenido a Aron.</h1>
            <p style="color:white;" id="hola">Una herramienta efectiva para el control de las nóminas de tu empresa.</p>
            <br />
            <a class="primario1 oculto" href="#" role="button"><i class="fas fa-bolt icon-left"></i>¿Como funciona?</a>
        </div>
    </div>

<!-- -----------------------------------modal de sesion-------------------------------- -->

<div class="modal fade" id="login" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true" >
  <div class="modal-dialog" role="document">
    <div class="modal-content" style="background-color: rgba(255,255,255,1)!important;">
      <div class="modal-header">
        <h3 class="modal-title" id="exampleModalLabel">Iniciar Sesión</h3>
        
      </div>
      <div class="modal-body">
        <form method="POST" action="{{ route('login') }}">
                        {{ csrf_field() }}

                        <div class="form-group row">
                            <label for="email" class="col-md-4 col-form-label text-md-right" style="padding-top: 5px;">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; Correo Electrónico</label>

                            <div class="col-md-6">
                                <input id="email" type="email" class="form-control{{ $errors->has('email') ? ' is-invalid' : '' }}" name="email" value="{{ old('email') }}" required autofocus>

                                @if ($errors->has('email'))
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $errors->first('email') }}</strong>
                                    </span>
                                @endif
                            </div>
                        </div>

                        <div class="form-group row">
                            <label for="password" class="col-md-4 col-form-label text-md-right" style="padding-top: 5px;">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Contraseña</label>

                            <div class="col-md-6">
                                <input id="password" type="password" class="form-control{{ $errors->has('password') ? ' is-invalid' : '' }}" name="password" required>

                                @if ($errors->has('password'))
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $errors->first('password') }}</strong>
                                    </span>
                                @endif
                            </div>
                        </div>


                        <div class="form-group row mb-0" style=" padding-left: 225px;">
                            <div class="col-md-8 offset-md-4">
                                <button type="submit" class="btn btn-primary">
                                    {{ __('Ingresar') }}
                                </button>

                            </div>
                        </div>
                    </form>
      </div>
      <div class="modal-footer">
      	<h5 style="float: left; color: red;">Nunca le des tu contraseña a nadie!</h5>
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
        
      </div>
    </div>
  </div>
</div>
    @include('includes.footer');
</div>
@endsection

