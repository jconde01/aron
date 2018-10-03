    @extends('layouts.app')

@section('title','Registrar nueva Célula')
@section('body-class','')

@section('content')
<div class="main main-raised">
    <div class="container">
        <div class="section">
            <h2 class="title text-center">Registrar nueva Célula</h2>
          <br>
            <form method="post" action="{{ url('/admin/celulas') }}">
                <input type="hidden" name="_token" value="{{ csrf_token() }}">

                <div class="row" style="margin-bottom: 5px;">
                        <div class="form-group content-descripcion-left-input">
                            <label class="label-left" style="font-size: 14px;">Nombre de la Célula</label>
                            <input type="text" name="nombre" >
                        </div>
                </div>



                <div class="col-sm-6" style="">
                    <div class="form-group content-descripcion-left-input">
                        <label class="label-left">Dominio</label>
                        <input type="text" name="dominio" id="DOMINIO" placeholder="@celula(n).com"  onkeyup="fAgrega2(); fAgrega1(); fAgrega3(); fAgrega4(); fAgrega5();" required>
                    </div>
                </div>

                
    <br><br><br>
                 
                <h3><label class="etiqueta">Usuarios y Perfiles</label></h3>
                <div class="col-sm-4" style="">
                    <div class="form-group content-descripcion-left-input">
                        <label class="label-left">director_general</label>
                        <input type="text" name="director_general" id="CORREO" placeholder="@celula(n).com" readonly="readonly" class="bloqueado">
                    </div>
                </div>
                <div class="col-sm-4" style="">
                    <div class="form-group content-descripcion-left-input">
                        <label class="label-left">generalista</label>
                        <input type="text" name="generalista" id="CORREO1" placeholder="@celula(n).com" readonly="readonly" class="bloqueado">
                    </div>
                </div>
                <div class="col-sm-4" style="">
                    <div class="form-group content-descripcion-left-input">
                        <label class="label-left">qc</label>
                        <input type="text" name="qc" id="CORREO2" placeholder="@celula(n).com" readonly="readonly" class="bloqueado">
                    </div>
                </div>

                <div class="col-sm-6" style="">
                    <div class="form-group content-descripcion-left-input">
                        <label class="label-left">fiscalista</label>
                        <input type="text" name="fiscalista" id="CORREO3" placeholder="@celula(n).com" readonly="readonly" class="bloqueado">
                    </div>
                </div>
                <div class="col-sm-6" style="">
                    <div class="form-group content-descripcion-left-input">
                        <label class="label-left">soporte_tecnico</label>
                        <input type="text" name="soporte_tecnico" id="CORREO4" placeholder="@celula(n).com" readonly="readonly" class="bloqueado">
                    </div>
                </div>

                <div class="row text-center">
                    <br><br><br><br>
                    <button class="primario separation">Guardar</button>
                    <a href="{{ url('/admin/celulas') }}" class="primario1">Cancelar</a>
                </div>
            </form>

        </div>
    </div>
</div>
@endsection
@section('jscript')

<script language="javascript">
function fAgrega1()
{
document.getElementById("CORREO").value = document.getElementById("DOMINIO").value;
}
</script>
<script language="javascript">
function fAgrega2()
{
document.getElementById("CORREO1").value = document.getElementById("DOMINIO").value;
}
</script> 
<script language="javascript">
function fAgrega3()
{
document.getElementById("CORREO2").value = document.getElementById("DOMINIO").value;
}
</script> 
<script language="javascript">
function fAgrega4()
{
document.getElementById("CORREO3").value = document.getElementById("DOMINIO").value;
}
</script>    
<script language="javascript">
function fAgrega5()
{
document.getElementById("CORREO4").value = document.getElementById("DOMINIO").value;
}
</script>              
@endsection