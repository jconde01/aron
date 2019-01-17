@extends('layouts.app')
 
@section('title','Listado de Graficas')
@section('body-class','')

@section('content')
<div class="main main-raised" style="margin-left: 225px;">
    <div class="container" style=" width: 100%;">
        <div class="section text-center" style=" width: 100%;">
            <h2 class="titulo">CheckList</h2>
            <div class="row" style=" width: 100%;">
                <!-- <a href="{{ url('/admin/celulas/create')}}" class="btn btn-primary btn-round" role="button">Nueva Célula</a> -->
                
                <div style="border: 1px red solid; width: 18%; float: left;">
                     <p>Lista de Checklist :</p>

                      <p>

                        <select name="enviar mensaje" size="20" id="lista" style="width: 100%;">

                        @foreach ($clientes as $cliente)
                            @foreach ($lists as $list)
                                @if($cliente->fiscal_bda==$list->CIA || $cliente->asimilado_bda==$list->CIA) 
                                    <option value="{{$list->id}}">{{$cliente->Nombre}} </option>
                                @endif
                       
                            @endforeach
                       @endforeach

                        </select>

                      </p>

                </div>


                <div style="border: 1px blue solid; width: 82%; float: right;">
                    <form method="post" action="{{ url('/consultas/checklist/actualizar') }}">
                            <input type="hidden" name="_token" value="{{ csrf_token() }}">
                            <input type="hidden" name="id" value="" id="id">
                            <label>CIA</label>
                            <input type="" name="CIA" placeholder="CIA" id="CIA">
                            <label>TIPONO</label>
                            <input type="" name="TIPONO" placeholder="TIPONO" id="TIPONO"><br><br>

                            <?php $cont=1; ?>
                            @foreach ($checks as $check)
                                <div style=" width: 480px; text-align: left; display: flex; display: inline-block; ">
                                    <!-- {{ $check == 1? 'CHECKED':'' }} -->
                                    <!-- <input type="hidden" name="CHECK[]" value="False"> -->
                                    <input type="checkbox" name="CHECK[]" id="{{ $cont }}"  value="{{ $cont }}" class="box">&nbsp;
                                    <label rel="tooltip" name="NOMBRE[]" title=""> {{$check}} &nbsp;</label>
                                    <input type="text" name="FECHA[]" id="<?php echo 'fecha'.$cont++;  ?>" style="width: 160px; height: 22px; border:0px;">
                                    <!-- <label id="<?php echo 'fecha'.$cont;  ?>" >&nbsp;S/F &nbsp;&nbsp;&nbsp;&nbsp;</label>&nbsp; -->
                                </div>
                            @endforeach
                           
                        <div class="row text-center">
                            <br><br><br><br>
                            <button class="primario separation">Actualizar</button>
                            <a href="{{ url('/home') }}" class="primario1">Cancelar</a>
                        </div>

                    </form>
                </div>


                
            </div>
        </div>
        
    </div>
</div>
@include('includes.footer')
@endsection
@section('jscript')
<script type="text/javascript">
    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
    }); 
    $(document).ready(function() {
        var token = $('input[name=_token]').val();      
        console.log('here we are. The token is: ' + token);
    });


    $('#lista').change(function() {

        var token = $('input[name=_token]').val();              
        var id  =  $('#lista').val();
        var cia = document.getElementById("CIA");
        var idselec = document.getElementById("id");
        var tipono = document.getElementById("TIPONO");
        //alert('El id es: '+ id);
        $("body").css("cursor", "wait");
        $.post("/consultas/checklist", { fldid: id, _token: token }, function( data ) {
            $("body").css("cursor", "default");
            var datos = Object.values(data);
            //alert(datos);
           idselec.value=datos[0];
           cia.value=datos[1];
           tipono.value=datos[2];
           //alert(data);
            for (var i = 3; i < datos.length; i++) {
                var b = i+39;
                var idx = i - 2;
               if (datos[i]==1) {
                    document.getElementById(idx).checked = true;
                    //document.getElementById(idx).readOnly = true;
                    document.getElementById(idx).disabled = true;
                    document.getElementById('fecha'+idx).value = datos[b];
                }else{
                    document.getElementById(idx).checked = false;
                    //document.getElementById(idx).readOnly = true;
                    document.getElementById(idx).disabled = false;
                    document.getElementById("fecha"+idx).value = "S/F";
                }               
            }
           
        });     
    });


    $('.box').change(function() {
        
        //var porClassName=document.getElementsByClassName(".box");
        //var elemento = Object.values(porClassName);
        //alert(elemento);
        //alert('El id es: '+ id);
        //var values = $("input[name='CHECK[]']").map(function(){return $(this).val();}).get();
        //var indice =  $("input[name='CHECK[]']").value;
        var valor = $(this).val();
        var indice = $(this).attr('id');
        //alert('indice: ' + indice + ' - ' + 'valor: ' + valor); 
        var f=new Date();
        fecha=f.getDay()+"-"+f.getMonth()+"-"+f.getFullYear()+" "+f.getHours()+":"+f.getMinutes(); 
        document.getElementById('fecha'+indice).value = fecha; //date(2018,9,21);
        //alert(document.getElementById('fecha'+indice).value);
  
    });
</script> 
@endsection
