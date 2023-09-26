<?php

use Illuminate\Support\Facades\Route;
//agregar controladores
use App\Http\Controllers\HomeController;
use App\Http\Controllers\RolController;
use App\Http\Controllers\UsuarioController;
use App\Http\Controllers\BlogController;
use App\Http\Controllers\BiografiaController;
use App\Http\Controllers\ReunionsController;
use App\Http\Controllers\CursoController;
use App\Http\Controllers\BancoController;
use App\Http\Controllers\NotificacionesController;
use App\Http\Controllers\ReportesController;
use App\Http\Controllers\ConfiguracionController;
use App\Http\Controllers\ChatController;
use App\Http\Controllers\ContactoController;
/* use App\Http\Controllers\CalendarioController; */
use App\Http\Controllers\EventoController;
use App\Http\Controllers\AuditoriaController;
use App\Http\Controllers\DetallesController;
use App\Http\Controllers\PersonaController;
use App\Http\Controllers\PeriodoController;
use App\Http\Controllers\EstudianteController;
use App\Http\Controllers\PagoController;
use App\Http\Controllers\PasarelaController;
use App\Http\Controllers\PaymentController;
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

Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');

Auth::routes();

Route::post('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');



Route::group(['middleware' => ['auth']], function(){
    Route::resource('roles', RolController::class);
    Route::resource('usuarios', UsuarioController::class);
    Route::resource('blogs', BlogController::class);
    Route::resource('curso', CursoController::class);
    Route::resource('biografias', BiografiaController::class);
    Route::resource('reunions', ReunionsController::class);
    Route::resource('bancos', BancoController::class);
    Route::resource('notificaciones', NotificacionesController::class);
    Route::resource('reportes', ReportesController::class);
    Route::resource('configuracion', ConfiguracionController::class);
    Route::resource('chats', ChatController::class);
    Route::resource('calendary', CalendaryController::class);
    Route::resource('auditoria', AuditoriaController::class);
    Route::resource('persona', PersonaController::class);
    Route::resource('detalles', DetallesController::class);
    Route::resource('periodos', PeriodoController::class);
    Route::resource('estudiante', EstudianteController::class);
    Route::resource('pagos', PagoController::class);
    Route::resource('pasarelas', PasarelaController::class);
    Route::resource('evento', EventoController::class);
    Route::get('/payment', [PaymentController::class, 'showPaymentPage']);

    Route::post('/pasarelas/getDataStudent', [PasarelaController::class, 'getDataStudent'])->name('pasarelas.getDataStudent');
    Route::post('/pasarelas/getInvoice', [PasarelaController::class, 'getInvoice'])->name('pasarelas.getInvoice');


});

Route::patch('/usuarios/{id}', 'UsuarioController@update')->name('usuarios.update');

Route::get('/api/latest-blog', [BlogController::class, 'getLatestBlog']);

Route::get('/evento', [App\Http\Controllers\EventoController::class, 'index']);


// routes/web.php
Route::group(['middleware' => ['role:Estudiante']], function () {
    // Rutas que requieren el rol Estudiante
});

Route::post('/pagos/get-events', [PagoController::class, 'getEvents'])->name('pagos.getEvents');
Route::post('/pagos/get-nombres', [PagoController::class, 'getNombres'])->name('pagos.getNombres');

Route::post('/pagos/get-cursos', [PagoController::class, 'getCursos'])->name('pagos.getCursos');

Route::post('/pagos/obtener-cuota', [PagoController::class, 'obtenerCuota'])->name('pagos.obtenerCuota');
Route::post('/verificar-estudiante', 'PagoController@verificarEstudiante')->name('verificarEstudiante');


Route::post('periodos/{id}/toggle', 'App\Http\Controllers\PeriodoController@toggle')->name('periodos.toggle');

Route::post('/biografias/like/{biografia}', [BiografiaController::class, 'like'])->name('biografias.like');



Route::post('/buscar-estudiante', 'PagoController@verificarEstudiante')->name('pagos.buscarEstudiante');


Route::post('/reportes/filtrar', 'App\Http\Controllers\ReportesController@filtrarPagos')->name('reportes.filtrar');



Route::post('/reportes/get-events', [ReportesController::class, 'getEvents'])->name('reportes.getEvents');
Route::post('/get-eventos', [ReportesController::class, 'getEventosPorCursoYPeriodo'])->name('reportes.getEventosPorCursoYPeriodo');
// routes/web.php

Route::post('/reportes/obtenerCuotaEvento', 'NombreDelControlador@metodoObtenerCuotaEvento')->name('reportes.obtenerCuotaEvento');
Route::post('/reportes/buscar', [ReportesController::class, 'buscar'])->name('reportes.buscar');



Route::get('/pasarelas/{blog_id}', 'PasarelasController@index')->name('pasarelas.index');
Route::get('/pasarela/{blog}', 'PasarelaController@show')->name('pasarela.show');

Route::post('/consultar_estudiante', 'PagoController@consultarEstudiante');

Route::post('/guardar-fecha', [ConfiguracionController::class, 'guardarFecha'])->name('guardarFecha');


Route::post('biografias/like/{biografia}', [BiografiaController::class, 'like'])->name('biografias.like');
Route::get('/generar-recibo/{pago}', [PagoController::class, 'generarRecibo'])->name('generar-recibo');

Route::post('/consultarEstudiante', [PagoController::class, 'consultarEstudiante'])->name('consultarEstudiante');


Route::get('/contacto', [ContactoController::class, 'index'])->name('contacto.index');


Route::post('/verificar-estado', [PagoController::class, 'verificarEstado'])->name('verificarEstado');

Route::post('/store', [BlogController::class, 'store'])->name('store');


Route::post('/obtenerUltimaDiferencia', 'PagoController@obtenerUltimaDiferencia')->name('obtenerUltimaDiferencia');


Route::post('/cambiar-contrasena', [UsuarioController::class, 'cambiarContrasena'])->name('cambiar-contrasena');

/* Route::get('/cursos', 'CursoController@index')->name('cursos.index'); */
Route::put('/cursos/{curso}', [CursoController::class, 'update'])->name('cursos.update');
Route::get('/cursos', 'CursoController@index')->name('cursos.index');
Route::get('/cursos', [CursoController::class, 'index'])->name('cursos.index');
