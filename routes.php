<?php

Route::get('/api/v1/auth/login', function () {
    $user = \RainLab\User\Models\User::find(1);

    $token = $user->createToken('Test token')->accessToken;

    return [
        'token' => $token,
    ];
});

Route::get('/passport/test-route', function () {
    return 'You are successfully viewing a protected resource! Well done!';
})->middleware('auth:api');