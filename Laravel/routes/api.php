<?php

use Illuminate\Support\Facades\Route;

Route::group(['as' => 'user.', 'prefix' => '/user'], function(){
    Route::get('/', [App\Http\Controllers\Api\User\Index::class, 'index'])->name('index');
    Route::get('/{user_id}', [App\Http\Controllers\Api\User\Get::class, 'user'])->name('get');
    Route::delete('/{user_id}', [App\Http\Controllers\Api\User\Delete::class, 'delete'])->name('delete');
    Route::put('/{user_id}', [App\Http\Controllers\Api\User\Update::class, 'update'])->name('update');
    Route::post('/create', [App\Http\Controllers\Api\User\Create::class, 'create'])->name('create');
});

Route::group(['as' => 'address.', 'prefix' => '/addresses'], function(){
    Route::get('/', [App\Http\Controllers\Api\Address\Index::class, 'index'])->name('index');
    Route::get('/{address_id}', [App\Http\Controllers\Api\Address\Get::class, 'get'])->name('get');
});

Route::group(['as' => 'state.', 'prefix' => '/states'], function(){
    Route::get('/', [App\Http\Controllers\Api\State\Index::class, 'index'])->name('index');
    Route::get('/{state_id}', [App\Http\Controllers\Api\State\Get::class, 'get'])->name('get');
});

Route::group(['as' => 'cities.', 'prefix' => '/cities'], function(){
    Route::get('/', [App\Http\Controllers\Api\City\Index::class, 'index'])->name('index');
    Route::get('/{city_id}', [App\Http\Controllers\Api\City\Get::class, 'get'])->name('get');
});
