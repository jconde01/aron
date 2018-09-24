@extends('layouts.app')

@section('body-class','')

@section('content')
<div class="jumbotron" style=" max-width: 1100px; margin: auto; max-height: 550px;">
    <div class="container">
        <div class="row">
            <div class="col-md-4 col-md-offset-4 col-sm-6 col-sm-offset-3">
<!--            <div class="card card-signup">  -->
                <div class="fichas-simples secundario" style="">
                    <form class="form" method="POST" action="{{ route('login') }}">
                        {{ csrf_field() }}
                        <div class="articulo text-center">Inicio de sesión</div>
                        <br>
                        <!-- <p class="text-center" style="color:Azure; text-align: center;">Ingresa tus datos</p> -->
                        <div class="articulo text-center">Ingresa tus datos</div>
                        <div class="content">

<!--                             <div class="input-group">
                                <span class="input-group-addon">
                                    <i class="fas fa-thumbs-up">email</i>
                                </span>
                                <input id="email" type="email" placeholder="Correo electrónico..." class="form-control{{ $errors->has('email') ? ' is-invalid' : '' }}" name="email" value="{{ old('email') }}" required autofocus>
                            </div>
                            <div class="input-group">
                                <span class="input-group-addon">
                                    <i class="material-icons">lock_outline</i>
                                </span>
                                <input placeholder="Contraseña..." id="password" type="password" class="form-control{{ $errors->has('password') ? ' is-invalid' : '' }}" name="password" required>
                            </div> -->
                            <div class="contenido-input">
                                <input id="email" type="email" placeholder="Correo electrónico..." class="input der{{ $errors->has('email') ? ' is-invalid' : '' }}" name="email" value="{{ old('email') }}" required autofocus>
                                <i class="icon-izquierda far fa-user"></i>
                            </div> 
                            <br>
                            <br>
                            <div class="contenido-input">
                                <input id="password" type="password" placeholder="Contraseña..." class="input der{{ $errors->has('password') ? ' is-invalid' : '' }}" name="password" required autofocus>
                                <i class="icon-izquierda fa fa-unlock-alt"></i>
                            </div> 

<!--                             <div class="checkbox">
                                <label>
                                    <input type="checkbox" name="remember" {{ old('remember') ? 'checked' : '' }}>
                                    Recordar sesión
                                </label>
                            </div> -->
                            <br>
                            <br>
                            <div class="input-group">
                                <span class="">
                                    <input type="checkbox" aria-label="..." name="remember" {{ old('remember') ? 'checked' : '' }}>
                                </span>
                                <h5>Recordar sesión</h5>
                            </div>
                                                      
                        </div>
                        <div class="footer">
                            <button type="submit" class="primario">Ingresar</a>
                        </div>
                        <!--
                        <a class="btn btn-link" href="{{ route('password.request') }}">
                            {{ __('Forgot Your Password?') }}
                        </a> -->                        
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
<br><br>
 @include('includes.footer')
@endsection
