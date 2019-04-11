@extends('layouts.app')
@section('body-class', 'profile-page sidebar-collapse') 
@section('content') 
  <div class="main main-raised" style=""> 
    <div style="">
      <div class="section text-center" style="">
        <h2 class="titulo">Editar Departamento</h2>
       
        <form method="POST" action=" {{url('/catalogos/deptos/'.$depto->DEPTO.'/edit')}} " style="">
          {{ csrf_field() }}
          <div class="row">  
                    <div class="col-md-4 no-pad" style="">
                        <div class="content-descripcion-left-input" style="margin-bottom: 2em;  width: 250px;">
                            <div class="label-left"><p>Departamento</p></div>
                            <input type="number" name="DEPTO" value="{{$depto->DEPTO}}" style=" width: 230px;">
                        </div> 
                    </div>

                    <div class="col-md-4 no-pad" style=" ">
                        <div class="content-descripcion-left-input" style="margin-bottom: 2em; width: 450px;margin-right: 50px;">
                            <div class="label-left"><p>Nombre del Departamento</p></div>
                            <input type="text" name="DESCRIP" value="{{$depto->DESCRIP}}" style="width: 400px; text-transform:uppercase;" onkeyup="javascript:this.value=this.value.toUpperCase();">
                        </div> 
                    </div>

                <div class="col-md-4 no-pad" style="">
                        <div class="content-descripcion-left-input" style="margin-bottom: 2em; ">
                            <div class="label-left"><p>Nombre Corto</p></div>
                            <input type="text" name="NDEPTO" value="{{$depto->NDEPTO}}" id="nomCor" style="width: 300px;" onkeyup="javascript:this.value=this.value.toUpperCase();">
                        </div> 
                    </div>

              <div class="col-md-4 no-pad"></div>
                <div class="col-md-5 no-pad col-lg-3" id="border" style="">
                        <div class="content-descripcion-left-input"  style="margin-bottom: 2em; ">
                            <div class="label-left"><p>Depto. al que Reporta</p></div>
                            <select id="sele" style="width: 280px; height: 40px; border-radius: 10px; text-align-last: right; padding-right: 20px; margin-left: 30px;" name="NAREA">
                                <option value="">Categoria</option>
                                @foreach ($deps as $dep)
                                <option value="{{$dep->DEPTO}}" <?php if ($dep->DEPTO==$depto->NAREA) {
                                  echo 'selected="selected"';
                                } ?> >{{$dep->DESCRIP}} </option>
                                @endforeach
                            </select>
                        </div> 
                    </div>
                <br> <br> <br> <br>
            </div>
                <button class="mediano separation">Guardar</button> 
                <a href="{{url('catalogos/deptos')}}" class="primario1"">Cancelar</a>   
            </div>
        </form>   
      </div> 
    </div>
  </div>
  <div style="height: 15px;"></div>
  @include('includes.footer')
@endsection
