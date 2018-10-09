    @extends('layouts.app')

@section('title','Modificar Célula')
@section('body-class','')

@section('content')
<div class="main main-raised">
    <div class="container">
        <div class="section">
            <h2 class="title text-center">Modificar Célula</h2>
          <br>
            <form method="post" action="{{ url('/admin/celulas/'.$celula->id.'/edit') }}">
                <input type="hidden" name="_token" value="{{ csrf_token() }}">

                <div class="col-sm-4" style="">
                    <div class="form-group content-descripcion-left-input">
                        <label class="label-left">id</label>
                        <input type="text" name="id" value=" {{$celula->id}} " class="bloqueado" readonly>
                    </div>
                </div>

                <div class="col-sm-8" style="margin-bottom: 5px;">
                        <div class="form-group content-descripcion-left-input">
                            <label class="label-left" style="font-size: 14px;">Nombre de la Célula</label>
                            <input type="text" name="nombre" value=" {{$celula->nombre}} " >
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
