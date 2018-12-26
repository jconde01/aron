@extends('layouts.app')

@section('title','Editar usuario')
@section('body-class','')

@section('content')
<!-- <div class="header header-filter" style="background-image: url('{{ asset('img/cdmx.jpg') }}');">
</div> -->
<style>
    .thumb {
            height: 200px;
            width:  200px;
            border: 1px solid #000;                        
            }
    .switch {
      position: relative;
      display: inline-block;
      width: 60px;
      height: 34px;
    }

    .switch input { 
      opacity: 0;
      width: 0;
      height: 0;
    }

    .slider {
      position: absolute;
      cursor: pointer;
      top: 0;
      left: 0;
      right: 0;
      bottom: 0;
      background-color: #ccc;
      -webkit-transition: .4s;
      transition: .4s;
    }

    .slider:before {
      position: absolute;
      content: "";
      height: 26px;
      width: 26px;
      left: 4px;
      bottom: 4px;
      background-color: white;
      -webkit-transition: .4s;
      transition: .4s;
    }

    input:checked + .slider {
      background-color: #2196F3;
    }

    input:focus + .slider {
      box-shadow: 0 0 1px #2196F3;
    }

    input:checked + .slider:before {
      -webkit-transform: translateX(26px);
      -ms-transform: translateX(26px);
      transform: translateX(26px);
    }

    /* Rounded sliders */
    .slider.round {
      border-radius: 34px;
    }

    .slider.round:before {
      border-radius: 50%;
    }

    /*-------------------------------------------*/
    /* Estilo del área del input[file] */
        .drag-drop {
            height: 5em;
            width: 5em;
            background-color: #ccc;
            border-radius: 4em;
            text-align: center;
            color: white;
            position: relative;
            margin: 0 auto 1em;
        }

        .drag-drop span.desc {
            display: block;
            font-size: .7em;
            padding: 0 .5em;
            color: #000;
        }

        input[type="file"] {
                height: 10em;
                opacity: 0;
                position: absolute;
                top: 0;
                left: 0;
                width: 100%; 
                z-index: 3;
        }

        /* Estilo del área del input[file] con :hover */

        .drag-drop:hover, input[type="file"]:hover {
            background-color: #3276b1;
            cursor: pointer;
        }

        .drag-drop:hover span.desc {
            color: #fff;
        } 

        .drag-drop:hover .pulsating {
            animation: pulse1 1s linear infinite;
            animation-direction: alternate ;
            -webkit-animation: pulse1 1s linear infinite;
            -webkit-animation-direction: alternate ;
        }

        /* Composición del icono de Upload con FontAwesome */
        .fa-stack { margin-top: .5em; }

        .fa-stack .top { color: white; }

        .fa-stack .medium { 
            color: black;
            text-shadow: 0 0 .25em #666;
        }

        .fa-stack .bottom { color: rgba(225, 225, 225, .75); }

        /* Keyframing de la animación */

        @keyframes pulse1 {
         0% { color: rgba(225, 225, 225, .75); }
         50% { color: rgba(225, 225, 225, 0.25); }
         100% { color: rgba(225, 225, 225, .75); }
        }

        @-moz-keyframes pulse1 {
         0% { color: rgba(225, 225, 225, .75); }
         50% { color: rgba(225, 225, 225, 0.25); }
         100% { color: rgba(225, 225, 225, .75); }
        }

        @-webkit-keyframes pulse1 {
         0% { color: rgba(225, 225, 225, .75); }
         50% { color: rgba(225, 225, 225, 0.25); }
         100% { color: rgba(225, 225, 225, .75); }
        }

        @-ms-keyframes pulse1 {
         0% { color: rgba(225, 225, 225, .75); }
</style>
<div class="main main-raised">
    <div class="container">
        <div class="section">
            <h2 class="titulo text-center">Editar usuario</h2>
            @if ($errors->any())
                <div class="alert alert-danger">
                    <ul>
                        @foreach($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>                    
                </div>
            @endif
            <form method="post" action="{{ url('/sistema/usuarios/'.$user->id.'/edit') }}" enctype="multipart/form-data">
                {{ csrf_field() }}
                <div class="col-md-4 col-md-offset-4" style="border: 3px rgb(179, 215, 243) solid; border-radius: 5px; text-align: center;">
                        <h4>Imagen de Perfil </h4>
                        <output id="list" >
                            <?php 
                            if ($user->imagen==null) {
                              echo '<img src="/img/perfil.png" style="width: 200px; height: 200px;">'; 
                            }else{
                                echo '<img src="/img_emp/'.$user->imagen.'" style="width: 200px; height: 200px;">';
                            }
                            
                            ?>
                            
                        </output>
                        <br><br>
                        <div class="drag-drop">
                            <input type="file" id="files" name="archivo"/>
                            <span class="fa-stack fa-1x">
                                <i class="fa fa-cloud fa-stack-2x bottom pulsating"></i>
                                <i class="fa fa-circle fa-stack-1x top medium"></i>
                                <i class="fa fa-arrow-circle-up fa-stack-1x top"></i>
                            </span>
                            <span class="desc">Añadir imagen</span>
                        </div>
                        <br>  
                        
                </div><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br>

                <div class="row">
                    <div class="col-sm-1">
                        <label class="switch">
                      <input type="checkbox"id="toggle-event-name">
                      <span class="slider"></span>
                    </label>
                    </div>

                    <div class="col-sm-11">
                        <div class="form-group content-descripcion-left-input" style="margin-bottom: 2em;">
                            <label class="label-left" style="font-size: 14px;">Nombre</label>
                            <input type="text" name="name" id="name" value="{{ old('name', $user->name) }}" disabled class="bloqueado">
                        </div>
                    </div>
                </div>

                <div class="row">
                    <div class="col-sm-1">
                        <label class="switch">
                            <input type="checkbox"id="toggle-event-pass">
                            <span class="slider"></span>
                        </label>
                    </div>

                    <div class="col-sm-5">                        
                        <div class="form-group content-descripcion-left-input" style="margin-bottom: 2em;">
                            <label class="label-left" style="font-size: 14px;">Contraseña</label>
                            <input id="password" type="password" name="password" value="{{ old('password',$user->password) }}" disabled class="bloqueado">
                        </div>                     
                    </div>

                    <div class="col-sm-1">
                        <label class="switch">
                          <input type="checkbox"id="toggle-event-email">
                          <span class="slider"></span>
                        </label>
                    </div>

                    <div class="col-sm-5">
                        <div class="form-group content-descripcion-left-input" style="margin-bottom: 2em;">
                            <label class="label-left" style="font-size: 14px;">Email</label>
                            <input type="email" name="email" id="email" value="{{ old('email',$user->email) }}" disabled class="bloqueado">
                        </div>
                    </div>
                </div>


                
                <!-- <div id="console-event"></div> -->
                
                <div class="row text-center">
                    <button class="primario separation">Guardar</button>
                    <a href="{{ url('/admin/usuarios') }}" class="primario1">Cancelar</a>
                </div>
            </form>

        </div>


    </div>
</div>

<script>
                  $(function() {
                    $('#toggle-event-name').change(function() {
                      // $('#console-event').html('Toggle: ' + $(this).prop('checked'))
                      document.getElementById("name").disabled = false;
                      document.getElementById("name").className = '';
                      if ($(this).prop('checked')==false) {
                        document.getElementById("name").disabled = true;
                        document.getElementById("name").className = 'bloqueado';
                      }
                    })
                  })

                  $(function() {
                    $('#toggle-event-pass').change(function() {
                      // $('#console-event').html('Toggle: ' + $(this).prop('checked'))
                      document.getElementById("password").disabled = false;
                      document.getElementById("password").className = '';
                      if ($(this).prop('checked')==false) {
                        document.getElementById("password").disabled = true;
                        document.getElementById("password").className = 'bloqueado';
                      }
                    })
                  })

                  $(function() {
                    $('#toggle-event-email').change(function() {
                      // $('#console-event').html('Toggle: ' + $(this).prop('checked'))
                      document.getElementById("email").disabled = false;
                      document.getElementById("email").className = '';
                      if ($(this).prop('checked')==false) {
                        document.getElementById("email").disabled = true;
                        document.getElementById("email").className = 'bloqueado';
                      }
                    })
                  })
</script>

<script>
              function archivo(evt) {
                  var files = evt.target.files; // FileList object
             
                  // Obtenemos la imagen del campo "file".
                  for (var i = 0, f; f = files[i]; i++) {
                    //Solo admitimos imágenes.
                    if (!f.type.match('image.*')) {
                        continue;
                    }
             
                    var reader = new FileReader();
             
                    reader.onload = (function(theFile) {
                        return function(e) {
                          // Insertamos la imagen
                         document.getElementById("list").innerHTML = ['<img class="thumb" src="', e.target.result,'" title="', escape(theFile.name), '"/>'].join('');
                        };
                    })(f);
             
                    reader.readAsDataURL(f);
                  }
              }
             
              document.getElementById('files').addEventListener('change', archivo, false);

      </script>
@endsection