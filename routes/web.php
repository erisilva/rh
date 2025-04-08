<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\PermissionController;
use App\Http\Controllers\RoleController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\LogController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\MotivoController;
use App\Http\Controllers\SituacaoController;
use App\Http\Controllers\PedidoController;
use App\Http\Controllers\FormController;



# about page
Route::get('/about', function () {
    return view('about.about');
})->name('about')->middleware('auth');

Route::get('/', function () {
    #if the user is logged return index view, if not logged return login view
    if (Auth::check()) {
        return view('index');
    } else {
        return view('auth.login');
    }
});

Auth::routes(['verify' => false, 'register' => false]);

Route::get('/profile', [ProfileController::class, 'show'])->name('profile')->middleware('auth');
Route::post('/profile/update/password', [ProfileController::class, 'updatePassword'])->name('profile.password.update')->middleware('auth');
Route::post('/profile/update/theme', [ProfileController::class, 'updateTheme'])->name('profile.theme.update')->middleware('auth');

Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');

# Permission::class

Route::get('/permissions/export/csv', [PermissionController::class, 'exportcsv'])->name('permissions.export.csv')->middleware('auth'); // Export CSV

Route::get('/permissions/export/pdf', [PermissionController::class, 'exportpdf'])->name('permissions.export.pdf')->middleware('auth'); // Export PDF

Route::resource('/permissions', PermissionController::class)->middleware('auth');

# Role::class

Route::get('/roles/export/csv', [RoleController::class, 'exportcsv'])->name('roles.export.csv')->middleware('auth'); // Export CSV

Route::get('/roles/export/pdf', [RoleController::class, 'exportpdf'])->name('roles.export.pdf')->middleware('auth'); // Export PDF

Route::resource('/roles', RoleController::class)->middleware('auth');

# User::class

Route::get('/users/export/csv', [UserController::class, 'exportcsv'])->name('users.export.csv')->middleware('auth'); // Export CSV

Route::get('/users/export/pdf', [UserController::class, 'exportpdf'])->name('users.export.pdf')->middleware('auth'); // Export PDF

Route::resource('/users', UserController::class)->middleware('auth');

# Log::class

Route::resource('/logs', LogController::class)->middleware('auth')->only('show', 'index');

# Motivo::class

Route::get('/motivos/export/csv', [MotivoController::class, 'exportcsv'])->name('motivos.export.csv')->middleware('auth'); // Export CSV

Route::get('/motivos/export/pdf', [MotivoController::class, 'exportpdf'])->name('motivos.export.pdf')->middleware('auth'); // Export PDF

Route::resource('/motivos', MotivoController::class)->middleware('auth');

# Situacao::class

Route::get('/situacaos/export/csv', [SituacaoController::class, 'exportcsv'])->name('situacaos.export.csv')->middleware('auth'); // Export CSV

Route::get('/situacaos/export/pdf', [SituacaoController::class, 'exportpdf'])->name('situacaos.export.pdf')->middleware('auth'); // Export PDF

Route::resource('/situacaos', SituacaoController::class)->middleware('auth');

# Pedido::class

Route::get('/pedidos/export/csv', [PedidoController::class, 'exportcsv'])->name('pedidos.export.csv')->middleware('auth'); // Export CSV

Route::get('/pedidos/export/pdf', [PedidoController::class, 'exportpdf'])->name('pedidos.export.pdf')->middleware('auth'); // Export PDF

Route::resource('/pedidos', PedidoController::class)->middleware('auth');


Route::resource('/forms', FormController::class)->only('index', 'show', 'create', 'store');
