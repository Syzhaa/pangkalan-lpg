<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Admin\TransactionController;

Route::middleware('auth:sanctum')->post('/check-eligibility', [TransactionController::class, 'checkEligibility']);
