<?php

/**
 * Auth
 */
Route::group(['namespace' => 'Auth'], function () {
    Route::post('login', 'LoginController@login')->name('login');
    Route::post('singup', 'RegisterController@singUp')->name('singUp');
    Route::get('logout', 'LogoutController@logout')->name('logout');
    Route::get('users/verify/{token}', 'ConfirmEmailController@verify')->name('verify');
    Route::get('users/{user}/resend', 'ConfirmEmailController@resend')->name('resend');

    Route::group(['prefix' => 'password'], function () {
        Route::post('create', 'PasswordResetController@create')->name('password.reset.create');
        Route::get('find/{token}', 'PasswordResetController@find')->name('password.reset.find');
        Route::post('reset', 'PasswordResetController@reset')->name('password.reset');
    });
});

Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});
