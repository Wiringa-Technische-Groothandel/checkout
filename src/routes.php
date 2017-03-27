<?php

Route::group([
    'middleware' => ['web', 'auth'],
    'namespace' => 'WTG\Checkout\Controllers',
    'as' => 'checkout::'
], function()
{
    Route::group([
        'prefix' => 'cart',
        'as' => 'cart.'
    ], function () {
        Route::put('add', 'CartController@add')->name('add');
        Route::patch('edit', 'CartController@edit')->name('edit');
        Route::delete('delete', 'CartController@delete')->name('delete');
        Route::delete('destroy', 'CartController@destroy')->name('destroy');
    });
});
