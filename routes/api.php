<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ApiBookController;
use App\Http\Controllers\ApiAuthController;

// Books API 
//the model is the same as the perivious
Route::get('/books',[ApiBookController::class,'index']);

// /books/show/{id}
Route::get('books/show/{id}',[ApiBookController::class,'show']);

Route::middleware('isApiUser')->group(function(){
    
    //the original create is one for show , nd for store so here: we need only the store full CRUD in laravel has 7routes , in api is 5 remove the 2 shows of the form 
    Route::post('/books/store',[ApiBookController::class,'store']);
    //book: post for update
    Route::post('/books/update/{id}',[ApiBookController::class,'update']);
    //books:: delete
    Route::get('/books/delete/{id}',[ApiBookController::class,'delete']);
   

});

// login/register 
Route::post('/handle-register', [ApiAuthController::class,'handleRegister']);
Route::post('/handle-login', [ApiAuthController::class,'handleLogin']);
Route::post('/logout', [ApiAuthController::class,'logout']);

