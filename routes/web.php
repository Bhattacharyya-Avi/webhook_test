<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\backend\ProjectController;
use App\Http\Controllers\backend\PackageController;
use App\Http\Controllers\backend\DashboardController;

Route::get('/',[DashboardController::class,'index'])->name('home');

Route::prefix('package')->controller(PackageController::class)->group(function(){
    Route::get('/','index')->name('package.index');
    Route::post('/store','store')->name('package.store');
    Route::put('/{packageId}/update','update')->name('package.update');
    Route::get('/{packageId}/delete','delete')->name('package.delete');
});

Route::prefix('project')->controller(ProjectController::class)->group(function(){
    Route::get('/','index')->name('project.index');
    Route::get('/generateToken','generateToken')->name('project.generateToken');
    Route::post('/store','store')->name('project.store');
    Route::put('/{projectId}/update','update')->name('project.update');
    Route::get('/{projectId}/delete','delete')->name('project.delete');
    Route::get('/{projectId}/sync/config','syncConfig')->name('project.sync.config');
});

