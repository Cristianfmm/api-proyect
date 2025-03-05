<?php
// routes/api.php
use App\Http\Controllers\ProductController;

Route::apiResource('productos', ProductController::class);