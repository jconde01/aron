@extends('layouts.app')

@section('title','Listado de Opciones de Menú')
@section('body-class','')

@section('content')
<div class="container">
    <div class="row">
	        <div class="col-md-6">
	            <div class="panel panel-default">
	                <div class="panel-heading clearfix"><h5 class="pull-left">Opciones de Menú</h5></div>
	                <div class="panel-body" id="cont">
	                    <ul id="myEditor" class="sortableLists list-group">
	                    </ul>
	                </div>
	            </div>
	        </div>
	        <div class="col-md-6">
	            <div class="panel panel-primary">
	                <div class="panel-heading">Editar opción</div>
	                <div class="panel-body">
	                    <form id="frmEdit" class="form-horizontal">
	                        <div class="form-group">
	                            <label for="text" class="col-sm-2 control-label">Texto</label>
	                            <div class="col-sm-10">
	                                <div class="input-group">
	                                    <input type="text" class="form-control item-menu" name="text" id="text" placeholder="Nombre">
	                                    <div class="input-group-btn">
	                                        <button type="button" id="myEditor_icon" class="btn btn-default" data-iconset="fontawesome"></button>
	                                    </div>
	                                    <input type="hidden" name="icon" class="item-menu">
	                                </div>
	                            </div>
	                        </div>
	                        <div class="form-group">
	                            <label for="href" class="col-sm-2 control-label">URL</label>
	                            <div class="col-sm-10">
	                                <input type="text" class="form-control item-menu" id="href" name="href" placeholder="URL">
	                            </div>
	                        </div>
	                        <div class="form-group">
	                            <label for="target" class="col-sm-2 control-label">Target</label>
	                            <div class="col-sm-10">
	                                <select name="target" id="target" class="form-control item-menu">
	                                    <option value="_self">Self</option>
	                                    <option value="_blank">Blank</option>
	                                    <option value="_top">Top</option>
	                                </select>
	                            </div>
	                        </div>
	                        <div class="form-group">
	                            <label for="title" class="col-sm-2 control-label">Tooltip</label>
	                            <div class="col-sm-10">
	                                <input type="text" name="title" class="form-control item-menu" id="title" placeholder="Tooltip">
	                            </div>
	                        </div>
	                    </form>
	                </div>
	                <div class="panel-footer">
	                    <button type="button" id="btnUpdate" class="btn btn-primary" disabled><i class="fa fa-refresh"></i> Actualizar</button>
	                    <button type="button" id="btnAdd" class="btn btn-success"><i class="fa fa-plus"></i>Agregar</button>
	                </div>
	            </div>
		        <form id="main-form" method="POST" action="{{ url('admin/options') }}">
		       		<input type="hidden" name="_token" value="{{ csrf_token() }}">
		       		<input type="hidden" id="txtOptions" name="txtOptions" value="">	            
	            	<div class="text-center">
	            		<button type="submit" id="saveAll" class="btn btn-primary"><i class="fa fa-plus"></i> Guardar todo</button>
						<a type="button" class="btn btn-success" href="{{ url('/home') }}"><i class="fa fa-minus"></i> Salir</a>	
	            	</div>
    			</form>
	        </div>
    </div>
    <hr>
</div>
@endsection
@section('jscript')
    <script src="{{ asset('/js/jquery-menu-editor.js') }}"></script>
    <script src="{{ asset('/css/bs-iconpicker/js/iconset/iconset-fontawesome-4.7.0.min.js') }}"></script>
    <script src="{{ asset('/css/bs-iconpicker/js/bootstrap-iconpicker.js') }}"></script>
    <script type="text/javascript">

		$.ajaxSetup({
			headers: {
				'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
			}
		});    	
    	$(document).ready( function () {

			token = $('input[name=_token]').val();    		
	        //icon picker options
	        var iconPickerOptions = {searchText: 'Buscar...', labelHeader: '{0} de {1} Pags.'};
	        //sortable list options
	        var sortableListOptions = {
	            placeholderCss: {'background-color': 'cyan'}
	        };

	        //var editor = new MenuEditor('myEditor', {listOptions: sortableListOptions, iconPicker: iconPickerOptions, labelEdit: 'Editar'});
	        var editor = new MenuEditor('myEditor', {listOptions: sortableListOptions, iconPicker: iconPickerOptions});
	        editor.setForm($('#frmEdit'));
	        editor.setUpdateButton($('#btnUpdate'));

            $('#btnOut').on('click', function () {
                var str = editor.getString();
                $("#out").text(str);
            });

            $("#btnUpdate").click(function(){
                editor.update();
            });

            $('#btnAdd').click(function(){
                editor.add();
            });

            // Obtiene las opciones de menu 
        	$.post("get-menu-items", { _token: token }, function( data ) {
            	editor.setData(data);
    		});

    		$('#main-form').submit(function() {
				var str = editor.getString();
				document.getElementById("txtOptions").value = str;
			});
        });
	</script>
@endsection