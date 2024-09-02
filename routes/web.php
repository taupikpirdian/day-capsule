<?php

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Response;
use App\Http\Controllers\LandingController;
use App\Http\Controllers\admin\RoleController;
use App\Http\Controllers\admin\UserController;
use App\Http\Controllers\admin\LapduController;
use App\Http\Controllers\admin\MonevController;
use App\Http\Controllers\admin\SaldoController;
use App\Http\Controllers\Auth\LogoutController;
use App\Http\Controllers\admin\ReportController;
use App\Http\Controllers\admin\EksekusiController;
use App\Http\Controllers\admin\DashboardController;
use App\Http\Controllers\admin\PenuntutanController;
use App\Http\Controllers\admin\PenyidikanController;
use App\Http\Controllers\admin\PermissionController;
use App\Http\Controllers\admin\PenyelidikanController;

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
Auth::routes();

Route::controller(LandingController::class)
        ->group(function() {
            Route::get('/', 'index')->name('landing');
        });

Route::group(['middleware' => ['auth']], function() {
    Route::controller(LogoutController::class)
        ->group(function() {
            Route::get('/logout', 'perform')->name('logout.perform');
        });

    Route::controller(DashboardController::class)
        ->group(function() {
            Route::group(['middleware' => ['auth']], function() {
                Route::get('/dashboard','index');
                Route::post('/dashboard-overview','overview')->name('dashboard.overview');
            });
        });

    Route::controller(PermissionController::class)
        ->group(function() {
            Route::group(['middleware' => ['auth']], function() {
                Route::get('/permissions','index');
            });
        });

    Route::group(['middleware' => ['roleCheck:admin,kejari,kejati']], function() {
        /**
         * role
         */
        Route::resource('roles', RoleController::class);
        /**
         * user
         */
        Route::resource('users', UserController::class);
        Route::post('users/datatable', [UserController::class, 'datatable'])->name('users.datatable');
        /**
         * profile
         */
        Route::get('profile', [UserController::class, 'profile'])->name('users.profile.index');
        Route::post('profile/{id}', [UserController::class, 'profileUpdate'])->name('users.profile');
        /**
         * lapdu
         */
        Route::resource('lapdu', LapduController::class);
        Route::post('lapdu/datatable', [LapduController::class, 'datatable'])->name('lapdu.datatable');
        Route::post('lapdu/update-status/{id}', [LapduController::class, 'updateStatus'])->name('lapdu.update-status');
        /**
         * saldo
         */
        Route::get('saldo', [SaldoController::class, 'index'])->name('saldo.index');
        Route::post('saldo/update', [SaldoController::class, 'update'])->name('saldo.update');

        /**
          * penyelidikan
          */
        Route::resource('penyelidikan', PenyelidikanController::class);
        Route::post('penyelidikan/datatable', [PenyelidikanController::class, 'datatable'])->name('penyelidikan.datatable');

        /**
         * penyidikan
         */
        Route::resource('penyidikan', PenyidikanController::class);
        Route::post('penyidikan/datatable', [PenyidikanController::class, 'datatable'])->name('penyidikan.datatable');

        /**
         * penuntutan
         */
        Route::resource('penuntutan', PenuntutanController::class);
        Route::post('penuntutan/datatable', [PenuntutanController::class, 'datatable'])->name('penuntutan.datatable');

        /**
         * eksekusi
         */
        Route::resource('eksekusi', EksekusiController::class);
        Route::post('eksekusi/datatable', [EksekusiController::class, 'datatable'])->name('eksekusi.datatable');

        /**
         * report
         */
        Route::get('report', [ReportController::class, 'index']);

        /**
         * monev
         */
        Route::get('monev', [MonevController::class, 'index']);
        Route::get('monev-export', [MonevController::class, 'export'])->name('monev.export');
    });
});

Route::get('file/{storage}/{uuid}/{filename}', function ($storage, $uuid, $filename) {
    $path = storage_path('app/public/' . $storage . '/' . $uuid . '/' . $filename);
    if (!File::exists($path)) {
        abort(404);
    }

    $file = File::get($path);
    $type = File::mimeType($path);
    $response = Response::make($file, 200);
    $response->header("Content-Type", $type);
    return $response;
})->name('file.show');