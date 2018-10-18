@extends('layouts.app')

@section('title','Aron | Menú')
@section('body-class','')

@section('content')
@if ($graficas->mensaje==1)<h1 align="center" style="color: rgb(0, 190, 239);">Bienvenido a la plataforma en línea ARON!</h1>@endif
@if ($graficas->grafica1==1 || $graficas->grafica2==1 || $graficas->grafica3==1 || $graficas->grafica4==1)


<h1 align="center" style="color: rgb(0, 190, 239);">INDICADORES</h1>
<br>

	<div style="max-width: 1300px; margin: auto;">
		<div style="max-width: 900px; margin: auto;">
			@if ($graficas->grafica1==1)
			<div style="width: 100%;">
				<div id="graficaLineal" style="margin: 0 auto">
				</div>
			</div>
			<br>
			@endif

			@if ($graficas->grafica2==1)
			<div style="width:100%;">
				<div id="graficaCircular" style="margin: 0 auto">
				</div>		
			</div>
			<br>
			@endif

			@if ($graficas->grafica3==1)
			<div style="width: 100%;">
				<div id="container" style="margin: 0 auto">
				</div>
			</div>
			<br>
			@endif

			@if ($graficas->grafica4==1)
			<div style="width: 100%;">
				<div id="container2" style="margin: 0 auto">
				</div>		
			</div>
			<br>
			@endif

		</div>
</div>


@else
<h1 style="text-align: center;">Bienvenido Web Master!!!</h1>
@endif
@include('includes.footer');
</html>
@endsection
@section('jscript')
<script type="text/javascript">
	var chart;
	$(document).ready(function() {

		chart = new Highcharts.Chart({
			chart: {
				renderTo: 'graficaLineal', 	// Le doy el nombre a la gráfica
				defaultSeriesType: 'line'	// Pongo que tipo de gráfica es
			},
			title: {
				text: 'Datos de las Visitas'	// Titulo (Opcional)
			},
			subtitle: {
				text: 'Vally.com'		// Subtitulo (Opcional)
			},
			// Pongo los datos en el eje de las 'X'
			xAxis: {
				categories: ['Feb12','Mar12','Abr12','May12','Jun12','Jul12','Ago12','Sep12','Oct12','Nov12',
	'Dic12','Ene13','Feb13','Mar13','Abr13','May13','Jun13'],
					// Pongo el título para el eje de las 'X'
					title: {
						text: 'Meses'
					}
				},
				yAxis: {
					// Pongo el título para el eje de las 'Y'
					title: {
						text: 'Nº Visitas'
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
			                name: 'Visitas',
			                data: [103,474,402,536,1041,270,0,160,2462,3797,3527,4505,8090,7493,7048]
			            },
			            {
			                name: 'Visitantes Únicos',
			                data: [21,278,203,370,810,213,0,134,1991,3122,2870,3655,6400,5818,5581]
			            },
			            {
			                name: 'Páginas Vistas',
			                data: [1064,1648,1040,1076,2012,397,0,325,3732,6067,5226,6482,11503,11937,9751]
			            }],
			});	
		});				
</script>

<script type="text/javascript">
	var chart;
	$(document).ready(function() {
		chart = new Highcharts.Chart({
			chart: {
				renderTo: 'graficaCircular'
			},
			title: {
				text: 'Porcentaje de Visitas por Paises'
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
					return '<b>'+ this.point.name +'</b>: '+ this.y +' %';
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
							return '<b>'+ this.point.name +'</b>: '+ this.y +' %';
						}
					}
				}
			},
		    series: [{
				type: 'pie',
				name: 'Browser share',
				data: [
						['España',35.38],
						['México',24.0],
						['Colombia',9.45],
						['Perú',5.74],
						['Argentina',5.14],
						['Chile',4.89],
						['Venezuela',3.04],
						['Ecuador',2.53],
						['Costa Rica',1.07]
					]
			}]
		});
	});			
</script>

<script type="text/javascript">
	$.getJSON(
    'https://cdn.rawgit.com/highcharts/highcharts/057b672172ccc6c08fe7dbb27fc17ebca3f5b770/samples/data/usdeur.json',
    function (data) {

        Highcharts.chart('container', {
            chart: {
                zoomType: 'x'
            },
            title: {
                text: 'USD a EUR cambio a lo largo del tiempo'
            },
            subtitle: {
                text: document.ontouchstart === undefined ?
                        'Click y arrastra en el area para zoom' : 'Pinch the chart to zoom in'
            },
            xAxis: {
                type: 'datetime'
            },
            yAxis: {
                title: {
                    text: 'Rango de cambio'
                }
            },
            legend: {
                enabled: false
            },
            plotOptions: {
                area: {
                    fillColor: {
                        linearGradient: {
                            x1: 0,
                            y1: 0,
                            x2: 0,
                            y2: 1
                        },
                        stops: [
                            [0, Highcharts.getOptions().colors[0]],
                            [1, Highcharts.Color(Highcharts.getOptions().colors[0]).setOpacity(0).get('rgba')]
                        ]
                    },
                    marker: {
                        radius: 2
                    },
                    lineWidth: 1,
                    states: {
                        hover: {
                            lineWidth: 1
                        }
                    },
                    threshold: null
                }
            },

            series: [{
                type: 'area',
                name: 'USD a EUR',
                data: data
            }]
        });
    }
	);
</script>

<script type="text/javascript">
	
	// Create the chart
	Highcharts.chart('container2', {
	    chart: {
	        type: 'column'
	    },
	    title: {
	        text: 'Exploradores mas usados. Enero, 2018'
	    },
	    subtitle: {
	        text: 'Click en las columnas para ver versión. Fuente: <a href="http://statcounter.com" target="_blank">statcounter.com</a>'
	    },
	    xAxis: {
	        type: 'categoria'
	    },
	    yAxis: {
	        title: {
	            text: 'Porcentaje total'
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
	                format: '{point.y:.1f}%'
	            }
	        }
	    },

	    tooltip: {
	        headerFormat: '<span style="font-size:11px">{series.name}</span><br>',
	        pointFormat: '<span style="color:{point.color}">{point.name}</span>: <b>{point.y:.2f}%</b> del total<br/>'
	    },

	    "series": [
	        {
	            "name": "Explorador",
	            "colorByPoint": true,
	            "data": [
	                {
	                    "name": "Chrome",
	                    "y": 62.74,
	                    "drilldown": "Chrome"
	                },
	                {
	                    "name": "Firefox",
	                    "y": 10.57,
	                    "drilldown": "Firefox"
	                },
	                {
	                    "name": "Internet Explorer",
	                    "y": 7.23,
	                    "drilldown": "Internet Explorer"
	                },
	                {
	                    "name": "Safari",
	                    "y": 5.58,
	                    "drilldown": "Safari"
	                },
	                {
	                    "name": "Edge",
	                    "y": 4.02,
	                    "drilldown": "Edge"
	                },
	                {
	                    "name": "Opera",
	                    "y": 1.92,
	                    "drilldown": "Opera"
	                },
	                {
	                    "name": "Other",
	                    "y": 7.62,
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
@endsection
