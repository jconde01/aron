@extends('layouts.app')

@section('title','Transacciones x Concepto')
@section('body-class','')

@section('content')
{!! Session::get("message", '') !!}
<div class="container" style="border:1px red solid;">
<!--     <div class="row"> -->
<!--         <div class="col-md-8 col-md-offset-2 col-sm-8 col-sm-offset-2" style="border:1px red solid;"> -->
            @if ($errors->any())
                <div class="alert alert-danger">
                    <ul>
                        @foreach($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>                    
                </div>
            @endif   
            <form class="form" method="POST" action="{{ url('transacciones/porConcepto') }}">
				<input type="hidden" name="_token" value="{{ csrf_token() }}">
				<input type="hidden" id="Metodo"  name="Metodo" value="">
				<input type="hidden" id="MetodoISP"  name="MetodoISP" value="">
                <!-- <p class="text-center" style="color:Azure; text-align: center;">Ingresa tus datos</p> -->
                <div class="row" style="margin-bottom: 0px;">
                    <div class="col-md-6">
                        <div class="form-group label-floating">
                            <label class="control-label">Concepto:</label>
                            <select class="form-control cpto" id="concepto" name="Concepto">
                                <option value="0" selected>Seleccione un concepto...</option>
                                @foreach ($conceptos as $cpto)
                                    <option value="{{ $cpto->CONCEPTO }}">{{ $cpto->CONCEPTO . ' - ' . $cpto->NOMBRE }}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>
	                <div class="col-md-6">
                        <div class="form-group label-floating">
                            <label class="control-label">Período:</label>
                            <select class="form-control pdo" id="periodo" name="Periodo">
                                <option value="0" selected>Seleccione el período...</option>
                                @foreach ($periodos as $pdo)
                                    <option value="{{ $pdo->PERIODO }}">{{ $pdo->PERIODO . ' - Inicia: ' . date('d-m-Y',strtotime($pdo->FECINI)) . ' - Finaliza: ' . date('d-m-Y',strtotime($pdo->FECFIN)) }}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                </div>
                <div class="row text-center">
                	<button type="button" class="btn btn-info btn-sm" id="btnNuevo">Agregar empleado</button>
                </div>
                <table class="row table" name="Movtos" id="captura">
                	<thead>                    	
                		<tr>
                			<th>Empleado</th>
                			<th>Nombre</th>
                			<th>Importe</th>
                		</tr>
                	</thead>
                </table>
                <div class="row text-center">
                    <button type="submit" class="primario">Guardar</button>
                </div>
            </form>
<!--         </div> -->
<!--     </div> -->
</div>
<!-- Modal -->
<div class="modal fade" id="nuevo" role="dialog">
    <div class="modal-dialog">
    
      <!-- Modal content-->
      <div class="modal-content">
        <div class="modal-header">
          <button type="button" class="close" data-dismiss="modal">&times;</button>
          <h4 class="modal-title">Seleccione Empleado y capture los datos</h4>
        </div>
        <div class="modal-body">
            <div class="form-group label-floating">
                <label class="control-label">Empleado:</label>
                <select class="form-control emp" id="empleado" name="Empleado">
                    <option value="0" selected>Seleccione un empleado...</option>
                    @foreach ($empleados as $emp)
                        <option value="{{ $emp->EMP }}" data-sueldo="{{ $emp->SUELDO }}" data-promed="{{ $emp->PROMED }}" >{{ $emp->NOMBRE }}</option>
                    @endforeach
                </select>
            </div>
            <div class="input-data">
				<div class="form-group content-descripcion-left-input" style="margin-bottom: 2em;"> 
    				<label class="label-left" style="font-size: 14px;">Descuentos:</label>
    				<input type="text" id="descuento" name="Descuento" value="">
        		</div>            
        	</div>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-default" data-dismiss="modal" id="Add">Agregar</button>
        </div>
      </div>
      
    </div>
</div>
@include('includes.footer')
@endsection
@section('jscript')
<script type="text/javascript">
	var token;
	var metodo;	
	var metodoIsp;
	var pantalla;
	var concepto;
	var periodo;
	var tabla;
	var empleado;
	var sueldo;
	var conceptParam = [];
	var descuentoFld = '<div class="form-group content-descripcion-left-input" style="margin-bottom: 2em;"> ' +
            			'	<label class="label-left" style="font-size: 14px;">Descuento</label>' +
            			'	<input type="text" id="descuento" name="Descuento" value="">' +
        				'</div>';
	var unidadesFld = '<div class="form-group content-descripcion-left-input" style="margin-bottom: 2em;"> ' +
            			'	<label class="label-left" style="font-size: 14px;">Unidades</label>' +
            			'	<input type="text" id="unidades" name="Unidades" value="">' +
        				'</div>';
	var importeFld =  '<div class="form-group content-descripcion-left-input" style="margin-bottom: 2em;"> ' +
            			'	<label class="label-left" style="font-size: 14px;">Importe</label>' +
            			'	<input type="text" id="importe" name="Importe" value="">' +
        				'</div>';

	$.ajaxSetup({
		headers: {
			'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
		}
	});

	$(document).ready(function() {
		token = $('input[name=_token]').val();
    	tabla = this.getElementById("captura");

		console.log('here we are. The token is: ' + token);

		$( "#nuevo" ).on('show.bs.modal', function() {
			// Agrega al MODAL, los campos que se deben capturar de acuerdo al valor de 'pantalla'
			var inputfields = $(".input-data");	
    		//console.log('concepto: ' + concepto + ' - ' + 'pantalla: ' + pantalla);
    		//console.log(inputfields[0].innerHTML);
    		switch (pantalla) {
    			case 1:
    			case 2:
    			    inputfields[0].innerHTML = descuentoFld;
    				break;
    			case 3:
    			    inputfields[0].innerHTML = unidadesFld;
    				break;
    			case 4:
					inputfields[0].innerHTML = importeFld;    			
    				break;
    			case 5:
					if (concepto == "500") {
						inputfields[0].innerHTML = descuentoFld;
					} else {
						inputfields[0].innerHTML = importeFld;
					}
    				break;
    		}
		});
	});

    $("#btnNuevo").click(function(){
		var concepto  =  $('.cpto').val();
    	if ( concepto != 0 && periodo != 0 ) {
        	$("#nuevo").modal();
        } else {
           alert('No ha seleccionado un concepto o período!');
        }
    });


    $("#Add").click(function(event){
		var nombre = $('#empleado>option:selected').text();
		var importe;
		var bOK = true;
		empleado  =  $('.emp').val();
		sueldo =  Number($('.emp').find(':selected').data('sueldo'));
		promed = Number($('.emp').find(':selected').data('promed'));

    	if ( empleado != 0 ) {
			// Checa si ya existe el empleado en la tabla
			if ($("table#captura tr").length > 1) {
				// $("table#captura tr").each(function(index) {
				// 	if (index > 0) {
						//var tableData = $(this).find('td');
						$.each($("table#captura tr td"), function(index, cell) {
							if (index > 1) {
								var celda = $(cell);
								// alert($(cell).innerHTML);
								console.log(celda.val());
							}
						});
						// alert(tableData[0]);
						// if (tableData[0][0] == empleado) {
					 //    	alert('ya capturaste a este pelaná');
					 //    	bOK = false;
						// }
				// 	}
				// });
			}
		} else {
           alert('No ha capturado el empleado!');
           event.preventDefault();
        }

		if (bOK) {
	    	switch (pantalla) {
	    		case 1:
	    		case 2:
					var descuento = $('#descuento').val();
			    	if ( descuento != 0 ) {
			        	var row = tabla.insertRow(tabla.rows.length);
			        	var col1 = row.insertCell(0);
			        	var col2 = row.insertCell(1);
			        	var col3 = row.insertCell(2);
						col1.innerHTML = '<td><input type="text" name="emp[]" />empleado</td>';
						col2.innerHTML = nombre;
						col3.innerHTML = amount;
			        } else {
			           alert('No ha capturado el importe del descuento!');
			        }
			        break;
			    case 3:
					var unidades = $('#unidades').val();
			    	if ( unidades != 0 ) {
			            switch (metodo.substr(2, 2)) {
			                case "06":
			                    // Sal.Base * param1 * uni.dias  
					            importe = (sueldo + promed)  * conceptParam[1] / 100 * unidades;
			                    break;
			                case "21":
			                    //ObjCal.DedPrim rs, RsAux, rstinteg, RstCon, rstnom, Afe100con, Result, sr, tipn
			                    break;
			            }
			        	var row = tabla.insertRow(tabla.rows.length);
			        	var col1 = row.insertCell(0);
			        	var col2 = row.insertCell(1);
			        	var col3 = row.insertCell(2);
			        	var col4 = row.insertCell(3);
			        	var col5 = row.insertCell(4);
						col1.innerHTML = '<td style="text-align:right;"><input type="text" name="emp[]" value="'+empleado+'" /></td>';
						col2.innerHTML = nombre;
						col3.innerHTML = periodo;
						col4.innerHTML = '<td style="text-align:right;"><input type="text" name="unidades[]" value="'+unidades+'" /></td>';
						col5.innerHTML = '<td style="text-align:right;"><input type="text" name="calculo[]" value="'+importe+'" /></td>';
			        } else {
			           alert('No ha capturado las unidades!');
			        }			    
			    	break;
			    case 4:
			    	break;
			    case 5:
			    	break;
			}
        }
    });

	$('.cpto').change(function() {
		var conceptData;
		var tipoCaptura;

		concepto = $('.cpto').val();
        $.post("get-concepto", { concepto: concepto, _token: token }, function( data ) {
            conceptData = Object.values(data);
            metodo = conceptData[0]["TIPCONCEP"] + conceptData[0]["TIPCALCUL"] + conceptData[0]["METODO"];
            metodoIsp = conceptData[0]["METODOISP"];
            conceptParam[1] = Number(conceptData[0]["PARAM1"]);
            conceptParam[2] = Number(conceptData[0]["PARAM2"]);
			document.getElementById("Metodo").value = metodo;
			document.getElementById("MetodoISP").value = metodoIsp;
            tipoCaptura = conceptData[0]["TIPCAPT"];
    		//console.log(conceptData[0]["CONCEPTO"] + ' - ' + tipoCaptura);	
    		console.log(metodo);
			switch (concepto) {
				case "652": 	// CONINFONAVIT0
					pantalla = 1;
					break;
				case "905":
				case "906":
				case "907":
				case "908":
				case "909":
				case "910":
					pantalla = 2;
					break;
				default:
					//console.log(tipoCaptura);
	    			switch (tipoCaptura) {
			    		case "1": 	// CAPUNI : Captura Unidades y calcula importe
			    			pantalla = 3;
			    			break;
			    		case "2": 	// CAPIMP : Captura Importes 
			    			pantalla = 4;
			    			break;
			    		case "3": 	// Captura Saldo Automático
			    			if (metodo == "2303" || metodo == "2310" || metodo == "2323" || metodo == "2327" || metodo == "2328" ) {
			    				pantalla = 1;
			    			} else {
			    				pantalla = 5;
			    			}
			    			break;
			    	}
			    	break;
	    	}
	    	creaPantalla(pantalla);
        });
	});

	$('.pdo').change(function() {
		var concepto  =  $('.cpto').val();
		periodo = $('.pdo').val();
    	//console.log(concepto + ' - ' + periodo);
    	// checa si hay movimientos capturados del período en cuyo caso los despliega
        $.post("get-movtos", { concepto: concepto, periodo: periodo, _token: token }, function( data ) {
            var movtos = Object.values(data);
    		//console.log(movtos);	
		    while (tabla.rows.length > 1) {
		        tabla.deleteRow(tabla.rows.length-1);
    		}
    	    for (var i = 0; i < movtos.length; i++) {
    	    	switch (pantalla) {
    	    		case 1:
    	    			break;
    	    		case 2:
    	    			break;
    	    		case 3:
		            	var row = tabla.insertRow(tabla.rows.length);
		            	var col1 = row.insertCell(0);
		            	var col2 = row.insertCell(1);
		            	var col3 = row.insertCell(2);
			        	var col4 = row.insertCell(3);
			        	var col5 = row.insertCell(4);
						col1.innerHTML = '<td style="text-align:right;"><input type="text" name="emp[]" value="'+movtos[i]["EMP"]+'" /></td>';
						col2.innerHTML = movtos[i]["NOMBRE"];
						col3.innerHTML = periodo;
						col4.innerHTML = '<td style="text-align:right;"><input type="text" name="unidades[]" value="'+movtos[i]["UNIDADES"]+'" /></td>';
						col5.innerHTML = '<td style="text-align:right;"><input type="text" name="calculo[]" value="'+movtos[i]["CALCULO"]+'" /></td>';
						break;
    	    		case 4:
    	    		case 5:
    	    			break;
    	    	}

            }
        });		
	});


	function creaPantalla(numPantalla) {
    	//console.log(numPantalla);
	    while (tabla.rows.length > 0) {
	        tabla.deleteRow(tabla.rows.length-1);
		}
    	var row = tabla.insertRow(tabla.rows.length);
    	var col1 = row.insertCell(0);
    	var col2 = row.insertCell(1);
    	var col3 = row.insertCell(2);
		col1.innerHTML = "Empleado";
		col2.innerHTML = "Nombre";
		col3.innerHTML = "Período";
		switch (numPantalla) {
			case 1:
    			var col4 = row.insertCell(3);
    			var col5 = row.insertCell(4);
    			var col6 = row.insertCell(5);
    			var col7 = row.insertCell(6);
    			var col8 = row.insertCell(7);
				col4.innerHTML = "Descuento";
				col5.innerHTML = "Saldo";
				col6.innerHTML = "Activo";
				col7.innerHTML = "Cálculo";
				col8.innerHTML = "Fecha";
				break;
			case 2:
    			var col4 = row.insertCell(3);
    			var col5 = row.insertCell(4);
    			var col6 = row.insertCell(5);
    			var col7 = row.insertCell(6);
    			var col8 = row.insertCell(7);
    			var col9 = row.insertCell(8);
				col4.innerHTML = "Descuento";
				col5.innerHTML = "Saldo";
				col6.innerHTML = "Desc. mes";
				col7.innerHTML = "Plazo";
				col8.innerHTML = "Activo";
				col9.innerHTML = "Cálculo";
				break;
			case 3:
    			var col4 = row.insertCell(3);
    			var col5 = row.insertCell(4);
				col4.innerHTML = "Unidades";
				col5.innerHTML = "Importe";
				break;
			case 4:
    			var col4 = row.insertCell(3);
    			var col5 = row.insertCell(4);
				col4.innerHTML = "Importe"; // Debe ser Unidades el titulo???
				col5.innerHTML = "Cálculo";			
				break;
			case 5:
    			var col4 = row.insertCell(3);
    			var col5 = row.insertCell(4);
    			var col6 = row.insertCell(5);
    			var col7 = row.insertCell(6);
				if (concepto == "500") {
					col4.innerHTML = "Descuento";
				} else {
					col4.innerHTML = "Importe";

				}
				col5.innerHTML = "Saldo";
				col6.innerHTML = "Activo";
				col7.innerHTML = "Cálculo";
				break;
		}
	}
</script>            
@endsection 