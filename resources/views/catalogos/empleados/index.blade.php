@extends('layouts.app')
@section('title', 'Listado de departamentos')
@section('body-class', 'profile-page')
@section('content') 
  <div class="main main-raised"> 
    <div class="container">   
      <div class="section text-center">
        <h2 class="titulo">Listado de Empleados</h2>
        <a href=" {{url('catalogos/empleados/create')}} " class="primario1 separation" style="width: 160px;"><i class="fas fas fa-plus-square icon-left"></i> &nbsp;Agregar Empleado</a>
        <br> <br>
        <input type="hidden" name="_token" value="{{ csrf_token() }}">
            <table id="table_id" class="display"> 
                    <thead>                           
                        <tr>
                            <th class="parrafo">Tipo de Nomina</th>
                            <th class="parrafo">Empleado</th>
                            <th class="parrafo">Nombre</th>
                            <th class="parrafo">Puesto</th>
                            <th class="parrafo">Departamento</th>
                            <th class="parrafo">Estado</th>
                            
                            
                            <th class="parrafo">Estatus</th>
                            
                            <th class="parrafo">Acciones</th>
                        </tr>  
                    </thead>                   
                        
                    <tbody>@foreach ($emps as $emp)
                        <tr>
                            <td class="parrafo">{{$emp->TIPONO}}</td>
                            <td class="parrafo">{{$emp->EMP}}</td>
                            <!-- <td class="parrafo" > <input type="" name="" id="nombre" value="{{$emp->NOMBRE}}" readonly style="border: 0px;" href=""data-toggle="modal" data-target="#GSCCModal"> <a></a></td> -->
                            <td class="parrafo" ><a href=""data-toggle="modal" data-target="#GSCCModal" id="{{$emp->EMP}}" name="nom">{{$emp->NOMBRE}} <input type="hidden" name="{{$emp->EMP}}" value="{{$emp->EMP}}"> </a></td>
                            <td class="parrafo"> @foreach ($jobs as $job)
                                <?php if ($emp->PUESTO==$job->PUESTO) {
                                    echo "$job->NOMBRE";
                                } ?>
                             @endforeach</td>
                            <td class="parrafo">@foreach ($deps as $dep)
                                <?php if ($emp->DEPTO==$dep->DEPTO) {
                                    echo "$dep->DESCRIP";
                                } ?>
                             @endforeach</td>
                            <td class="parrafo">{{$emp->c_Estado}}</td>
                            
                          
                            <td class="parrafo"><?php 
                            if ($emp->ESTATUS=='A') {
                                echo "Activa";
                            }
                            if ($emp->ESTATUS=='B') {
                                echo "Baja";
                            }
                            if ($emp->ESTATUS=='M') {
                                echo "Vacaciones";
                            }
                            ?></td>
                                                 
                            <td class="parrafo"><a href="{{url('/catalogos/empleados/'.$emp->EMP.'/edit')}}" rel="tooltip" title="Editar" class="btn btn-success btn-simple btn-xs"><i class="fa fa-edit"></i></a></td>             
                        </tr>  @endforeach 
                    </tbody>
                             
                    </table>

                     <div style="" id="GSCCModal" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
                             <div class="modal-dialog">
                                <div class="modal-content">
                                  <div class="modal-header">                                 
                                    <h4 class="modal-title" id="myModalLabel">Datos</h4>
                                  </div>
                                  <div class="modal-body" style="text-align: center;">
                                    <a href="" data-toggle="modal" data-target="#GSCCModal2"><i class="fas fa-address-card"></i>&nbsp;Datos Generales</a>
                                    &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp;
                                    <a href="/files/formato.pdf"><i class="fas fa-book"></i>&nbsp;Curriculum</a>
                                  </div>
                                  <div class="modal-footer">
                                    <button type="button" class="btn btn-default" data-dismiss="modal">Aceptar</button>                  
                                  </div>
                                </div>
                              </div>
                            </div>

                            <div style="" id="GSCCModal2" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true" style="width: 1200px!important;">
                             <div class="modal-dialog" style="margin-right: 400px;">
                                <div class="modal-content" style=" width: 1000px;">
                                  <div class="modal-header">
                                    <h4 class="modal-title" id="myModalLabel">Datos del empleado</h4>
                                  </div>
                                  <div class="modal-body" style=" width: 1000px; text-align: center;" >

                                    <img src="" id="ima" style="width: 210px; border-radius: 5px;">
                                    <br><br><br>
                                        <div class="col-md-1 no-pad" >
                                            <div class="" style="margin-bottom: 2em;">
                                                
                                               
                                            </div> 
                                        </div>

                                       <div class="col-md-6 no-pad">
                                            <div class="content-descripcion-left-input" style="margin-bottom: 2em;">
                                                <div class="label-left"><p>Nombre: </p></div>
                                                <input type="text" name="NOMBRES" value="" id="numbre" readonly>
                                            </div> 
                                        </div>

                                        

                                        <div class="col-md-4 no-pad">
                                            <div class="content-descripcion-left-input" style="margin-bottom: 2em;">
                                                <div class="label-left"><p>Puesto: </p></div>
                                                <input type="text" name="MATERNO" id="pue" value="" readonly>
                                            </div> 
                                        </div>
                                        <div class="col-md-4 no-pad">
                                            <div class="content-descripcion-left-input" style="margin-bottom: 2em;">
                                                <div class="label-left"><p>Localidad: </p></div>
                                                <input type="text" name="MATERNO" id="loca" value="" readonly>
                                            </div> 
                                        </div>
                                        <div class="col-md-4 no-pad">
                                            <div class="content-descripcion-left-input" style="margin-bottom: 2em;">
                                                <div class="label-left"><p>Departamento: </p></div>
                                                <input type="text" name="MATERNO" id="depa" value="" readonly>
                                            </div> 
                                        </div>
                                        <div class="col-md-4 no-pad">
                                            <div class="content-descripcion-left-input" style="margin-bottom: 2em;">
                                                <div class="label-left"><p>Teléfono: </p></div>
                                                <input type="text" name="MATERNO" id="tele" value="" readonly>
                                            </div> 
                                        </div>
                                        <br><br><br><br><br><br>
                                        

                                  </div>
                                  <div class="modal-footer">
                                <button type="button" class="btn btn-default" data-dismiss="modal">Aceptar</button>     
                                  </div>
                                </div>
                              </div>
                             
         
                        </div>
                             
         
      </div>
    </div>
  </div>
  <div style="height: 15px;"></div>
  @include('includes.footer')
  @foreach ($emps as $emp)
  <script type="text/javascript">
    $.ajaxSetup({
    headers: {
        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
});  

 
      $('#{{$emp->EMP}}').click(function() {
        var token = $('input[name=_token]').val();              
        var id = $('input[name={{$emp->EMP}}]').val();              
        var numbre = document.getElementById("numbre"); 
        var pue = document.getElementById("pue");
        var depa = document.getElementById("depa");
        var loca = document.getElementById("loca");
        var tele = document.getElementById("tele");
        var ima = document.getElementById("ima");    
        //alert('Empleado: ' + id);        
        $.post("empleados/getDatosEmpleado", {fldide: id, _token: token}, function( data ) {
            
            numbre.value = data['nombre'];
            pue.value = data['puesto'];
            depa.value = data['depto'];
            loca.value = data['localidad'];
            tele.value = data['telefono'];
            var foto = data['foto'];
            var img = '/admon/empleados/empresas/'+id+'/'+foto;
            if (data['foto']) {
             $('#ima').removeAttr('scr');
            $('#ima').attr('src',img);
        }else{
             $('#ima').removeAttr('scr');
             $('#ima').attr('src',"{{ asset('/img/Ideatisa.ico')}}");
        }
            //iv.value = data['integrado2'];
            //alert('regreso con: ' + data['puesto']);
        });
        // $('#ima').removeAttr('scr');
        // $('#ima').attr('src',"{{ asset ('/img/avatar.jpg')}}"); 
            
    });
  </script>
  @endforeach
@endsection
