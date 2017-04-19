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
        Route::put('add', 'CartController@add')->name('add');
        Route::patch('update/{item}', 'CartController@update')->name('update'); // Edit a single update
        Route::patch('edit', 'CartController@edit')->name('edit'); // Edit the whole cart

        Route::delete('delete/{item}', 'CartController@delete')->name('delete');
        Route::delete('destroy', 'CartController@destroy')->name('destroy');
    });
});
