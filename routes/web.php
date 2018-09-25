<?php

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', function () {
    return view('welcome');
});

Auth::routes();

//Route::post('/sistema/get-procesos/{cia}','AppController@getProcesos');
// Route::post('/sistema/get-procesos/{cia}', function () {
// 	dd($cia);
// });


//Route::post('/sistema/prueba3','AppController@getProcesos');

// Rutas para las opciones que NO son del menu asociado al perfil ( o sea, que TODOS puedem accesar)
Route::middleware(['auth'])->group(function () {
	Route::get('/home', 'HomeController@index')->name('home');
	//Route::post('/home','HomeController@getProcesos')->name('home');
	Route::get('/messages/create', 'MessagesController@create');
	Route::post('/messages/store', 'MessagesController@store')->name('messages.store');
	Route::get('/messages/{id}', 'MessagesController@show')->name('messages.show');
	Route::get('/notificaciones','NotificationsController@index');
	Route::patch('/notificaciones/leida/{id}','NotificationsController@read');
});


// Rutas para establecer la BD Asociada (compañia TISANOM) y el proceso
Route::middleware(['auth'])->prefix('sistema')->group(function () {
	//Route::get('/chooseClienteYNomina', 'AppController@index');	
	Route::get('/chooseTipoYProceso', 'AppController@index');	
	Route::post('/get-procesos','AppController@getProcesos');					// Ajax call
	//Route::post('/testProcesos/{tipo}','AppController@testProcesos');
	Route::post('/set-session-data','HomeController@setSessionData');
});

// Rutas para los catálogos
Route::middleware(['auth','basic'])->prefix('catalogos')->group(function () {
	Route::get('/deptos', 'DeptosController@index');
	Route::get('/deptos/create', 'DeptosController@create');
	Route::post('/deptos', 'DeptosController@store');
	Route::get('/deptos/{dep}/edit', 'DeptosController@edit');
	Route::post('/deptos/{dep}/edit', 'DeptosController@update');

	Route::get('/puestos', 'PuestosController@index'); //listado
	Route::get('/puestos/create', 'PuestosController@create'); //crear productos
	Route::post('/puestos', 'PuestosController@store');
	//rutas para actulizar la info puestos
	Route::get('/puestos/{PUESTO}/edit', 'PuestosController@edit'); //formulario de edicion
	Route::post('/puestos/{PUESTO}/edit', 'PuestosController@update');//actulizarl	

	// Route::get('/empleados', 'EmployeeController@index');							// lista de empleados
	// Route::get('/empleados/create','EmployeeController@create');					// Alta de nuevos empleados
	// Route::post('/empleados','EmployeeControllerr@store');							// guardar nuevo empleado
	Route::get('/empleados', 'EmpleadosController@index');
	Route::get('/empleados/create', 'EmpleadosController@create');
	Route::post('/empleados', 'EmpleadosController@store');	
	Route::get('/empleados/{EMP}/edit', 'EmpleadosController@edit');
	Route::post('/empleados/{EMP}/edit', 'EmpleadosController@update');
	Route::post('/empleados/getSalarioIntegrado','EmpleadosController@getSalarioIntegrado');
	Route::post('/empleados/getDatosEmpleado','EmpleadosController@getDatosEmpleado');


});

// Rutas para Utilerías
Route::middleware(['auth'])->prefix('utilerias')->group(function () {
	Route::get('/leerxls','UtileriasController@leerXls');
	Route::post('/leerxls','UtileriasController@getData');
	Route::get('/viewXls','UtileriasController@view');
});


// Rutas para Procesos
Route::middleware(['auth'])->prefix('procesos')->group(function () {
	Route::get('/nomina','ProcessController@nomina');
	Route::post('/nomina','ProcessController@requestNomina');
	Route::get('/firmaDigital','ProcessController@generaFirma');
	Route::get('/getPDFText','ProcessController@getPDFText');
});


// Rutas para transacciones
Route::middleware(['auth'])->prefix('transacciones')->group(function () {
	Route::get('/porConcepto','XActsController@porConcepto')->name('porConcepto');
	Route::post('/porConcepto','XActsController@storeMovtos');
	Route::get('/porIncapacidad','XActsController@porIncapacidad')->name('porIncapacidad');
	Route::post('/porIncapacidad','XActsController@storeIncapacidad');	
	//Route::get('/get-movtos','XActsController@buscaMovtos');
	Route::post('/get-movtos','XActsController@buscaMovtos');					// Ajax call
	Route::post('/get-concepto','XActsController@getConcepto');					// Ajax call
});

// Rutas para opciones del menú del Administrador 
Route::middleware(['auth','admin'])->prefix('admin')->group(function () {

	Route::get('/giros','GirosController@index');								// listado de giros	
	Route::get('/giros/create','GirosController@create');						// forma para crear nuevo giro
	Route::post('/giros','GirosController@store');								// guardar nuevo giro
	Route::get('/giros/{id}/edit','GirosController@edit');						// forma para editar giro
	Route::post('/giros/{id}/edit','GirosController@update');					// guardar cambios del giro

	Route::get('/empresas','CompanyController@index');							// listado de Empresas
	Route::get('/empresas/create','CompanyController@create');					// forma para crear nueva empresa
	Route::post('/empresas','CompanyController@store');							// guardar nueva empresa
	Route::get('/empresas/{id}/edit','CompanyController@edit');					// forma para editar empresa
	Route::post('/empresas/{id}/edit','CompanyController@update');				// guardar cambios de la empresa

	Route::get('/empresas/{id}/files','CompanyFileController@index');			// archivos de la empresa
	Route::post('/empresas/{id}/files','CompanyFileController@store');			// guardar archivo subido
	Route::delete('/empresas/{id}/files','CompanyFileController@destroy');		// eliminar archivo subido


	Route::get('/clientes','ClientController@index');							// listado de clientes
	Route::get('/clientes/create','ClientController@create');					// forma para crear nuevo cliente
	Route::post('/clientes','ClientController@store');							// guardar nuevo cliente
	Route::get('/clientes/{id}/edit','ClientController@edit');					// forma para editar cliente
	Route::post('/clientes/{id}/edit','ClientController@update');				// guardar cambios del cliente
	Route::post('/clientes/get-empresas-by-giro','CompanyController@getByGiro');// Ajax call

	Route::get('/usuarios','UserController@index');								// listado de Usuarios
	Route::get('/usuarios/create','UserController@create');						// forma para ASIGNAR un usuario a una empresa
	Route::post('/usuarios','UserController@store');							// guardar usuario
	Route::get('/usuarios/{id}/edit','UserController@edit');					// forma para editar usuario
	Route::post('/usuarios/{id}/edit','UserController@update');					// guardar cambios del usuario

	Route::get('/opciones/{parent}','OptionController@index');					// listado de opciones de menú
	//Route::get('/opciones/create','OptionController@create');					// Forma para crear Nueva opción
	Route::get('/opciones/create/{parent}','OptionController@create');			// Forma para crear Nueva opción hija
	Route::post('/opciones','OptionController@store');							// guarda una nueva opción
	Route::post('/opciones/{parent}','OptionController@store');					// guarda nueva opcion hija
	Route::delete('/opciones/{id}','OptionController@destroy');					// eliminar opcion de menú
	Route::get('/opciones/{id}/edit','OptionController@edit');					// forma para editar opcion
	Route::post('/opciones/{id}/edit','OptionController@update');				// guardar cambios de opción

	Route::get('/perfiles','ProfileController@index');							// listado de perfiles	
	Route::get('/perfiles/create','ProfileController@create');					// forma para crear nuevo perfil
	Route::post('/perfiles','ProfileController@store');							// guardar nuevo perfil
	Route::get('/perfiles/{id}/edit','ProfileController@edit');					// forma para editar perfil
	Route::post('/perfiles/{id}/edit','ProfileController@update');				// guardar cambios del perfil
});

// Rutas para consultas
Route::middleware(['auth'])->prefix('consultas')->group(function () {
	Route::get('/recibos','ConsultasController@index');
	Route::get('/recibos/{id}/consulta','ConsultasController@consulta');
	Route::get('/contratos','ConsultasController@indexContrato');
	Route::get('/contratos/{id}/consulta','ConsultasController@consultaContrato');
	Route::get('/timbrado','TimbradoController@index');
	Route::get('/timbrado/firma','TimbradoController@firma');

});


// Rutas para tickets
Route::middleware(['auth'])->prefix('tickets')->group(function () {
	Route::get('/usuarios','ticketsController@index');
	Route::get('/usuarios/create','ticketsController@create');
	Route::post('/usuarios','ticketsController@store');
	Route::get('/usuarios/{folio}/cancel','ticketsController@cancel');
	Route::get('/sistema','ticketsController@tickets');
	Route::get('/sistema/{folio}/atender','ticketsController@atender');
	Route::get('/sistema/aceptado','ticketsController@aceptado');
	Route::get('/sistema/{folio}/seguimiento','ticketsController@seguimiento');
	Route::post('/sistema/aceptado','ticketsController@update');
	Route::get('/sistema/consultar','ticketsController@consultar');
	Route::get('/sistema/{folio}/ver','ticketsController@ver');
});


