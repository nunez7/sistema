<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\EmpleadoController;
use Illuminate\Support\Facades\Auth;
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
    return view('auth.login');
});

/*Route::get('/empleado', function () {
    return view('empleado.index');
});*/
//da acceso a solo esa vista
//Route::get('empleado/create', [EmpleadoController::class, 'create']);
//da acceso a todas las rutas
Route::resource('empleado', EmpleadoController::class)->middleware('auth');
Auth::routes(['register'=>false, 'reset'=>false]);
//Si el usuario teclea home lo redirecciona EmpleadoController
Route::get('/home', [EmpleadoController::class, 'index'])->name('home');

//Añadimos los roles para cuando se logie el usuario
Route::group(['middleware' => 'auth'], function(){
    //redireccionamos a la view principal, en este caso el croud y el metodo index
    Route::get('/', [EmpleadoController::class, 'index'])->name('home');
});