<!-- Navbar -->
<?php
$permiso_panel = 'p_ver_panel';
$usuarios_panel = 'true';
?>
<nav class="navbar px-navbar">

  <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#px-navbar-collapse" aria-expanded="false"><i class="navbar-toggle-icon"></i></button>

  <div class="collapse navbar-collapse" id="px-navbar-collapse">
    <ul class="nav navbar-nav inputForm">
      <li>
        <input type="text" placeholder="Buscador de Proyecto">
      </li>
    </ul>
    <ul class="nav navbar-nav navbar-right">
      <li>
        <a id="user" href="#"> <!-- <i class="bg" style="background-image: url('img/profile.jpeg');"></i> --> 
          <b>user name</b></a> <!-- {{ '$usuario->datosusuario->nombre' }} -->
      </li>

      <li class="dropdown">
        <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false">
          <i class="icon ion-ios-gear m-r-1"></i>
        </a>
        <ul class="dropdown-menu">
          @if($usuarios_panel) 
              <li><a  href="listusuarios.php" class="menupopover">Agregar Usuarios</a></li>
              <li><a  href="formPermisos.php" class="menupopover">Asignar Permisos</a></li>
          @endif  
        </ul>
      </li>
      <li>
        <a href="#" onClick="cerrarsesion($idusuario)"><i class="icon ion-power"></i></a>
      </li>
    </ul>
  </div>
</nav>
