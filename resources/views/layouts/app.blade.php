<!doctype html>
<html lang="es">
    <head>
        <meta charset="utf-8" />
        <!-- CSFR token for ajax call -->
        <meta name="csrf-token" content="{{ csrf_token() }}" />
        <link rel="apple-touch-icon" sizes="76x76" href="../assets/img/apple-icon.png">
        <link rel="icon" type="image/png" href="../assets/img/favicon.png">
        <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1" />

        <title>@yield('title','Aron')</title>

        <meta content='width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=0' name='viewport' />

        <!--     Fonts and icons     -->
        <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous">
        <!-- <link rel="stylesheet" type="text/css" media="screen" href="plugins/noUiSlider.11.1.0/nouislider.min.css" /> -->

        <!-- Estilos de documento -->
        <link rel="stylesheet" type="text/css" media="screen" href="{{ asset('css/stick.css') }}" /> 
        <link rel="stylesheet" type="text/css" media="screen" href="{{ asset('css/docs.min.css') }}" />  
        <link rel="stylesheet" type="text/css" media="screen" href="{{ asset('css/prism.css') }}">
        <!-- Estilos de componentes -->
        <link rel="stylesheet" type="text/css" media="screen" href="{{ asset('css/style.css') }}" /> 
        <!-- Iconos -->
        <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.0.13/css/all.css" integrity="sha384-DNOHZ68U8hZfKXOrtjWvjxusGo9WQnrNx2sqG0tfsghAvtVlRW3tvkXWZh58N9jp" crossorigin="anonymous">
        <link rel="stylesheet" href="https://fonts.googleapis.com/icon?family=Material+Icons" /> 

         <!-- datatables -->
        <link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/1.10.19/css/jquery.dataTables.css">
        <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
        <script type="text/javascript" charset="utf8" src="{{ asset('js/jquery.dataTables.js')}}"></script>
        <!-- fin datatables -->         

        <!-- graficas  -->
        <!-- <script src="https://code.jquery.com/jquery-3.1.1.min.js"></script> -->
        <script src=" {{ asset('js/highcharts.js')}} "></script>
        <script src="https://code.highcharts.com/modules/exporting.js"></script>
        <script src="https://code.highcharts.com/modules/export-data.js"></script>
        <script src="https://code.highcharts.com/modules/drilldown.js"></script>     
        <!-- fin de graficas -->
    </head>

    <body class="@yield('body-class')">
        @include('includes.header')
        @yield('content')
    </body>     

    
        
    <!--   Core JS Files   -->

    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>     
<!--
    <script src="{{ asset('/js/jquery.min.js') }}" type="text/javascript"></script>
    <script src="{{ asset('/js/bootstrap.min.js') }}" type="text/javascript"></script>    
    <script src="{{ asset('/js/material.min.js') }}"></script> -->

    <!--  Plugin for the Sliders, full documentation here: http://refreshless.com/nouislider/ -->
    <!-- <script src="{{ asset('/js/nouislider.min.js') }}" type="text/javascript"></script> -->

    <script type="text/javascript" src="{{ asset('/js/XHR.js') }}"></script>

    <!--  Plugin for the Datepicker, full documentation here: http://www.eyecon.ro/bootstrap-datepicker/ -->
    <script src="{{ asset('/js/bootstrap-datepicker.js') }}" type="text/javascript"></script>
    <script>
$(document).ready( function () {
    $('#table_id').DataTable();

} );

</script> 
    @yield('jscript')    
</html>

