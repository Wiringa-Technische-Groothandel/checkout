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
        Route::post('add', 'CartController@add')->name('add');
        Route::post('edit', 'CartController@edit')->name('edit');

        Route::delete('delete', 'CartController@delete')->name('delete');
        Route::delete('destroy', 'CartController@destroy')->name('destroy');
    });
});
