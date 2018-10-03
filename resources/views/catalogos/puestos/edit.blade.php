@extends('layouts.app')
@section('body-class', 'profile-page sidebar-collapse')
@section('content')
  <div class="main main-raised" style=""> 
    <div style=""> 
      <div class="section text-center" style="">
        <h2 class="titulo">Editar Puesto</h2> 
        <?php 
        foreach ($jobs as $job)
      {       
      }
       ?>      
        <form method="POST" action=" {{url('/catalogos/puestos/'.$job->PUESTO.'/edit')}} " style="">
          {{ csrf_field() }}
          <div class="row" style=""> 
              <div class="col-md-3 no-pad" style="">
                        <div class="content-descripcion-left-input" style="margin-bottom: 2em;  width: 250px;">
                            <div class="label-left"><p>Puesto</p></div>
                            <input type="text" name="PUESTO" style=" width: 230px;" value="{{$job->PUESTO}}" readonly="readonly" class="bloqueado">
                        </div> 
                    </div>

                <div class="col-md-5 no-pad" style=" margin-right: 65px;">
                        <div class="content-descripcion-left-input" style="margin-bottom: 2em; width: 450px;margin-right: 50px;">
                            <div class="label-left"><p>Nombre</p></div>
                            <input type="text" name="NOMBRE" style="width: 500px; text-transform:uppercase;" onkeyup="javascript:this.value=this.value.toUpperCase();" value="{{$job->NOMBRE}}">                         
                        </div> 
                    </div>

                    <div class="col-md-3 no-pad" style="margin-right: 25px;">
                        <div class="content-descripcion-left-input" style="margin-bottom: 2em; ">
                            <div class="label-left"><p>Nivel de Puestos</p></div>
                            <input type="number" name="NIVEL" style="width: 300px;" value="{{$job->NIVEL}}">
                        </div> 
                    </div>

                <div class="col-md-2 no-pad" style="; margin-right: 60px; margin-left:22px; margin-top: 12px;">
                        <div class="content-descripcion-left-input" style="margin-bottom: 2em; ">
                            <div class="label-left"><p>Abreviación</p></div>
                            <input type="text" name="NPUESTO" style=" width: 240px; text-transform:uppercase;" onkeyup="javascript:this.value=this.value.toUpperCase();" value="{{$job->NPUESTO}}">
                        </div> 
                    </div>
                <br> <br> <br> <br>

                <div class="col-md-2 no-pad" style=";margin-right: 50px;">
                        <div class="content-descripcion-left-input" style="margin-bottom: 2em;  ">
                            <div class="label-left"><p>Plazas Autorizadas</p></div>
                            <input type="number" name="AUTORIZADA" style=" width: 230px;" value="{{$job->AUTORIZADA}}">
                        </div> 
                    </div>
                    
                <div class="col-md-2 no-pad" style=";">
                        <div class="content-descripcion-left-input" style="margin-bottom: 2em; ">
                            <div class="label-left"><p>Plazas Ocupadas</p></div>
                            <input type="number" name="OCUPADAS" style=" width: 230px;" value="{{$job->OCUPADAS}}">
                        </div> 
                    </div>

                <div class="col-md-3 no-pad" style=";margin-right: 15px;">
                        <div class="content-descripcion-left-input" style="margin-bottom: 2em; margin-left: 25px; width: 250px;">
                            <div class="label-left"><p>Sueldo</p></div>
                            <input type="number" name="SUELDO" style=" width: 270px;" value="{{$job->SUELDO}}">
                        </div> 
                    </div>

                <div class="col-md-1 no-pad" style=";">
                  <select style="width: 120px; height: 40px; border-radius: 10px; margin-left: 15px;" name="CATEGP" value=" {{$job->CATEGP}} " >
                    <option>Categoria</option>
                    <option value="1" <?php if($job->CATEGP=="0") echo "selected"; ?> >No definido</option>
                    <option value="1" <?php if($job->CATEGP=="1") echo "selected"; ?> >Administrativo</option>
                    <option value="2" <?php if($job->CATEGP=="2") echo "selected"; ?>>Técnico</option>
                    <option value="3" <?php if($job->CATEGP=="3") echo "selected"; ?>>Obrero</option>
                  </select>
                </div>
              </div> 
                <button class="mediano separation">Guardar</button> 
            <a href="{{url('catalogos/puestos')}}" class="primario1"">Cancelar</a>             
            </div>      
        </form>
      </div>    
    </div>
  </div>
  <div style="height: 15px;"></div>
  @include('includes.footer')
@endsection
