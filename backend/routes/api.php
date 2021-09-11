<?php

use App\Http\Controllers\EmployeeController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::group([
    'prefix' => 'employees',
    'as' => 'employees.',
], function () {
    Route::get('/', [EmployeeController::class, 'index'])->name('index');
    Route::delete('{employee}', [EmployeeController::class, 'delete'])->name('delete');
}

);
