<!-- <div class="container"> -->
<div class="row" style="margin-bottom: 0px;">
  <div class="col-md-12" style="margin-bottom: 0px; margin: auto!important; padding: 0px;">
    <!-- nav class="navbar navbar-transparent navbar-default" style="margin-top: 10px; margin: auto; margin-bottom: 10px;" -->
    <nav class="navbar navbar-expand navbar-dark flex-column flex-md-row bd-navbar" style="margin-top: 10px; margin: auto; margin-bottom: 10px;  border-radius: 0px!important; width: 100%!important; ">  
      <div class="container" id="cabecera" style="width: 84%;">
          <div class="navbar-header" id="tipomovil" >
                <button type="button" class="navbar-toggle"  data-toggle="collapse" data-target="#navigation-main" style="color: black!important;">
                  <i class="fas fa-bars" style="font-size: 35px;"></i>
              </button>
              <!-- <a class="navbar-brand" href="{{ url('/home') }}"><img src="{{ asset('img/Aron-pegado2.png') }}" style="width:127px;height:30px;"></a> -->
          </div>

          <div class="collapse navbar-collapse border navvar cabecera" id="navigation-main" >            
              <ul class="nav navbar-nav navbar-right border">
                  @guest
                      <li><a class="nav-link" href=""data-toggle="modal" data-target="#login">{{ __('Ingresar') }}</a></li>
                  @else
                      <li style="border-right: 1px rgb(179, 215, 243) solid;"  rel="tooltip" title="Notificaciones">
                        <a href="{{ url('/notificaciones') }}">
                          <i class="fas fa-bell" style="font-size: 27px;"></i> 
                          @if ($count = Auth::user()->unreadnotifications()->count())
                            <span class="badge" style="margin-top: -30px;">{{ $count }}</span>
                          @endif
                        </a>
                      </li>

                      <li class="dropdown lis" style="border-right: 1px rgb(179, 215, 243) solid;" rel="tooltip" title="Perfil">
                          <a id="navbarDropdown" class="nav-link dropdown-toggle" href="{{ url('/sistema/usuarios/'.Auth::user()->id.'/edit') }}" role="button" aria-haspopup="true" aria-expanded="false" v-pre style="width: 170px; padding-top: 7px; height: 58px;">
                            
                            <?php 
                            if (Auth::user()->imagen==null) {
                              echo '<i class="fas fa-user-circle" style="font-size: 27px;"></i>'; 
                            }else{
                                echo '<img src="/img_emp/'.Auth::user()->imagen.'" style="width: 45px; height: 45px; border-radius:25px;">';
                            }
                            
                            ?>
                            {{ Auth::user()->name }}  
                          </a>  
                      </li>


                        <li class="dropdown lis" style="border-right: 1px rgb(179, 215, 243) solid;" rel="tooltip" title="Preferencias">
                            <a id="navbarDropdown" class="nav-link dropdown-toggle" href="#" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" v-pre style="width: 90px;">
                              <i class="fas fa-cogs" style="font-size: 27px;"></i>
                              <span class="caret"></span>
                            </a>

                            <div class="dropdown-menu" aria-labelledby="navbarDropdown" style="">
                              <div style="text-align: center;">
                                 @if (auth()->user()->profile_id == env('APP_ADMIN_PROFILE'))
                                    <a style="text-decoration: none;  padding: 7px 50px !important;" href="{{ url('/admin/clientes') }}">Clientes</a>
                                    <a style="text-decoration: none; padding: 7px 43px !important;" href="{{ url('/admin/empresas') }}">Empresas</a>
                                    <a style="text-decoration: none; padding: 7px 53px !important;" href="{{ url('/admin/celulas') }}">Células</a>
                                    <a style="text-decoration: none; padding: 7px 47px !important;" href="{{ url('/admin/usuarios') }}">Usuarios</a>
                                    <a style="text-decoration: none; padding: 7px 52px !important;" href="{{ url('/admin/perfiles') }}">Perfiles</a>
                                    <a style="text-decoration: none; padding: 7px 59px !important;" href="{{ url('/admin/options') }}">Menú</a> <br>
                                    <a style="text-decoration: none; padding: 7px 60px !important;" href="{{ url('/admin/giros') }}">{{ __('Giros') }}</a><br>
                                  @endif

                                  @if (auth()->user()->profile_id != env('APP_ADMIN_PROFILE'))
                                    <a style="text-decoration: none; padding: 7px 50px !important;" href="{{ url('/sistema/graficas') }}">Graficas</a><br>
                                  @endif
                              </div>
                                <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                                    {{ csrf_field() }}
                                </form>
                            </div>
                        </li>

                        <li class="dropdown" rel="tooltip" title="Cerrar Sesión">
                          <a style="text-decoration: none;  " href="{{ route('logout') }}" onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
                          <i class="fas fa-power-off" style="font-size: 27px;"></i>
                          </a>
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

    <?php $cli = session('selCliente'); $proc = session('selProceso'); $nomina = session('tinom');?> 
    <!-- <?php $conn2 = \Config::get('database.connections.sqlsrv2'); ?> -->
    @if ($cli)
      @if ($proc)
        <span><p class="etiqueta" style="background-color: rgb(179, 215, 243); color: blue; height: 26px !important; float: right;font-size: 12px;">{{ session('clienteYProceso') }}</p></span>
        <!-- <span><p class="etiqueta" style="background-color: rgb(179, 215, 243); color: blue; height: 22px !important; float: right; font-size: 8px;">{{ $conn2["host"] . ' - ' . $conn2["database"] }}</p></span>  -->
      @else
        <span><p class="etiqueta" style="background-color: rgb(179, 215, 243); color: blue; height: 22px !important; float: right;font-size: 8px;">{{ $cli->Nombre }}</p></span>   
      @endif
      <span><p class="etiqueta" style="background-color: rgb(179, 215, 243); color: blue; height: 26px !important; float: right;font-size: 12px;">Tipo de nómina: {{ $nomina }}</p></span>
    @endif
    @if (session()->has('flash'))
      <div class="container">
        <div class="alert alert-success">{{ session('flash') }}</div>
      </div>
    @endif
     @if (session()->has('warning'))
      <div class="container">
        <div class="alert alert-warning">{{ session('warning') }}</div>
      </div>
    @endif
     @if (session()->has('danger'))
      <div class="container">
        <div class="alert alert-danger">{{ session('danger') }}</div>
      </div>
    @endif
  </div>
</div>
