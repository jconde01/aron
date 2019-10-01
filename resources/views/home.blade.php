@extends('layouts.app')
  
@section('title','Aron | Menú')
@section('body-class','')
@section('content')
@if (isset($graficas->grafica1))

<h1 align="center" style="color: rgb(0, 190, 239);">INDICADORES</h1>
<br>

<div class="row" style="">
	
		<div class="col-md-12" style="">  
            <ul class="tab horizontal" style=" width: 100%; display: flex; justify-content: center;">
            @if ($graficas->grafica1==1)
              <li class="tab-group-item pestanas" onClick="cambiar_color_over(this)" id="tab1"><a class="tabmovil" data-toggle="tab" id="a1" href="#nomina1">Costo de Nómina</a></li>
            @endif

            @if ($graficas->grafica2==1)
              <li class="tab-group-item pestanas" onClick="cambiar_color_over(this)" id="tab2" style="{{ $graficas->grafica1!==1? 'border-bottom: 0px;border-left: 2px rgb(179, 215, 243) solid; border-right: 2px rgb(179, 215, 243) solid;border-top: 2px rgb(179, 215, 243) solid;':'' }}"><a class="tabmovil" id="a2" data-toggle="tab" href="#nomina2">Distribución Departamentos</a></li>
            @endif

            @if ($graficas->grafica3==1)
              <li class="tab-group-item pestanas" id="tab3" style="{{ $graficas->grafica1!==1 && $graficas->grafica2!==1? 'border-bottom: 0px;border-left: 2px rgb(179, 215, 243) solid; border-right: 2px rgb(179, 215, 243) solid;border-top: 2px rgb(179, 215, 243) solid;':'' }}" onClick="cambiar_color_over(this)"><a class="tabmovil" id="a3" data-toggle="tab" href="#datosg">Faltas</a></li>
            @endif

            @if ($graficas->grafica4==1)
              <li class="tab-group-item pestanas" id="tab4" style="{{ $graficas->grafica1!==1 && $graficas->grafica2!==1 && $graficas->grafica3!==1? 'border-bottom: 0px;border-left: 2px rgb(179, 215, 243) solid; border-right: 2px rgb(179, 215, 243) solid;border-top: 2px rgb(179, 215, 243) solid;':'' }}" onClick="cambiar_color_over(this)"><a class="tabmovil" id="a4" data-toggle="tab" href="#horas">Horas Extras</a></li>
            @endif

            @if ($graficas->grafica5==1)
               <li class="tab-group-item pestanas" id="tab5" style="{{ $graficas->grafica1!==1 && $graficas->grafica2!==1 && $graficas->grafica3!==1 && $graficas->grafica4!==1? 'border-bottom: 0px;border-left: 2px rgb(179, 215, 243) solid; border-right: 2px rgb(179, 215, 243) solid;border-top: 2px rgb(179, 215, 243) solid;':'' }}" onClick="cambiar_color_over(this)"><a class="tabmovil" id="a5" data-toggle="tab" href="#datosa">Distribución de Edades</a></li>
            
            @endif
            @if ($graficas->grafica6==1)
               <li class="tab-group-item pestanas" id="tab6" style="{{ $graficas->grafica1!==1 && $graficas->grafica2!==1 && $graficas->grafica3!==1 && $graficas->grafica4!==1 && $graficas->grafica5!==1? 'border-bottom: 0px;border-left: 2px rgb(179, 215, 243) solid; border-right: 2px rgb(179, 215, 243) solid;border-top: 2px rgb(179, 215, 243) solid;':'' }}" onClick="cambiar_color_over(this)"><a class="tabmovil" id="a6" data-toggle="tab" href="#tabseis">Reporte de Plazas</a></li>
            
            @endif
            @if ($graficas->grafica7==1)
               <li class="tab-group-item pestanas" id="tab7" style="{{ $graficas->grafica1!==1 && $graficas->grafica2!==1 && $graficas->grafica3!==1 && $graficas->grafica4!==1 && $graficas->grafica5!==1 && $graficas->grafica6!==1? 'border-bottom: 0px;border-left: 2px rgb(179, 215, 243) solid; border-right: 2px rgb(179, 215, 243) solid;border-top: 2px rgb(179, 215, 243) solid;':'' }}" onClick="cambiar_color_over(this)"><a class="tabmovil" id="a7" data-toggle="tab" href="#tabsiete">Causas de Baja</a></li>
            
            @endif

            @if ($graficas->grafica8==1)
               <li class="tab-group-item pestanas" id="tab8" style="{{ $graficas->grafica1!==1 && $graficas->grafica2!==1 && $graficas->grafica3!==1 && $graficas->grafica4!==1 && $graficas->grafica5!==1 && $graficas->grafica6!==1 && $graficas->grafica7!==1? 'border-bottom: 0px;border-left: 2px rgb(179, 215, 243) solid; border-right: 2px rgb(179, 215, 243) solid;border-top: 2px rgb(179, 215, 243) solid;':'' }}" onClick="cambiar_color_over(this)"><a class="tabmovil" id="a8" data-toggle="tab" href="#tabocho">IRP</a></li>
            
            @endif

            </ul>
            
            
    	</div>
	    <div class="col-md-8 col-md-offset-2">
		            <div class="tab-content">
		        		@if ($graficas->grafica1==1)
			            <div id="nomina1" class="tab-pane fade in active" style="">
			            	
							<div style=" ">
								
								<div id="container" style="margin: 0 auto">
								</div>
							</div>
							<br>
							 
			            </div>
			           @endif
			           @if ($graficas->grafica2==1)
			            <div id="nomina2" class="tab-pane fade{{ $graficas->grafica1!==1? 'in active':'' }}" style="">
			            	
							<div style="">
								<div id="graficaCircular" style="margin: 0 auto">
								</div>		
							</div>
							<br>
							
			            </div>
			            @endif
			            @if ($graficas->grafica3==1)
			            <div id="datosg" class="tab-pane fade{{ $graficas->grafica1!==1 && $graficas->grafica2!==1? 'in active':'' }}">
			            	
							<div style="">
								<div id="graficaLineal" style="margin: 0 auto">
								</div>
							</div>
							<br>
							
			            </div>
			            @endif
			            @if ($graficas->grafica4==1)
			            <div id="horas" class="tab-pane fade{{ $graficas->grafica1!==1 && $graficas->grafica2!==1 && $graficas->grafica3!==1? 'in active':'' }}">

			            	
			            	 
							<div style="">
								<div id="horas" style="margin: 0 auto">
								</div>
							</div>
							<br>
							
			            </div>
			            @endif
			            @if ($graficas->grafica5==1)
			            <div id="datosa" class="tab-pane fade{{ $graficas->grafica1!==1 && $graficas->grafica2!==1 && $graficas->grafica3!==1 && $graficas->grafica4!==1? 'in active':'' }}">
			            	
							<div style="">
								<div id="container2" style="margin: 0 auto">
								</div>		
							</div>
							<br>
							
			            </div>
			            @endif
			            @if ($graficas->grafica6==1)
			            <div id="tabseis" class="tab-pane fade{{ $graficas->grafica1!==1 && $graficas->grafica2!==1 && $graficas->grafica3!==1 && $graficas->grafica4!==1 && $graficas->grafica5!==1? 'in active':'' }}">
			            	
							<div style="">
								<div id="containerseis" style="margin: 0 auto">
								</div>		
							</div>
							<br>
							
			            </div>
			            @endif
			            @if ($graficas->grafica7==1)
			            <div id="tabsiete" class="tab-pane fade{{ $graficas->grafica1!==1 && $graficas->grafica2!==1 && $graficas->grafica3!==1 && $graficas->grafica4!==1 && $graficas->grafica5!==1 && $graficas->grafica6!==1? 'in active':'' }}">
			            	
							<div style="">
								<div id="containersiete" style="margin: 0 auto">
								</div>		
							</div>
							<br>
							
			            </div>
			            @endif
			            @if ($graficas->grafica8==1)
			            <div id="tabocho" class="tab-pane fade{{ $graficas->grafica1!==1 && $graficas->grafica2!==1 && $graficas->grafica3!==1 && $graficas->grafica4!==1 && $graficas->grafica5!==1 && $graficas->grafica6!==1 && $graficas->grafica7!==1? 'in active':'' }}">
			            	
							<div style="">
								<div id="containerocho" style="margin: 0 auto">
								</div>		
							</div>
							<br>
							
			            </div>
			            @endif
		            </div>
		</div>
    
</div> 


<br>
@include('includes.footer');
@else
@include('includes.footer');
@endif
</html>
@if (isset($graficas->grafica1))
<script type="text/javascript">
	$( document ).ready(function() {
	@if ($graficas->grafica6==1)
    plazas();
     @endif
    @if ($graficas->grafica7==1)
    grafica10();
    @endif
    @if ($graficas->grafica8==1)
     grafica8();
   	@endif
   
});
</script>
@if ($graficas->grafica3==1)
<script type="text/javascript">
	var chart;
	$(document).ready(function() {

		chart = new Highcharts.Chart({
			chart: {
				renderTo: 'graficaLineal', 	// Le doy el nombre a la gráfica
				defaultSeriesType: 'line'	// Pongo que tipo de gráfica es
			},
			title: {
				text: 'Faltas'	// Titulo (Opcional)
			},
			subtitle: {
				text: 'Vally.com'		// Subtitulo (Opcional)
			},
			// Pongo los datos en el eje de las 'X'
			xAxis: {
				categories: ['Ene19','Feb19','Mar19','Abr19','May19','Jun19','Jul19','Ago19','Sep19','Oct19',
	'Nov19','Dic19'],
					// Pongo el título para el eje de las 'X'
					title: {
						text: 'Meses'
					}
				},
				yAxis: {
					// Pongo el título para el eje de las 'Y'
					title: {
						text: 'Rango'
					}
				},
				// Doy formato al la "cajita" que sale al pasar el ratón por encima de la gráfica
				tooltip: {
					enabled: true,
					formatter: function() {
						return '<b>'+ this.series.name +'</b><br/>'+
							this.x +': '+ this.y +' '+this.series.name;
					}
				},
				// Doy opciones a la gráfica
				plotOptions: {
					line: {
						dataLabels: {
							enabled: true
						},
						enableMouseTracking: true
					}
				},
				// Doy los datos de la gráfica para dibujarlas
				series: [{
			                name: 'Faltas Injustificadas',
			                data: [<?php if (isset($data)) { print_r($data[0])?>,<?php print_r($data[1])?>,<?php print_r($data[2])?>,<?php print_r($data[3])?>,<?php print_r($data[4])?>,<?php print_r($data[5])?>,<?php print_r($data[6])?>,<?php print_r($data[7])?>,<?php print_r($data[8])?>,<?php print_r($data[9])?>,<?php print_r($data[10])?>,<?php print_r($data[11]);
			                }?>]
			            }],
			});	
		});				
</script>
@endif
@if (isset($graficas->grafica1))
	@if ($graficas->grafica4==1)
		<script type="text/javascript">
			var chart;
			$(document).ready(function() {

				chart = new Highcharts.Chart({
					chart: {
						renderTo: 'horas', 	// Le doy el nombre a la gráfica
						defaultSeriesType: 'line'	// Pongo que tipo de gráfica es
					},
					title: {
						text: 'Horas Extras'	// Titulo (Opcional)
					},
					subtitle: {
						text: 'Vally.com'		// Subtitulo (Opcional)
					},
					// Pongo los datos en el eje de las 'X'
					xAxis: {
						categories: ['Ene19','Feb19','Mar19','Abr19','May19','Jun19','Jul19','Ago19','Sep19','Oct19',
			'Nov19','Dic19'],
							// Pongo el título para el eje de las 'X'
							title: {
								text: 'Meses'
							}
						},
						yAxis: {
							// Pongo el título para el eje de las 'Y'
							title: {
								text: 'Rango'
							}
						},
						// Doy formato al la "cajita" que sale al pasar el ratón por encima de la gráfica
						tooltip: {
							enabled: true,
							formatter: function() {
								return '<b>'+ this.series.name +'</b><br/>'+
									this.x +': '+ this.y +' '+this.series.name;
							}
						},
						// Doy opciones a la gráfica
						plotOptions: {
							line: {
								dataLabels: {
									enabled: true
								},
								enableMouseTracking: true
							}
						},
						// Doy los datos de la gráfica para dibujarlas
						series: [{
					                name: 'Horas extras',
					                data: [<?php if (isset($data2)) { 
					                	print_r($data2[0])?>,<?php print_r($data2[1])?>,<?php print_r($data2[2])?>,<?php print_r($data2[3])?>,<?php print_r($data2[4])?>,<?php print_r($data2[5])?>,<?php print_r($data2[6])?>,<?php print_r($data2[7])?>,<?php print_r($data2[8])?>,<?php print_r($data2[9])?>,<?php print_r($data2[10])?>,<?php print_r($data2[11]);
					                }?>]
					            }],
					});	
				});				
		</script>
	@endif
@endif
 @if ($graficas->grafica2==1)
<script type="text/javascript">
	var chart;
	$(document).ready(function() {
		chart = new Highcharts.Chart({
			chart: {
				renderTo: 'graficaCircular'
			},
			title: {
				text: 'Distribución de Departamentos'
			},
			subtitle: {
				text: 'Vally.com'
			},
			plotArea: {
				shadow: null,
				borderWidth: null,
				backgroundColor: null
			},
			tooltip: {
				formatter: function() {
					return '<b>'+ this.point.name +'</b>: '+ this.y +' ocupadas';
				}
			},
			plotOptions: {
				pie: {
					allowPointSelect: true,
					cursor: 'pointer',
					dataLabels: {
						enabled: true,
						color: '#000000',
						connectorColor: '#000000',
						formatter: function() {
							return '<b>'+ this.point.name +'</b>: '+ this.y +' ocupadas';
						}
					}
				}
			},
		    series: [{
				type: 'pie',
				name: 'Browser share',
				data: [<?php 
						  if (isset($data3)) {
						  $a= count($data3);
                    	  for ($i=1; $i <$a ; $i++) { 
                          echo "[";echo "'"; print_r($data3[$i]); echo "'"; echo ","; print_r($data3[$i+1]); echo "],";
                          $i++;
                    	   } 
                    	  }
                    	 ?>
					  ]
			}]
		});
	});			
</script>
@endif
@if ($graficas->grafica1==1)
<script type="text/javascript">
	Highcharts.chart('container', {
    chart: {
        type: 'area'
    },
    title: {
        text: 'COSTO DE NÓMINA'
    },
    xAxis: {
        categories: ['Enero', 'Febrero', 'Marzo', 'Abril', 'Mayo','Junio','Julio','Agosto','Septiembre','Octubre','Noviembre','Diciembre']
    },
    yAxis: {
					// Pongo el título para el eje de las 'Y'
					title: {
						text: 'Valor en pesos'
					}
				},
    credits: {
        enabled: false
    },
    series: [{
        name: '2018',
        data: [<?php if (isset($data4)) {
        	print_r($data4[0]);echo ",";print_r($data4[1]);echo ",";print_r($data4[2]);echo ",";print_r($data4[3]);echo ",";print_r($data4[4]);echo ",";print_r($data4[5]);echo ",";print_r($data4[6]);echo ",";print_r($data4[7]);echo ",";print_r($data4[8]);echo ",";print_r($data4[9]);echo ",";print_r($data4[10]);echo ",";print_r($data4[11]);
        } ?>]
    }, {
        name: '2019',
        data: [<?php if (isset($data4)) {
        	print_r($l9data4[0]);echo ",";print_r($l9data4[1]);echo ",";print_r($l9data4[2]);echo ",";print_r($l9data4[3]);echo ",";print_r($l9data4[4]);echo ",";print_r($l9data4[5]);echo ",";print_r($l9data4[6]);echo ",";print_r($l9data4[7]);echo ",";print_r($l9data4[8]);echo ",";print_r($l9data4[9]);echo ",";print_r($l9data4[10]);echo ",";print_r($l9data4[11]);
        } ?>]
    }, {
        name: '2020',
        data: [0,0 ,0 ,0 ,0, 0,0 ,0 ,0 ,0,0,0]
    }]
});
</script>
@endif
@if ($graficas->grafica5==1)
<script type="text/javascript">
	
	// Create the chart
	Highcharts.chart('container2', {
	    chart: {
	        type: 'column'
	    },
	    title: {
	        text: 'Edades'
	    },
	    subtitle: {
	        text: 'Click en las columnas para ver edades. Fuente: <a href="#" target="_blank">Aron</a>'
	    },
	    xAxis: {
	        type: 'categoria'
	    },
	    yAxis: {
	        title: {
	            text: 'No. de empleados'
	        }

	    },
	    legend: {
	        enabled: false
	    },
	    plotOptions: {
	        series: {
	            borderWidth: 0,
	            dataLabels: {
	                enabled: true,
	                format: '{point.y:.1f} en total'
	            }
	        }
	    },

	    tooltip: {
	        headerFormat: '<span style="font-size:11px">{series.name}</span><br>',
	        pointFormat: '<span style="color:{point.color}">{point.name}</span>: <b>{point.y:.2f}</b> del total<br/>'
	    },

	    "series": [
	        {
	            "name": "Edades",
	            "colorByPoint": true,
	            "data": [
	                {
	                    "name": "20-25",
	                    "y": <?php if (isset($cont20)) { echo $cont20;} ?>,
	                    "drilldown": ""
	                },
	                {
	                    "name": "26-30",
	                    "y": <?php if (isset($cont26)) { echo $cont26;} ?>,
	                    "drilldown": ""
	                },
	                {
	                    "name": "31-35",
	                    "y":<?php if (isset($cont31)) { echo $cont31;} ?>,
	                    "drilldown": ""
	                },
	                {
	                    "name": "36-40",
	                    "y": <?php if (isset($cont36)) { echo $cont36;} ?>,
	                    "drilldown": ""
	                },
	                {
	                    "name": "41-45",
	                    "y": <?php if (isset($cont41)) { echo $cont41;} ?>,
	                    "drilldown": ""
	                },
	                {
	                    "name": "46-60",
	                    "y": <?php if (isset($cont46)) { echo $cont46;} ?>,
	                    "drilldown": ""
	                },
	                {
	                    "name": "Mayores",
	                    "y": <?php if (isset($cont60)) { echo $cont60;} ?>,
	                    "drilldown": null
	                }
	            ]
	        }
	    ],
	    "drilldown": {
	        "series": [
	            {
	                "name": "Chrome",
	                "id": "Chrome",
	                "data": [
	                    [
	                        "v65.0",
	                        0.1
	                    ],
	                    [
	                        "v64.0",
	                        1.3
	                    ],
	                    [
	                        "v63.0",
	                        53.02
	                    ],
	                    [
	                        "v62.0",
	                        1.4
	                    ],
	                    [
	                        "v61.0",
	                        0.88
	                    ],
	                    [
	                        "v60.0",
	                        0.56
	                    ],
	                    [
	                        "v59.0",
	                        0.45
	                    ],
	                    [
	                        "v58.0",
	                        0.49
	                    ],
	                    [
	                        "v57.0",
	                        0.32
	                    ],
	                    [
	                        "v56.0",
	                        0.29
	                    ],
	                    [
	                        "v55.0",
	                        0.79
	                    ],
	                    [
	                        "v54.0",
	                        0.18
	                    ],
	                    [
	                        "v51.0",
	                        0.13
	                    ],
	                    [
	                        "v49.0",
	                        2.16
	                    ],
	                    [
	                        "v48.0",
	                        0.13
	                    ],
	                    [
	                        "v47.0",
	                        0.11
	                    ],
	                    [
	                        "v43.0",
	                        0.17
	                    ],
	                    [
	                        "v29.0",
	                        0.26
	                    ]
	                ]
	            },
	            {
	                "name": "Firefox",
	                "id": "Firefox",
	                "data": [
	                    [
	                        "v58.0",
	                        1.02
	                    ],
	                    [
	                        "v57.0",
	                        7.36
	                    ],
	                    [
	                        "v56.0",
	                        0.35
	                    ],
	                    [
	                        "v55.0",
	                        0.11
	                    ],
	                    [
	                        "v54.0",
	                        0.1
	                    ],
	                    [
	                        "v52.0",
	                        0.95
	                    ],
	                    [
	                        "v51.0",
	                        0.15
	                    ],
	                    [
	                        "v50.0",
	                        0.1
	                    ],
	                    [
	                        "v48.0",
	                        0.31
	                    ],
	                    [
	                        "v47.0",
	                        0.12
	                    ]
	                ]
	            },
	            {
	                "name": "Internet Explorer",
	                "id": "Internet Explorer",
	                "data": [
	                    [
	                        "v11.0",
	                        6.2
	                    ],
	                    [
	                        "v10.0",
	                        0.29
	                    ],
	                    [
	                        "v9.0",
	                        0.27
	                    ],
	                    [
	                        "v8.0",
	                        0.47
	                    ]
	                ]
	            },
	            {
	                "name": "Safari",
	                "id": "Safari",
	                "data": [
	                    [
	                        "v11.0",
	                        3.39
	                    ],
	                    [
	                        "v10.1",
	                        0.96
	                    ],
	                    [
	                        "v10.0",
	                        0.36
	                    ],
	                    [
	                        "v9.1",
	                        0.54
	                    ],
	                    [
	                        "v9.0",
	                        0.13
	                    ],
	                    [
	                        "v5.1",
	                        0.2
	                    ]
	                ]
	            },
	            {
	                "name": "Edge",
	                "id": "Edge",
	                "data": [
	                    [
	                        "v16",
	                        2.6
	                    ],
	                    [
	                        "v15",
	                        0.92
	                    ],
	                    [
	                        "v14",
	                        0.4
	                    ],
	                    [
	                        "v13",
	                        0.1
	                    ]
	                ]
	            },
	            {
	                "name": "Opera",
	                "id": "Opera",
	                "data": [
	                    [
	                        "v50.0",
	                        0.96
	                    ],
	                    [
	                        "v49.0",
	                        0.82
	                    ],
	                    [
	                        "v12.1",
	                        0.14
	                    ]
	                ]
	            }
	        ]
	    }
	});
</script>
@endif

<!-- ----- cambio de color pestañas---------------- -->
<script type="text/javascript">
    function cambiar_color_over(pestana){ 
    var x= document.getElementsByClassName("pestanas");
    var i;
    for (i = 0; i < x.length; i++) {
        x[i].style.backgroundColor = "white";
        x[i].style.borderTop = "0px";
        x[i].style.borderLeft = "0px";
        x[i].style.borderRight = "0px";
         x[i].style.borderBottom = "2px rgb(179, 215, 243) solid";
        }
    // pestana.style.backgroundColor="rgb(179, 215, 243)";
    pestana.style.borderBottom="0px";
    pestana.style.borderTop = "2px rgb(179, 215, 243) solid";
    pestana.style.borderLeft = "2px rgb(179, 215, 243) solid";
    pestana.style.borderRight = "2px rgb(179, 215, 243) solid";
    pestana.style.borderRadius = "0px";
    pestana.style.color = "rgb(179, 215, 243)";
    } 
</script>
<!-- ----------- fin de cambio de color pestañas------------------ -->
	@if ($graficas->grafica6==1)
	<!-- grafica de plazas -->
	<script type="text/javascript">
	  $.ajaxSetup({
	    headers: {
	        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
	            }
	  });  
	  function plazas() {
	    var token = $('input[name=_token]').val();        
	    var tipo  =  1;

	        $.post("/consultas/get-reporte-seis", { tipo: tipo, _token: token }, function( data ) {  

	            if (data != 'Error') {
	              grafica6(data['totales'],data['nombres']);
	               
	            } else {
	                alert('Error de acceso a la base de datos. Verifique la conexión...')
	            }

	        });   
	  };
	 
	  var chart;
	  function grafica6($valores,$nombres) {
	    
	    chart = new Highcharts.Chart({
	      chart: {
	        renderTo: 'containerseis',  // Le doy el nombre a la gráfica
	        defaultSeriesType: 'line' // Pongo que tipo de gráfica es
	      },
	      title: {
	        text: '% de plazas completas'  // Titulo (Opcional)
	      },
	      subtitle: {
	        text: 'Vally.com'   // Subtitulo (Opcional)
	      },
	      // Pongo los datos en el eje de las 'X'
	      xAxis: {
	        categories: [<?php for ($i=0; $i <$NoPues ; $i++) { 
	                        echo '$nombres['; echo $i; echo "],";
	                      } ?>],
	          // Pongo el título para el eje de las 'X'
	          title: {
	            text: 'Plazas'
	          }
	        },
	        yAxis: {
	          // Pongo el título para el eje de las 'Y'
	          title: {
	            text: 'Rango'
	          }
	        },
	        // Doy formato al la "cajita" que sale al pasar el ratón por encima de la gráfica
	        tooltip: {
	          enabled: true,
	          formatter: function() {
	            return '<b>'+ this.series.name +'</b><br/>'+
	              this.x +': '+ this.y +' '+this.series.name;
	          }
	        },
	        // Doy opciones a la gráfica
	        plotOptions: {
	          line: {
	            dataLabels: {
	              enabled: true
	            },
	            enableMouseTracking: true
	          }
	        },
	        // Doy los datos de la gráfica para dibujarlas
	        series: [{
	                      name: '% de Plazas Completas',
	                      data: [<?php for ($i=0; $i <$NoPues ; $i++) { 
	                        echo '$valores['; echo $i; echo "],";
	                      } ?>]
	                  }],
	      }); 
	    };
	</script>
	@endif
	@if ($graficas->grafica7==1)
	<!-- grafica causa de bajas -->
	<script type="text/javascript">

	  function grafica10() {
	    
	    Highcharts.chart('containersiete', {
	    chart: {
	        type: 'column'
	    },
	    title: {
	        text: 'MOTIVOS DE BAJA'
	    },
	    subtitle: {
	        text: 'Fuente: aron.com.mx'
	    },
	    xAxis: {
	        categories: [
	            'ACOSO',
	            'CAMBIO DE RESIDENCIA',
	            'CUIDADO DE SUS HIJOS',
	            'LEJANIA',
	            'MAYORES PRESTACIONES',
	            'MEJOR HORARIO',
	            'MEJOR SUELDO',
	            'OTRO EMPLEO',
	            'PROBLEMAS FAMILIARES',
	            'PROBLEMAS PERSONALES',
	            'RENUNCIA VOLUNTARIA'
	        ],
	        crosshair: true
	    },
	    yAxis: {
	        min: 0,
	        title: {
	            text: ''
	        }
	    },
	    tooltip: {
	        headerFormat: '<span style="font-size:10px">{point.key}</span><table>',
	        pointFormat: '<tr><td style="color:{series.color};padding:0">{series.name}: </td>' +
	            '<td style="padding:0"><b>{point.y:.1f}</b></td></tr>',
	        footerFormat: '</table>',
	        shared: true,
	        useHTML: true
	    },
	    plotOptions: {
	        column: {
	            pointPadding: 0.2,
	            borderWidth: 0
	        }
	    },
	    series: [{
	        name: 'TOTAL',
	        data: [1, 3, 3, 2, 1, 2, 4, 4, 2, 1, 1],
	        dataLabels: {
	                enabled: true,
	                rotation: 0,
	                color: '#FFFFFF',
	                align: 'right',
	                y: 10, // 10 pixels down from the top
	                style: {
	                    fontSize: '10px',
	                    fontFamily: 'helvetica, arial, sans-serif',
	                    textShadow: false,
	                    fontWeight: 'normal'

	                }
	            }

	    }]
	    });
	  };
	</script>
	@endif
	@if ($graficas->grafica8==1)
	<!-- grafica IRP -->
	<script type="text/javascript">
	   var chart;
	  function grafica8() {
	    
	    
	    Highcharts.chart('containerocho', {
	    chart: {
	        type: 'column'
	    },
	    title: {
	        text: 'IRP'
	    },
	    subtitle: {
	        text: 'Fuente: aron.com.mx'
	    },
	    xAxis: {
	        categories: [
	            'ENERO',
	            'FEBRERO',
	            'MARZO',
	            'ABRIL',
	            'MAYO',
	            'JUNIO',
	            'JULIO',
	            'AGOSTO',
	            'SEPTIEMBRE',
	            'OCTUBRE',
	            'NOVIEMBRE',
	            'DICIEMBRE'
	        ],
	        crosshair: true
	    },
	    yAxis: {
	        min: 0,
	        title: {
	            text: ''
	        }
	    },
	    tooltip: {
	        headerFormat: '<span style="font-size:10px">{point.key}</span><table>',
	        pointFormat: '<tr><td style="color:{series.color};padding:0">{series.name}: </td>' +
	            '<td style="padding:0"><b>{point.y:.1f}</b></td></tr>',
	        footerFormat: '</table>',
	        shared: true,
	        useHTML: true
	    },
	    plotOptions: {
	        column: {
	            pointPadding: 0.2,
	            borderWidth: 0
	        }
	    },
	    series: [{
	        name: 'ALTAS',
	        data: [9, 8, 3, 6, 6, 5, 10, 8, 0, 0, 0, 0],
	        dataLabels: {
	                enabled: true,
	                rotation: 0,
	                color: '#FFFFFF',
	                align: 'right',
	                y: 10, // 10 pixels down from the top
	                style: {
	                    fontSize: '10px',
	                    fontFamily: 'helvetica, arial, sans-serif',
	                    textShadow: false,
	                    fontWeight: 'normal'

	                }
	            }

	    }, {
	        name: 'BAJAS',
	        data: [5, 4, 1, 4, 1, 2, 6, 3, 0, 0, 0, 0],
	        dataLabels: {
	                enabled: true,
	                rotation: 0,
	                color: '#FFFFFF',
	                align: 'right',
	                y: 10, // 10 pixels down from the top
	                style: {
	                    fontSize: '10px',
	                    fontFamily: 'helvetica, arial, sans-serif',
	                    textShadow: false,
	                    fontWeight: 'normal'

	                }
	            }

	    }, {
	        name: 'No. DE TRABAJADORES AL INICIAR PERIODO',
	        data: [45, 49, 53, 55, 57, 62, 65, 69, 0, 0, 0, 0],
	        dataLabels: {
	                enabled: true,
	                rotation: 0,
	                color: '#FFFFFF',
	                align: 'right',
	                y: 10, // 10 pixels down from the top
	                style: {
	                    fontSize: '10px',
	                    fontFamily: 'helvetica, arial, sans-serif',
	                    textShadow: false,
	                    fontWeight: 'normal'

	                }
	            }

	    }, {
	        name: 'No. TRABAJADORES AL FINAL PERIODO',
	        data: [49, 53, 55, 57, 62, 65, 69, 74, 0, 0, 0, 0],
	        dataLabels: {
	                enabled: true,
	                rotation: 0,
	                color: '#FFFFFF',
	                align: 'right',
	                y: 10, // 10 pixels down from the top
	                style: {
	                    fontSize: '10px',
	                    fontFamily: 'helvetica, arial, sans-serif',
	                    textShadow: false,
	                    fontWeight: 'normal'

	                }
	            }

	    },
	    {
	        type: 'spline',
	        name: 'IRP',
	        data: [8.51, 7.84, 3.70, 3.57, 8.40, 4.72, 5.97, 6.99],
	        marker: {
	            lineWidth: 2,
	            lineColor: Highcharts.getOptions().colors[3],
	            fillColor: 'white'
	        }
	    }]
	  });
	      };
	</script>
	@endif
@endif
@endsection
