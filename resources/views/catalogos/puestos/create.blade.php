@extends('layouts.app')
@section('body-class', 'profile-page sidebar-collapse') <!-- Paso la clase class="login-page sidebar-collapse" por medio de una seccion en el lugar que se llama body-class, en la pagina donde quiero que funcione la clase -->
@section('content')
    
  <div class="main main-raised">
    <div>
 
      <div class="section text-center">
        <h2 class="titulo">Registrar Nuevo Puesto</h2>
        <br>
        <form method="POST" action=" {{url('/catalogos/puestos')}} ">
          {{ csrf_field() }}

          <div class="row"> 
                     
                    <div class="col-md-3 no-pad" style="">
                        <div class="content-descripcion-left-input" style="margin-bottom: 2em;  width: 250px;">
                            <div class="label-left"><p>Puesto</p></div>
                            <input type="number" name="PUESTO" style=" width: 230px;" value="{{$ultimo}}" max="999" required>
                        </div> 
                    </div>

                    <div class="col-md-5 no-pad" style=" margin-right: 65px;">
                        <div class="content-descripcion-left-input" style="margin-bottom: 2em; width: 450px;margin-right: 50px;">
                            <div class="label-left"><p>Nombre</p></div>
                            <input type="text" name="NOMBRE" style="width: 500px; text-transform:uppercase;" onkeyup="javascript:this.value=this.value.toUpperCase();" maxlength="30" required>
                        </div> 
                    </div>

                <div class="col-md-3 no-pad" style=" margin-right: 25px;">
                        <div class="content-descripcion-left-input" style="margin-bottom: 2em; ">
                            <div class="label-left"><p>Nivel</p></div>
                            <input type="number" name="NIVEL" style="width: 300px;">
                        </div> 
                    </div>

                <div class="col-md-2 no-pad" style="; margin-right: 60px; margin-left:22px; margin-top: 12px;">
                        <div class="content-descripcion-left-input" style="margin-bottom: 2em; ">
                            <div class="label-left"><p>Abreviación</p></div>
                            <input type="text" name="NPUESTO" style=" width: 240px; text-transform:uppercase;" onkeyup="javascript:this.value=this.value.toUpperCase();" maxlength="8">
                        </div> 
                    </div>
                <br> <br> <br> <br>
                <div class="col-md-2 no-pad" style=";margin-right: 50px;">
                        <div class="content-descripcion-left-input" style="margin-bottom: 2em;  ">
                            <div class="label-left"><p>Plazas Autorizadas</p></div>
                            <input type="number" name="AUTORIZADA" style=" width: 230px;">
                        </div> 
                    </div>
               
                  <div class="col-md-2 no-pad" style=";">
                        <div class="content-descripcion-left-input" style="margin-bottom: 2em; ">
                            <div class="label-left"><p>Plazas Ocupadas</p></div>
                            <input type="number" name="OCUPADAS" style=" width: 230px;" disabled="disabled" class="bloqueado">
                        </div> 
                    </div>
                  
                <div class="col-md-3 no-pad" style=";margin-right: 15px;">
                        <div class="content-descripcion-left-input" style="margin-bottom: 2em; margin-left: 25px; width: 250px;">
                            <div class="label-left"><p>Sueldo</p></div>
                            <input type="number" name="SUELDO" style=" width: 270px;">
                        </div> 
                    </div>
                
                <div class="col-md-1 no-pad" style=";">
                  <select style="width: 120px; height: 40px; border-radius: 10px; margin-left: 15px;" name="CATEGP">
                    <option>Categoria</option>
                    <option value="0">No definido</option>
                    <option value="1">Administrativo</option>
                    <option value="2">Técnico</option>
                    <option value="3">Obrero</option>
                  </select>
                </div>          
            </div>
            <button class="mediano separation">Registrar</button> 
            <a href="{{url('catalogos/puestos')}}" class="primario1">Cancelar</a>         
        </form>
      </div>    
    </div>
  </div>
  <div style="height: 15px;"></div>
  @include('includes.footer')
@endsection
