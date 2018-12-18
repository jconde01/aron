<!-- <div class="container"> -->
<div class="row" style="margin-bottom: 0px;">
  <div class="col-md-12" style="margin-bottom: 0px; margin: auto!important;">
    <!-- nav class="navbar navbar-transparent navbar-default" style="margin-top: 10px; margin: auto; margin-bottom: 10px;" -->
    <nav class="navbar navbar-expand navbar-dark flex-column flex-md-row bd-navbar" style="margin-top: 10px; margin: auto; margin-bottom: 10px;">  
      <div class="container" id="cabecera">
          <div class="navbar-header">
                <button type="button" class="navbar-toggle" data-toggle="collapse" data-target="#navigation-main">
                  <span class="sr-only">Toggle navigation</span>
                  <span class="icon-bar"></span>
                  <span class="icon-bar"></span>
                  <span class="icon-bar"></span>
              </button>
              <a class="navbar-brand" href="{{ url('/home') }}"><img src="{{ asset('img/Aron-pegado2.png') }}" style="width:127px;height:30px;"></a>
          </div>

          <div class="collapse navbar-collapse border navvar cabecera" id="navigation-main">            
              <ul class="nav navbar-nav navbar-right">
                  @guest
                      <li><a class="nav-link" href="{{ route('login') }}">{{ __('Ingresar') }}</a></li>
                     <!--  <li><a class="nav-link" href="{{ route('register') }}">{{ __('Registro') }}</a></li> -->
                  @else
                    <!-- <li><a href="{{ url('/messages/create') }}">Enviar mensaje</a></li> -->
                    <li>
                      <a href="{{ url('/notificaciones') }}">Notificaciones 
                        @if ($count = Auth::user()->unreadnotifications()->count())
                          <span class="badge">{{ $count }}</span>
                        @endif
                      </a>
                    </li>
                      <li class="dropdown" style="">
                          <a id="navbarDropdown" class="nav-link dropdown-toggle" href="#" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" v-pre style="width: 160px;">
                              {{ Auth::user()->name }} <span class="caret"></span>
                          </a>
                          <div class="dropdown-menu" aria-labelledby="navbarDropdown" style="">
                            <div style="text-align: center;">
                              @if (auth()->user()->profile_id == env('APP_ADMIN_PROFILE'))
                                  <a style="text-decoration: none;" href="{{ url('/admin/clientes') }}">Clientes</a>
                                  <a style="text-decoration: none;" href="{{ url('/admin/empresas') }}">Empresas</a>
                                  <a style="text-decoration: none;" href="{{ url('/admin/celulas') }}">Células</a>
                                  <a style="text-decoration: none;" href="{{ url('/admin/usuarios') }}">Usuarios</a>
                                  <a style="text-decoration: none;" href="{{ url('/admin/perfiles') }}">Perfiles</a>
                                  <!-- <a style="text-decoration: none;" href="{{ url('/admin/opciones/0') }}">Opciones</a> -->
                                  <a style="text-decoration: none;" href="{{ url('/admin/options') }}">Menú</a>
                                  <a style="text-decoration: none;" href="{{ url('/admin/giros') }}">{{ __('Giros') }}</a><br>
                              @endif
                              @if (auth()->user()->profile_id != env('APP_ADMIN_PROFILE'))
                                  <a style="text-decoration: none;" href="{{ url('/sistema/graficas') }}">Graficas</a><br>
                              @endif
                                  <a style="text-decoration: none;" href="{{ route('logout') }}" onclick="event.preventDefault();
                                               document.getElementById('logout-form').submit();">
                                  {{ __('Cerrar Sesión') }}</a>
                              </div>
                              <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                                  {{ csrf_field() }}
                              </form>
                          </div>
                      </li>
                  @endguest
              </ul>    
          </div>
        </div>
    </nav>

    @auth
      <!-- <ul class="nav navbar-nav"> -->
      @if (isset($navbar))
          <a class="toggle" style="left: 25px;">
            <span></span>
          </a>
        {!! $navbar !!}
      @endif          
      <!-- </ul> -->
    @endauth

    <?php $cli = session('selCliente'); $proc = session('selProceso'); ?> 
    <!-- <?php $conn2 = \Config::get('database.connections.sqlsrv2'); ?> -->
    @if ($cli)
      @if ($proc)
        <span><p class="etiqueta" style="background-color: rgb(179, 215, 243); color: blue; height: 22px !important; float: right;font-size: 8px;">{{ session('clienteYProceso') }}</p></span>
        <!-- <span><p class="etiqueta" style="background-color: rgb(179, 215, 243); color: blue; height: 22px !important; float: right; font-size: 8px;">{{ $conn2["host"] . ' - ' . $conn2["database"] }}</p></span>  -->
      @else
        <span><p class="etiqueta" style="background-color: rgb(179, 215, 243); color: blue; height: 22px !important; float: right;font-size: 8px;">{{ $cli->Nombre }}</p></span>   
      @endif
    @endif
      @if (session()->has('flash'))
        <div class="container">
          <div class="alert alert-success">{{ session('flash') }}
              <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
          </div>
        </div>
      @endif
      @if (session()->has('warning'))
          <div class="container">
            <div class="alert alert-warning">{{ session('warning') }}
              <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
            </div>
          </div>
      @endif      
      @if (session()->has('error'))
          <div class="container">
            <div class="alert alert-danger">{{ session('error') }}
              <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
            </div>
          </div>
      @endif
  </div>
</div>
