@extends('layouts.app')
@section('title', 'Listado de Empleados')
@section('body-class', 'profile-page')
@section('content') 
  <div class="main main-raised"> 
    <div class="container">   
      <div class="section text-center">
        <h3 class="titulo">Listado de Empleados</h3>
        <div style="width: 200px;height: 40px; float: left;"><span>Empleados Activos: {{$emps_activos}}</span><br><span>A la Fecha: <?php $fecha = getdate(); print_r($fecha['mday'].'/'.$fecha['mon'].'/'.$fecha['year']); ?> </span></div>
        <a href=" {{url('catalogos/empleados/create')}} " class="primario1" style="width: 160px; margin-left: -200px;"><i class="fas fas fa-plus-square icon-left"></i> &nbsp;Agregar Empleado</a>
        <br> <br>
        <input type="hidden" name="_token" value="{{ csrf_token() }}">
            <table id="table_id" class="display"> 
                    <thead>                           
                        <tr>
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
                        <tr class="pruebacolor">
                            <td class="parrafo columna1">{{$emp->EMP}}</td>
                            <td class="parrafo columna2" ><a href=""data-toggle="modal" data-target="#GSCCModal2" id="{{$emp->EMP}}" rel="tooltip" title="Consulta rapida" name="nom">{{$emp->NOMBRE}} <input type="hidden" name="{{$emp->EMP}}" value="{{$emp->EMP}}"> </a></td>
                            <td class="parrafo columna3"> @foreach ($jobs as $job)
                                <?php if ($emp->PUESTO==$job->PUESTO) {
                                    echo "$job->NOMBRE";
                                } ?>
                             @endforeach</td>
                            <td class="parrafo columna4">@foreach ($deps as $dep)
                                <?php if ($emp->DEPTO==$dep->DEPTO) {
                                    echo "$dep->DESCRIP";
                                } ?>
                             @endforeach</td>
                            <td class="parrafo columna5">{{$emp->c_Estado}}</td>
                            
                          
                            <td class="parrafo columna6"><?php 
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
                                                 
                            <td class="parrafo columna7">
                              <a href="{{url('/catalogos/empleados/'.$emp->EMP.'/edit')}}" rel="tooltip" title="Editar" class="btn btn-success btn-simple btn-xs">
                                <i class="fa fa-edit"></i>
                              </a>
                              <a href="{{url('/catalogos/empleados/'.$emp->EMP.'/documentos')}}" rel="tooltip" title="Documentos" class="btn btn-warning btn-simple btn-xs">
                                <i class="fa fa-file"></i>
                              </a>
                            </td>             
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
                                  <div class="modal-body" style=" width: 1000px; text-align: center; height: 290px;" >
                                    <div style="float: left;">
                                    <img src="" id="ima" style="width: 210px; border-radius: 5px; border: 1px rgb(179, 215, 243) solid;">
                                   </div>
                                        
                                      <div style="float: right; width: 70%;">
                                       
                                            <div class="" style="border-bottom: 1px rgb(179, 215, 243) solid; margin-bottom: 7px;">
                                                <span>Nombre: &nbsp;&nbsp;</span>
                                                <input type="text" name="NOMBRES" style="width: 350px; border: 0px;" value="" id="numbre" readonly>
                                            </div> 
                                       
                                        
                                            <div class="" style="border-bottom: 1px rgb(179, 215, 243) solid; margin-bottom: 7px;">
                                                <span>Puesto:&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</span>        
                                                <input type="text" name="MATERNO" style="width: 350px; border: 0px;" id="pue" value="" readonly>
                                            </div> 
                                       
                                        
                                            <div class="" style="border-bottom: 1px rgb(179, 215, 243) solid; margin-bottom: 7px;">
                                                <span>Localidad:&nbsp; &nbsp;</span>    
                                                <input type="text" name="MATERNO" style="width: 350px; border: 0px;margin-right: 10px;" id="loca" value="" readonly>
                                            </div> 
                                        
                                        
                                            <div class="" style="border-bottom: 1px rgb(179, 215, 243) solid; margin-bottom: 7px;">
                                                <span> Departamento:&nbsp;&nbsp;</span>
                                                <input type="text" name="MATERNO" style="width: 350px; border: 0px; margin-right: 40px; margin-left: 5px;" id="depa" value="" readonly>
                                            </div> 
                                        
                                        
                                            <div class="" style="border-bottom: 1px rgb(179, 215, 243) solid; margin-bottom: 7px;">
                                                <span> Teléfono: &nbsp;&nbsp;</span>    
                                                <input type="text" name="MATERNO" style="width: 350px; border: 0px;" id="tele" value="" readonly>
                                            </div> 
                                            
                                            <div class="" style="border-bottom: 1px rgb(179, 215, 243) solid; margin-bottom: 7px;">
                                                <span> Tipo Sangre:&nbsp;&nbsp;</span>    
                                                <input type="text" name="MATERNO" style="width: 350px; border: 0px; margin-right: 20px;" id="san" value="" readonly>
                                            </div> 

                                            <div class="" style="border-bottom: 1px rgb(179, 215, 243) solid; margin-bottom: 7px;">
                                                <span style="margin-left: 25px;">Imss:&nbsp;&nbsp;&nbsp;</span>        
                                                <input type="text" name="MATERNO" style="width: 350px; border: 0px;" id="imss" value="" readonly>
                                            </div> 

                                            <div class="" style="border-bottom: 1px rgb(179, 215, 243) solid; margin-bottom: 7px;">
                                                <span style="margin-left: -77px;">Fecha de Nacimiento:&nbsp;&nbsp;&nbsp;</span>        
                                                <input type="date" name="MATERNO" style="width: 350px; border: 0px;" id="naci" value="" readonly>
                                            </div>

                                            <div class="" style="border-bottom: 1px rgb(179, 215, 243) solid; margin-bottom: 7px;">
                                                <span style="margin-left: -83px;">Sueldo Bruto Mensual:&nbsp;&nbsp;&nbsp;</span>        
                                                <input type="text" name="MATERNO" style="width: 350px; border: 0px;" id="sueldo" value="" readonly>
                                            </div>


                                        </div>
                                        
                                        

                                  </div>
                                  <div class="modal-footer">
                                <button type="button" class="btn btn-default" data-dismiss="modal" onclick="limpiar_inputs()">Aceptar</button>     
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
        var sangre = document.getElementById("san"); 
        var imss = document.getElementById("imss");
        var naci = document.getElementById("naci");
        var sueldo = document.getElementById("sueldo");       
        //alert('Empleado: ' + id);        
        $.post("empleados/getDatosEmpleado", {fldide: id, _token: token}, function( data ) {
            
            numbre.value = data['nombre'];
            pue.value = data['puesto'];
            depa.value = data['depto'];
            loca.value = data['localidad'];
            tele.value = data['telefono'];
            sangre.value = data['sangre'];
            imss.value = data['imss'];
            primera = data['naci'].split(' ')[0];
            sueldo.value = '$'+data['sueldo'];

            naci.value = primera;
            var foto = data['foto'];
            var img = '/img_emp/'+foto;
            if (data['foto']) {
              $('#ima').removeAttr('scr');
              $('#ima').attr('src',img);
            }else{
              $('#ima').removeAttr('scr');
              $('#ima').attr('src',"{{ asset('/img/Ideatisa.ico')}}");
            }

            if (data['curriculum']) {
              $('#curri').removeAttr('href');
              $('#curri').attr('href',curri);
            }else{
              $('#curri').removeAttr('href');
              $('#curri').attr('href',"#");
            }

        });        
            
    });

      function limpiar_inputs(){
        document.getElementById("numbre").value = " "; 
        document.getElementById("pue").value = " ";
        document.getElementById("depa").value = " ";
        document.getElementById("loca").value = " ";
        document.getElementById("tele").value = " ";
        document.getElementById("ima").value = " ";
        document.getElementById("san").value = " "; 
        document.getElementById("imss").value = " ";
        document.getElementById("naci").value = " ";
        document.getElementById("sueldo").value = " ";
        $('#ima').removeAttr('scr');
        $('#ima').attr('src',"{{ asset('/img/Ideatisa.ico')}}"); 
      }
      
  </script>
  @endforeach
@endsection
