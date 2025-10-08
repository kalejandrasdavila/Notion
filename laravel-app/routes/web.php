
<?php

use App\Http\Controllers\SolicitudController;
use App\Http\Controllers\Api\NotionController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::get('/', [SolicitudController::class, 'index'])->name('solicitud.index');

// Rutas para el formulario de solicitud
Route::prefix('solicitud')->name('solicitud.')->group(function () {
    Route::get('/', [SolicitudController::class, 'index'])->name('index');
    Route::post('/', [SolicitudController::class, 'store'])->name('store');
    Route::get('/list', [SolicitudController::class, 'list'])->name('list');
    Route::get('/{solicitud}', [SolicitudController::class, 'show'])->name('show');
});

// Rutas para obtener opciones de los selects
Route::prefix('api/options')->name('api.options.')->group(function () {
    Route::get('/status', [SolicitudController::class, 'getOptions'])->name('status');
    Route::get('/tipo', [SolicitudController::class, 'getOptions'])->name('tipo');
    Route::get('/prioridad', [SolicitudController::class, 'getOptions'])->name('prioridad');
    Route::get('/medio', [SolicitudController::class, 'getOptions'])->name('medio');
});

// Rutas de API para Notion
Route::prefix('api/notion')->name('api.notion.')->group(function () {
    Route::get('/database', [NotionController::class, 'getDatabase'])->name('database');
    Route::get('/status', [NotionController::class, 'getStatus'])->name('status');
    Route::get('/tipo', [NotionController::class, 'getTipo'])->name('tipo');
    Route::get('/prioridad', [NotionController::class, 'getPrioridad'])->name('prioridad');
    Route::get('/medio', [NotionController::class, 'getMedio'])->name('medio');
    Route::post('/page', [NotionController::class, 'createPage'])->name('create-page');
    Route::post('/upload', [NotionController::class, 'uploadFile'])->name('upload-file');
});