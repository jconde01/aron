@extends('layouts.app')
@section('body-class', 'profile-page sidebar-collapse') <!-- Paso la clase class="login-page sidebar-collapse" por medio de una seccion en el lugar que se llama body-class, en la pagina donde quiero que funcione la clase -->
@section('content')
<div class="page-header header-filter" data-parallax="true" style="background-image: url({{asset('/img/profile_city.jpg')}})">   
    
  </div>
  <div class="main main-raised" style=""> 
    <div style="">
 
      <div class="section text-center" style="">
        <h2 class="titulo">Editar Puesto</h2>
      
 
        <?php 
        foreach ($emps as $emp)
      {
        
      }

       ?>
       <?php dd($emp->NOMBRE); ?>
        
        <form method="POST" action=" {{url('/admin/products/'.$job->PUESTO.'/edit')}} " style="">
          @csrf

          <div class="row" style=""> 
              <div class="col-md-3 no-pad" style="">
                        <div class="content-descripcion-left-input" style="margin-bottom: 2em;  width: 250px;">
                            <div class="label-left"><p>Puesto</p></div>
                            <input type="text" name="PUESTO" style=" width: 230px;" value="{{$job->PUESTO}}" readonly="readonly">
                        </div> 
                    </div>

                <div class="col-md-5 no-pad" style=" margin-right: 65px;">
                        <div class="content-descripcion-left-input" style="margin-bottom: 2em; width: 450px;margin-right: 50px;">

                            <div class="label-left"><p>Nombre</p></div>
                            <input type="text" name="NOMBRE" style="width: 500px; text-transform:uppercase;" onkeyup="javascript:this.value=this.value.toUpperCase();" value="{{$job->NOMBRE}}">
                            
                        </div> 
                    </div>

               <!--  <div class="col-md-3 no-pad">
                  <p>Nombre :</p>
                    <input type="text" class="input" type="text" name="nombre" value=" {{$job->NOMBRE}} ">
                </div> -->
                

                    <div class="col-md-3 no-pad" style="margin-right: 25px;">
                        <div class="content-descripcion-left-input" style="margin-bottom: 2em; ">
                            <div class="label-left"><p>Nivel de Puestos</p></div>
                            <input type="number" name="NIVEL" style="width: 300px;" value="{{$job->NIVEL}}">
                        </div> 
                    </div>

                <!-- <div class="col-md-3 no-pad">
                  <p>Abreviación:</p>
                    <input type="text" class="input" type="text" name="NPUESTOS" value="{{$job->NPUESTO}}">
                </div> -->

                <div class="col-md-2 no-pad" style="; margin-right: 60px; margin-left:22px;">
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
                    <option value="1" <?php if($job->CATEGP=="1") echo "selected"; ?> >Administrativo</option>
                    <option value="2" <?php if($job->CATEGP=="2") echo "selected"; ?>>Técnico</option>
                    <option value="3" <?php if($job->CATEGP=="3") echo "selected"; ?>>Obrero</option>
                  </select>
                </div>
              </div> 
                <button class="mediano separation">Guardar</button> 
            <a href="{{url('admin/products')}}" class="primario1"">Cancelar</a>
               
            </div>

            
           


          
        </form>
          

      </div>
    
    </div>
  </div>

  <footer class="footer footer-default">
    <div class="container">
      <nav class="float-left">
        <ul>
          <li>
            <a href="https://www.creative-tim.com">
              Creative Tim
            </a>
          </li>
          <li>
            <a href="https://creative-tim.com/presentation">
              About Us
            </a>
          </li>
          <li>
            <a href="http://blog.creative-tim.com">
              Blog
            </a>
          </li>
          <li>
            <a href="https://www.creative-tim.com/license">
              Licenses
            </a>
          </li>
        </ul>
      </nav>
      <div class="copyright float-right">
        &copy;
        <script>
          document.write(new Date().getFullYear())
        </script>, made with <i class="material-icons">favorite</i> by
        <a href="https://www.creative-tim.com" target="_blank">Creative Tim</a> for a better web.
      </div>
    </div>
  </footer>

@endsection
