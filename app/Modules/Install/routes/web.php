<?php

use App\Modules\Install\Controller\InstallController;
use Illuminate\Support\Facades\Route;


 Route::group(['middleware' => 'installer'], function () {

    Route::get("/install",[InstallController::class,"index"])->name('install');
    Route::post("/install",[InstallController::class,"check"])->name('install');

 });

