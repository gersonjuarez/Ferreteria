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

Route::group(['middleware'=>['guest']],function(){
    Route::get('/','Auth\LoginController@showLoginForm');
    Route::post('/login', 'Auth\LoginController@login')->name('login');

});

Route::group(['middleware'=>['auth']],function(){
    
    Route::post('/logout', 'Auth\LoginController@logout')->name('logout');
    
    
    Route::get('/main', function () {
        return view('contenido/contenido');
    })->name('main');


Route::group(['middleware' => ['Administrador']], function () {

/* USER */
    Route::get('/user', 'UserController@index');
Route::get('/user/deshabilitado', 'UserController@indexdeshabilitado');
Route::post('/user/registrar', 'UserController@store');
Route::put('/user/actualizar', 'UserController@update');
Route::put('/user/desactivar', 'UserController@desactivar');
Route::put('/user/activar', 'UserController@activar');

/* ROL */
Route::get('/rol', 'RolController@index');
Route::get('/rol/selectRol', 'RolController@selectRol');
Route::post('/rol/registrar', 'RolController@store');
Route::put('/rol/actualizar', 'RolController@update');
Route::put('/rol/desactivar', 'RolController@desactivar');
Route::put('/rol/activar', 'RolController@activar');

/* PROVEEDOR */
Route::get('/proveedor', 'ProveedorController@index');
Route::put('/proveedor/actualizar', 'ProveedorController@update');
Route::post('/proveedor/registrar', 'ProveedorController@store');
Route::get('/proveedor/selectProveedor', 'ProveedorController@selectProveedor');
Route::put('/proveedor/desactivar', 'ProveedorController@desactivar');
Route::put('/proveedor/activar', 'ProveedorController@activar');
Route::get('/proveedor/deshabilitado', 'ProveedorController@indexdeshabilitado');

Route::post('/enviar/email', 'CorreoController@send');


/* CLIENTE */
Route::get('/cliente', 'ClienteController@index');
Route::get('/cliente/deshabilitado', 'ClienteController@indexdeshabilitado');
Route::get('/cliente/selectcliente', 'ClienteController@selectcliente');
Route::post('/cliente/registrar', 'ClienteController@store');
Route::put('/cliente/actualizar', 'ClienteController@update');
Route::put('/cliente/desactivar', 'ClienteController@desactivar');
Route::put('/cliente/activar', 'ClienteController@activar');

/* GRAFICAS */
Route::get('/grafica', 'GraficaController');
Route::get('/grafica/ventas', 'GraficaVentasController');

/* Reporte */
Route::get('/compra/total/{fecha_inicial_c}/{fecha_final_c}', 'IngresoController@totalcompras');
Route::get('/venta/total/{fecha_inicial_v}/{fecha_final_v}', 'VentaController@totalventas');
Route::get('/venta/recibo','VentaController@recibo');


/* CATEGORIAS */
/* listar */
Route::get('/categoria', 'CategoriaController@index');
Route::post('/categoria/registrar', 'CategoriaController@store');
Route::put('/categoria/actualizar', 'CategoriaController@update');
Route::put('/categoria/desactivar', 'CategoriaController@desactivar');
Route::put('/categoria/activar', 'CategoriaController@activar');

/* PRESENTACION */
/* listar */
Route::get('/presentacion', 'PresentacionController@index');
Route::post('/presentacion/registrar', 'PresentacionController@store');
Route::put('/presentacion/actualizar', 'PresentacionController@update');
Route::put('/presentacion/desactivar', 'PresentacionController@desactivar');
Route::put('/presentacion/activar', 'PresentacionController@activar');


/* PORDUCTOS */
Route::post('/producto/registrar', 'ProductoController@store');
Route::get('/lista/producto', 'ProductoController@index');
Route::get('/lista/producto/deshabilitado', 'ProductoController@indexdeshabilitado');
Route::get('/lista/producto/busqueda', 'ProductoController@busquedaTodo');
Route::put('/producto/actualizar', 'ProductoController@update');
Route::put('/producto/desactivar', 'ProductoController@desactivar');
Route::put('/producto/activar', 'ProductoController@activar');
Route::get('/producto/listarPdf','ProductoController@listarPdf');


/* VENTA */
Route::get('/venta', 'VentaController@index');
Route::post('/venta/registrar', 'VentaController@store');
Route::put('/venta/desactivar', 'VentaController@desactivar');
Route::get('/venta/obtenerCabecera', 'VentaController@obtenerCabecera');
Route::get('/venta/obtenerDetalles', 'VentaController@obtenerDetalles');


/* INGRESO */
Route::post('/ingreso/registrar', 'IngresoController@store');
Route::get('/ingreso', 'IngresoController@index');
Route::get('/ingreso/obtenerDetalles', 'IngresoController@obtenerDetalles');



Route::group(['middleware' => ['Vendedor']], function () {

/* VENTAS */
Route::get('/venta', 'VentaController@index');
Route::post('/venta/registrar', 'VentaController@store');
Route::put('/venta/desactivar', 'VentaController@desactivar');
Route::get('/venta/obtenerCabecera', 'VentaController@obtenerCabecera');
Route::get('/venta/obtenerDetalles', 'VentaController@obtenerDetalles');


/* PORDUCTOS */
Route::post('/producto/registrar', 'ProductoController@store');
Route::get('/lista/producto', 'ProductoController@index');
Route::get('/lista/producto/deshabilitado', 'ProductoController@indexdeshabilitado');
Route::get('/lista/producto/busqueda', 'ProductoController@busquedaTodo');
Route::put('/producto/actualizar', 'ProductoController@update');
Route::put('/producto/desactivar', 'ProductoController@desactivar');
Route::put('/producto/activar', 'ProductoController@activar');
Route::get('/producto/listarPdf','ProductoController@listarPdf');


/* CATEGORIAS */
/* listar */
Route::get('/categoria', 'CategoriaController@index');
Route::post('/categoria/registrar', 'CategoriaController@store');
Route::put('/categoria/actualizar', 'CategoriaController@update');
Route::put('/categoria/desactivar', 'CategoriaController@desactivar');
Route::put('/categoria/activar', 'CategoriaController@activar');

/* PRESENTACION */
/* listar */
Route::get('/presentacion', 'PresentacionController@index');
Route::post('/presentacion/registrar', 'PresentacionController@store');
Route::put('/presentacion/actualizar', 'PresentacionController@update');
Route::put('/presentacion/desactivar', 'PresentacionController@desactivar');
Route::put('/presentacion/activar', 'PresentacionController@activar');


/* CLIENTE */
Route::get('/cliente', 'ClienteController@index');
Route::get('/cliente/deshabilitado', 'ClienteController@indexdeshabilitado');
Route::get('/cliente/selectcliente', 'ClienteController@selectcliente');
Route::post('/cliente/registrar', 'ClienteController@store');
Route::put('/cliente/actualizar', 'ClienteController@update');
Route::put('/cliente/desactivar', 'ClienteController@desactivar');
Route::put('/cliente/activar', 'ClienteController@activar');

});



});
});

