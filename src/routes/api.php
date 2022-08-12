<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\api\v1\log\LogController;

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


Route::prefix('v1')->group(function () {
    // Authentication Routes
    include __DIR__ . '/v1/auth_routes.php';

    include __DIR__ . '/v1/form_routes.php';


    Route::middleware('auth:sanctum')->get('/analytics',[LogController::class, 'logs'])->name('logs');

});
