<?php

use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\GestionAluminiosController;
use App\Http\Controllers\GestionHerrajesController;
use App\Http\Controllers\GestionVidriosController;
use App\Http\Controllers\AdministradorController;
use App\Http\Controllers\ColaboradorController;
use App\Http\Controllers\CatalogoController;
use App\Http\Controllers\CotizadorVentanasController;
use App\Http\Controllers\ControladorLiquidar;
use App\Http\Controllers\InventarioController;
use App\Http\Controllers\VentasController;
use App\Http\Middleware\CheckRole;
use App\Http\Controllers\CotizadorProductosController;
use App\Http\Controllers\ProductosGestionAdminController;
use App\Notifications\Inventario;
use Illuminate\Support\Facades\Auth;
use App\Notifications\NuevaVenta;

Route::get('/', function () {
    return view('welcome');
});

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

////////////////////////////////////////////////////////////////////////////////////////// CLIENTE

Route::get('/aluvid/inicio', function () {
    return view('inicio');
})->name('inicio');

Route::get('/aluvid/ficha/tecnica', function () {
    return view('ficha_tecnica');
})->name('ficha_tecnica');

Route::get('/aluvid/liquidar', [ControladorLiquidar::class, 'liquidar'])->name('liquidar');
Route::post('/aluvid/liquidar/procesar', [ControladorLiquidar::class, 'liquidar_procesar'])->name('liquidar_procesar');
Route::get('/aluvid/nota/{id}', [ControladorLiquidar::class, 'generarPDF'])->name('ventas.pdf');

Route::get('/aluvid/cotizador/ventanas', [CotizadorVentanasController::class, 'inicio'])->name('cotizador_ventanas');
Route::post('/cotizador/generar-pdf', [CotizadorProductosController::class, 'generarCotizacionPDF'])->name('cotizador_ventas');

Route::get('/aluvid/catalogo/aluminios', [CatalogoController::class, 'catalogo_aluminios'])->name('catalogo_aluminios');
Route::get('/catalogo-aluminios/filtrar', [CatalogoController::class, 'filtrarProductosAluminio']);
Route::get('/aluvid/aluminios/ficha/tecnica/{id}', [CatalogoController::class, 'ficha_tecnica_aluminios'])->name('ficha_tecnica_aluminios');

Route::get('/aluvid/catalogo/vidrios', [CatalogoController::class, 'catalogo_vidrios'])->name('catalogo_vidrios');
Route::get('/catalogo-vidrios/filtrar', [CatalogoController::class, 'filtrarProductosVidrios']);
Route::get('/aluvid/vidrios/ficha/tecnica/{id}', [CatalogoController::class, 'ficha_tecnica_vidrios'])->name('ficha_tecnica_vidrios');

Route::get('/aluvid/catalogo/herrajes', [CatalogoController::class, 'catalogo_herrajes'])->name('catalogo_herrajes');
Route::get('/catalogo-herrajes/filtrar', [CatalogoController::class, 'filtrarProductosHerrajes']);
Route::get('/aluvid/herrajes/ficha/tecnica/{id}', [CatalogoController::class, 'ficha_tecnica_herrajes'])->name('ficha_tecnica_herrajes');

////////////////////////////////////////////////////////////////////////////////////////// ADMINISTRADOR

Route::post('/notificaciones/{id}/leer', function ($id) {
    $user = Auth::user();

    // Buscar notificación NO leída del tipo NuevaVenta
    $notificacion = $user->unreadNotifications
        ->filter(fn($n) => $n->type === NuevaVenta::class)
        ->firstWhere('id', $id);

    if ($notificacion) {
        $notificacion->markAsRead();

        return response()->json([
            'success' => true,
            'remaining' => $user->unreadNotifications
                ->filter(fn($n) => $n->type === NuevaVenta::class)
                ->count(),
        ]);
    }

    return response()->json(['success' => false], 404);
})->middleware(['auth'])->name('notificacion.leer');


Route::get('/admin/inicio', [AdministradorController::class, 'inicio'])
    ->middleware(['auth', CheckRole::class . ':Administrador'])
    ->name('admin_inicio');

// Gestión de usuarios
Route::middleware(['auth', CheckRole::class . ':Administrador'])->group(function () {
    Route::get('/usuarios', [AdministradorController::class, 'usuarios'])->name('usuarios');
    Route::post('/usuarios/update', [AdministradorController::class, 'usuarios_update'])->name('usuarios_update');
});

// Gestión de productos: Vidrios
Route::middleware(['auth', CheckRole::class . ':Administrador'])->group(function () {
    Route::get('/vidrio', [GestionVidriosController::class, 'vidrio_productos'])->name('vidrio');
    Route::post('/vidrio/add', [GestionVidriosController::class, 'vidrio_add_product'])->name('vidrio_add_product');
    Route::post('/vidrio/update', [GestionVidriosController::class, 'vidrio_update_product'])->name('vidrio_update_product');
    Route::delete('/vidrio/delete/{id}', [GestionVidriosController::class, 'vidrio_delete_product'])->name('vidrio_delete_product');
    Route::post('/vidrio/stock', [GestionVidriosController::class, 'vidrio_stock_product'])->name('vidrio_stock_product');
    Route::get('/descargar-inventario-vidrio-admin', [InventarioController::class, 'inventario_vidrio'])->name('descargar.inventario.vidrio.admin');
    Route::get('/gestion/vidrio', [ProductosGestionAdminController::class, 'gestion_vidrio_admin_show'])->name('gestion_vidrio_admin_show');
    Route::post('/gestion/vidrio/create/tonalidad', [ProductosGestionAdminController::class, 'gestion_vidrio_admin_create_tonalidad'])->name('gestion_vidrio_admin_create_tonalidad');
    Route::post('/gestion/vidrio/update/tonalidad/{id}', [ProductosGestionAdminController::class, 'gestion_vidrio_admin_update_tonalidad'])->name('gestion_vidrio_admin_update_tonalidad');
    Route::delete('/gestion/vidrio/delete/tonalidad/{id}', [ProductosGestionAdminController::class, 'gestion_vidrio_admin_delete_tonalidad'])->name('gestion_vidrio_admin_delete_tonalidad');
    Route::post('/gestion/vidrio/create/mm', [ProductosGestionAdminController::class, 'gestion_vidrio_admin_create_mm'])->name('gestion_vidrio_admin_create_mm');
    Route::delete('/gestion/vidrio/delete/mm/{id}', [ProductosGestionAdminController::class, 'gestion_vidrio_admin_delete_mm'])->name('gestion_vidrio_admin_delete_mm');
});

// Gestión de productos: Aluminios
Route::middleware(['auth', CheckRole::class . ':Administrador'])->group(function () {
    Route::get('/aluminio', [GestionAluminiosController::class, 'aluminio_productos'])->name('aluminio');
    Route::post('/aluminio/add', [GestionAluminiosController::class, 'aluminio_add_product'])->name('aluminio_add_product');
    Route::post('/aluminio/update', [GestionAluminiosController::class, 'aluminio_update_product'])->name('aluminio_update_product');
    Route::delete('/aluminio/delete/{id}', [GestionAluminiosController::class, 'aluminio_delete_product'])->name('aluminio_delete_product');
    Route::post('/aluminio/stock', [GestionAluminiosController::class, 'aluminio_stock_product'])->name('aluminio_stock_product');
    Route::get('/descargar-inventario-aluminio-admin', [InventarioController::class, 'inventario_aluminio'])->name('descargar.inventario.aluminio.admin');
    Route::get('/gestion/aluminio', [ProductosGestionAdminController::class, 'gestion_aluminio_admin_show'])->name('gestion_aluminio_admin_show');
    Route::post('/gestion/aluminio/create/serie', [ProductosGestionAdminController::class, 'gestion_aluminio_admin_create_serie'])->name('gestion_aluminio_admin_create_serie');
    Route::post('/gestion/aluminio/update/serie/{id}', [ProductosGestionAdminController::class, 'gestion_aluminio_admin_update_serie'])->name('gestion_aluminio_admin_update_serie');
    Route::delete('/gestion/aluminio/delete/serie/{id}', [ProductosGestionAdminController::class, 'gestion_aluminio_admin_delete_serie'])->name('gestion_aluminio_admin_delete_serie');
    Route::post('/gestion/aluminio/create/linea', [ProductosGestionAdminController::class, 'gestion_aluminio_admin_create_linea'])->name('gestion_aluminio_admin_create_linea');
    Route::delete('/gestion/aluminio/delete/linea/{id}', [ProductosGestionAdminController::class, 'gestion_aluminio_admin_delete_linea'])->name('gestion_aluminio_admin_delete_linea');
});

// Gestión de productos: Herrajes
Route::middleware(['auth', CheckRole::class . ':Administrador'])->group(function () {
    Route::get('/herrajes', [GestionHerrajesController::class, 'herrajes_productos'])->name('herrajes');
    Route::post('/herrajes/add', [GestionHerrajesController::class, 'herrajes_add_product'])->name('herrajes_add_product');
    Route::post('/herrajes/update', [GestionHerrajesController::class, 'herrajes_update_product'])->name('herrajes_update_product');
    Route::delete('/herrajes/delete/{id}', [GestionHerrajesController::class, 'herrajes_delete_product'])->name('herrajes_delete_product');
    Route::post('/herrajes/stock', [GestionHerrajesController::class, 'herrajes_stock_product'])->name('herrajes_stock_product');
    Route::get('/descargar-inventario-herrajes-admin', [InventarioController::class, 'inventario_herrajes'])->name('descargar.inventario.herrajes.admin');
    Route::get('/gestion/herrajes', [ProductosGestionAdminController::class, 'gestion_herrajes_admin_show'])->name('gestion_herrajes_admin_show');
    Route::post('/gestion/herrajes/create/serie', [ProductosGestionAdminController::class, 'gestion_herrajes_admin_create_serie'])->name('gestion_herrajes_admin_create_serie');
    Route::post('/gestion/herrajes/update/serie/{id}', [ProductosGestionAdminController::class, 'gestion_herrajes_admin_update_serie'])->name('gestion_herrajes_admin_update_serie');
    Route::delete('/gestion/herrajes/delete/serie/{id}', [ProductosGestionAdminController::class, 'gestion_herrajes_admin_delete_serie'])->name('gestion_herrajes_admin_delete_serie');
    Route::post('/gestion/herrajes/create/linea', [ProductosGestionAdminController::class, 'gestion_herrajes_admin_create_linea'])->name('gestion_herrajes_admin_create_linea');
    Route::delete('/gestion/herrajes/delete/linea/{id}', [ProductosGestionAdminController::class, 'gestion_herrajes_admin_delete_linea'])->name('gestion_herrajes_admin_delete_linea');
});

// Ventas
Route::middleware(['auth', CheckRole::class . ':Administrador'])->group(function () {
    Route::get('/ventas', [VentasController::class, 'ventas'])->name('ventas');
    Route::post('/ventas/update/{id}', [VentasController::class, 'ventas_update'])->name('ventas_update');
    Route::delete('/venta/delete/{id}', [VentasController::class, 'venta_delete'])->name('venta_delete');
    Route::post('/reporte/ventas', [VentasController::class, 'generar'])->name('reporte.ventas');
    Route::get('/reporte/venta/update/{id}', [VentasController::class, 'reporte_venta_update'])->name('reporte_venta_update');
    Route::get('/api/ventas/estadisticas', [VentasController::class, 'estadisticas'])->name('ventas.estadisticas');
});

////////////////////////////////////////////////////////////////////////////////////////// COLABORADOR

Route::post('/notificaciones/inventario/{id}/leer', function ($id) {
    $user = Auth::user();

    // Buscar notificación NO leída del tipo Inventario
    $notificacion = $user->unreadNotifications
        ->filter(fn($n) => $n->type === Inventario::class)
        ->firstWhere('id', $id);

    if ($notificacion) {
        $notificacion->markAsRead();

        return response()->json([
            'success' => true,
            'remaining' => $user->unreadNotifications
                ->filter(fn($n) => $n->type === Inventario::class)
                ->count(),
        ]);
    }

    return response()->json(['success' => false], 404);
})->middleware(['auth'])->name('notificacion.inventario.leer');

// Gestión de productos: Vidrios
Route::middleware(['auth', CheckRole::class . ':Colaborador'])->group(function () {
    Route::get('/consulta/vidrio', [ColaboradorController::class, 'consulta_vidrio'])->name('consulta_vidrio');
    Route::get('/descargar-inventario-vidrio', [InventarioController::class, 'inventario_vidrio'])->name('descargar.inventario.vidrio');
});

// Gestión de productos: Aluminios
Route::middleware(['auth', CheckRole::class . ':Colaborador'])->group(function () {
    Route::get('/consulta/aluminio', [ColaboradorController::class, 'consulta_aluminio'])->name('consulta_aluminio');
    Route::get('/descargar-inventario-aluminio', [InventarioController::class, 'inventario_aluminio'])->name('descargar.inventario.aluminio');
});

// Gestión de productos: Herrajes
Route::middleware(['auth', CheckRole::class . ':Colaborador'])->group(function () {
    Route::get('/consulta/herrajes', [ColaboradorController::class, 'consulta_herrajes'])->name('consulta_herrajes');
    Route::get('/descargar-inventario-herrajes', [InventarioController::class, 'inventario_herrajes'])->name('descargar.inventario.herrajes');
});

// Ventas
Route::middleware(['auth', CheckRole::class . ':Colaborador'])->group(function () {
    Route::get('/consulta/ventas', [ColaboradorController::class, 'consulta_ventas'])->name('consulta_ventas');
});

Route::get('/colab/inicio', [ColaboradorController::class, 'inicio'])
    ->middleware(['auth', CheckRole::class . ':Colaborador'])
    ->name('colab_inicio');

require __DIR__ . '/auth.php';
