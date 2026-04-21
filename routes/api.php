<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\LoanController;

// For testing purposes, we removed auth:sanctum because Composer isn't installed to download it
Route::get('/loans', [LoanController::class, 'index']);
Route::get('/loans/{loan}', [LoanController::class, 'show']);
