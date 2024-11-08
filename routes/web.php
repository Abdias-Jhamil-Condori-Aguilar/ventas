<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\Auth\ForgotPasswordController;
use App\Http\Controllers\Auth\ResetPasswordController;
use App\Http\Controllers\LoginController;
use App\Http\Controllers\LogoutController;
use App\Http\Controllers\ClienteController;
use App\Http\Controllers\CategoriaController;
use App\Http\Controllers\ArticuloController;
use App\Http\Controllers\BoletaController;
use App\Http\Controllers\CategoriaProductoController;
use App\Http\Controllers\ConfiguracionController;
use App\Http\Controllers\InteresController;
use App\Http\Controllers\PagoController;
use App\Http\Controllers\PrendaController;
use App\Http\Controllers\PrestamoController;
use App\Http\Controllers\ReporteController;
use App\Http\Controllers\RoleController;
use App\Http\Controllers\TipoDocumentoController;
use App\Http\Controllers\TipoPagoController;
use App\Http\Controllers\UserController;

Route::get('/', [HomeController::class, 'index'])->name('panel');

### Autenticación
Route::get('login', [LoginController::class, 'index'])->name('login');
Route::post('login', [LoginController::class, 'login']);
Route::get('logout', [LogoutController::class, 'logout'])->name('logout');

Route::get('forgot-password', [ForgotPasswordController::class, 'showLinkRequestForm'])->name('password.request');
Route::post('forgot-password', [ForgotPasswordController::class, 'sendResetLinkEmail'])->name('password.email');
Route::get('reset-password/{token}', [ResetPasswordController::class, 'showResetForm'])->name('password.reset');
Route::post('reset-password', [ResetPasswordController::class, 'reset'])->name('password.update');

### Configuración
Route::get('/configuracion', [ConfiguracionController::class, 'index'])->name('configuracion.index');

### Recursos
Route::resource('categoria_productos', CategoriaProductoController::class);
Route::resource('clientes', ClienteController::class);
Route::resource('prendas', PrendaController::class);
Route::resource('tipo_pagos', TipoPagoController::class);
Route::resource('tipo_documentos', TipoDocumentoController::class);
Route::resource('intereses', InteresController::class);
Route::resource('users', UserController::class);
Route::resource('roles', RoleController::class);
Route::resource('reportes', ReporteController::class);
Route::resource('prestamos', PrestamoController::class);
Route::delete('/pagos/{id}/eliminar', [PagoController::class, 'eliminarPago'])->name('pagos.eliminar');

### Préstamos
Route::get('prestamos/create/{cliente_id}', [PrestamoController::class, 'create'])->name('prestamos.create.withCliente');
Route::post('/pagos/abonar/{prestamo}', [PagoController::class, 'abonar'])->name('pagos.abonar');
Route::post('/pagos/liquidar/{prestamo}', [PagoController::class, 'liquidar'])->name('pagos.liquidar');
Route::get('/pagos', [PagoController::class, 'index'])->name('pagos.index');

Route::patch('/prestamos/{prestamo}/cancelar', [PrestamoController::class, 'cancelar'])->name('prestamos.cancelar');
Route::get('prestamos/generarBoleta/{id}', [PrestamoController::class, 'generarBoleta'])->name('prestamos.generarBoleta');
Route::get('prestamos/boletaliquidado/{id}', [PrestamoController::class, 'Boletaliquidado'])->name('prestamo.boletaLiquidado');

### Reportes Generales
Route::get('/reporte/clientes', [ReporteController::class, 'clientes'])->name('reporte.clientes');
Route::get('reportes/clientespdf', [ReporteController::class, 'exportarPDF'])->name('reportes.clientespdf');
Route::get('reportes/reporte', [PrestamoController::class, 'reporte'])->name('prestamos.reporte');
Route::get('reporte/exportar-pdf', [PrestamoController::class, 'exportarPDF'])->name('prestamos.pdf');
Route::get('/reporte/exportar-flujo-caja-pdf', [ReporteController::class, 'exportarFlujoCajaPDF']);
Route::get('/reporte/exportar-pdf', [ReporteController::class, 'exportarMontoPrestadoPDF'])->name('reporte.exportarMontoPrestadoPDF');
Route::get('/reporte/exportar-pagos-pdf', [ReporteController::class, 'exportarPagosPdf'])->name('reporte.exportarPagosPdf');


Route::get('/reporte/flujo-de-caja', [ReporteController::class, 'flujoDeCaja'])->name('reporte.flujocaja');
Route::get('/reporte/obtener-flujo-caja', [ReporteController::class, 'ObtenerFlujoCaja'])->name('reporte.obtenerflujocaja');
Route::get('/reporte/monto-prestado', [ReporteController::class, 'montoPrestado'])->name('reporte.montoPrestado');
Route::get('/reporte/obtener-prestamos', [ReporteController::class, 'obtenerPrestamos']);
Route::get('/reporte/calendario', [ReporteController::class, 'mostrarCalendario'])->name('reporte.calendario');
Route::get('/reporte/datos-calendario', [ReporteController::class, 'obtenerDatosCalendario'])->name('reporte.datosCalendario');
Route::get('/reporte/monto-pagado', [ReporteController::class, 'montoPagado'])->name('reporte.montoPagado');
Route::get('/reporte/obtener-pagos', [ReporteController::class, 'obtenerPagos'])->name('reporte.obtenerPagos');
### Reportes Específicos de Préstamos
Route::get('/reporte/prestamos-activos', [ReporteController::class, 'prestamosActivos'])->name('reporte.prestamos.activos');
Route::get('/prestamos-por-vencer', [ReporteController::class, 'prestamosPorVencer'])->name('prestamos.por_vencer');
Route::get('/prestamos-vencidos', [ReporteController::class, 'prestamosVencidos'])->name('prestamos.vencidos');

### Otros Reportes
Route::get('/cumpleanieros', [ReporteController::class, 'cumpleanierosMes'])->name('cumpleanieros.mes');

### API Routes
Route::get('/api/ultimo-codigo-prenda', [PrestamoController::class, 'getUltimoCodigoPrenda']);

### Páginas de Error
Route::get('/401', function () {
    return view('pages.401');
});

Route::get('/404', function () {
    return view('pages.404');
});

Route::get('/500', function () {
    return view('pages.500');
});
