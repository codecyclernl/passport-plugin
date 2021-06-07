<?php

Route::get('/passport/test-route', function () {
    return 'You are successfully viewing a protected resource! Well done!';
})->middleware('auth:api');