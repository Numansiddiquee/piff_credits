<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Freelancer\InvoiceController;

Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');

 Route::post('freelancer/invoices/upload-file/email', [InvoiceController::class, 'uploadAttachment']);
