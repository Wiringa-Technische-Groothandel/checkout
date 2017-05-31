<?php

Route::group([
    'middleware' => ['web', 'auth'],
    'namespace' => 'WTG\Checkout\Controllers',
    'prefix' => 'checkout',
    'as' => 'checkout::'
], function() {
    Route::group([
        'prefix' => 'cart',
        'as' => 'cart.'
    ], function () {
        Route::get('/', 'CartController@view')->name('index');

        Route::put('add', 'CartController@add')->name('add');

        Route::patch('update/{item}', 'CartController@update')->name('update'); // Edit a single update

        Route::delete('delete/{item}', 'CartController@delete')->name('delete');
        Route::delete('destroy', 'CartController@destroy')->name('destroy');
    });
});
