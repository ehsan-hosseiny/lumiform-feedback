<?php

use Illuminate\Support\Facades\Route;

use App\Http\Controllers\api\v1\form\FormController;




Route::middleware('auth:sanctum')->group(function (){
    Route::group(['prefix' => 'form'], function () {
        Route::post('/',[FormController::class, 'create'])->name('form-create');
        Route::get('/{id}',[FormController::class, 'getForm'])->name('get-form');
    });
    Route::post('/questionnaire',[FormController::class, 'saveForm'])->name('save-form');
});
