<?php

use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return response()->json([
        'status' => 'online',
        'message' => 'EduLink Hub Backend API is running successfully!',
        'database' => 'connected',
        'version' => '1.0.0'
    ]);
});
