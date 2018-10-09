    @extends('layouts.app')
@section('body-class', 'profile-page sidebar-collapse') 
@section('content') 
  </div>
  <div class="main main-raised">
    <div>
      <div class="section text-center">
        <h2 class="titulo">Registrar Nuevo Departamento</h2>
        <br>
        <form method="POST" action=" {{url('/catalogos/deptos')}} ">
         {{ csrf_field() }}

          <div class="row"> 
                      
                    <div class="col-md-4 no-pad" style="">
                        <div class="content-descripcion-left-input" style="margin-bottom: 2em;  width: 250px;">
                            <div class="label-left"><p>Departamento</p></div>
                            <input type="number" name="DEPTO" max="999" step="0.01" minlength="1" value="{{$ultimo}}"  style=" width: 230px;" required>
                        </div> 
                    </div>

                    <div class="col-md-4 no-pad" style="">
                        <div class="content-descripcion-left-input" style="margin-bottom: 2em; width: 450px;margin-right: 50px;">
                            <div class="label-left"><p>Nombre del Departamento</p></div>
                            <input type="text" name="DESCRIP" maxlength="40" style="width: 400px; text-transform:uppercase;" onkeyup="javascript:this.value=this.value.toUpperCase();" required>
                        </div> 
                    </div>

                
                    <div class="col-md-4 no-pad" style="">
                        <div class="content-descripcion-left-input" style="margin-bottom: 2em; ">
                            <div class="label-left"><p>Nombre Corto</p></div>
                            <input type="text" name="NDEPTO" maxlength="8" id="nomCor" style="width: 300px;" onkeyup="javascript:this.value=this.value.toUpperCase();">
                        </div> 
                    </div>

             <div class="col-md-4 no-pad col-lg-4"></div>
                    <div class="col-md-5 no-pad col-lg-3" id="border" style="">
                        <div class="content-descripcion-left-input" style="margin-bottom: 2em; ">
                            <div class="label-left"><p>Depto. al que Reporta</p></div>
                            <select id="sele" style="width: 280px; height: 40px; border-radius: 10px; text-align-last: right; padding-right: 0px; margin-left: 30px;" name="NAREA">
                                <option active>Categoria</option>
                                @foreach ($deps as $dep)
                                <option value="{{$dep->DEPTO}}">{{$dep->DESCRIP}}</option>
                                @endforeach
                            </select>
                        </div> 
                    </div>
                <br> <br> <br> <br>
            </div>
            <button class="mediano separation">Registrar</button> 
            <a href="{{url('catalogos/deptos')}}" class="primario1">Cancelar</a>   
        </form>
      </div>
    </div>
  </div>
  <div style="height: 15px;"></div>
  @include('includes.footer')
@endsection
