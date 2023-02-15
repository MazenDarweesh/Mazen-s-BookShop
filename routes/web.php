<?php
use App\Http\Controllers\BookController;
//imprtanattttt the following
use App\Http\Controllers\CategoryController;
//every timme to new controller
use App\Http\Controllers\LangController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\NoteController;


use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;
use Laravel\Socialite\Facades\Socialite;
use Illuminate\Support\Facades\Facade;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', function () {
    return view('welcome');
});

Route::middleware('setLang')->group(function(){
        
    Route::middleware('isLoginAdmin')->group(function(){
    
        //books:: delete
        Route::get('/books/delete/{id}',[BookController::class,'delete'])->name('books.delete');
        
        //categories:: delete
        Route::get('/categories/delete/{id}',[CategoryController::class,'delete'])->name('categories.delete');
    
    
    });
    
    
    
    //only logged in can access
    Route::middleware('isLogin')->group(function(){
       
        //book:create
        Route::get('/books/create',[BookController::class,'create'])->name('books.create');
        Route::post('/books/store',[BookController::class,'store'])->name('books.store');
        
        //book : edit for get && update for post 
        Route::get('/books/edit/{book}',[BookController::class,'edit'])->name('books.edit');
        Route::post('/books/update/{id}',[BookController::class,'update'])->name('books.update');
        
        //category:create
        Route::get('/categories/create',[CategoryController::class,'create'])->name('categories.create');
        Route::post('/categories/store',[CategoryController::class,'store'])->name('categories.store');
    
        //category : edit for get && update for post 
        Route::get('/categories/edit/{id}',[CategoryController::class,'edit'])->name('categories.edit');
        Route::post('/categories/update/{id}',[CategoryController::class,'update'])->name('categories.update');
     
        //logout
        Route::get('/logout',[AuthController::class,'logout'])->name('auth.logout');
    
        //Notes: create
        Route::get('/notes/create',[NoteController::class,'create'])->name('notes.create');
        Route::post('/notes/store', [NoteController::class,'store'])->name('notes.store');
        
    });
    
    Route::middleware('isGuest')->group(function(){
    
        //Route::get('/register' , 'AuthController@register')->name('auth.register');
        //register
        Route::get('/register',[AuthController::class,'register'])->name('auth.register');
        Route::post('/handle-register',[AuthController::class,'handleRegister'])->name('auth.handleRegister');
    
        //login
        Route::get('/login',[AuthController::class,'login'])->name('auth.login');
        Route::post('/handle-login',[AuthController::class,'handleLogin'])->name('auth.handleLogin');
    
    });
    
    //Book:Read 
    Route::get('/books',[BookController::class,'index'])->name('books.index');
    //for real time search
    Route::get('/books/search', [BookController::class,'search'])->name('books.search');
    
    Route::get('books/show/{book}',[BookController::class,'show'])->name('books.show');
    //laravel will know that id is a var and will make u use it in the controller
    
    
    //-------------------------------------------------------------------------------------------------
    
    //category:Read 
    Route::get('/categories',[CategoryController::class,'index'])->name('categories.index');
    Route::get('categories/show/{id}',[CategoryController::class,'show'])->name('categories.show');
    //laravel will know that id is a var and will make u use it in the controller
    
    
    //-------------------------------------------------------------------------------------------------
    Route::get('login/github', function () {
        return Socialite::driver('github')->redirect();
    })->name('auth.github.redirect');
     
    Route::get('login/github/callback', function () {
        $user = Socialite::driver('github')->user();
        
        //dd($user);
    
        $email = $user->email;
        $db_user = User::where('email','=',$email)->first();
    
        if($db_user == null)
        {
            if($user->name == null)
            $NewName = $user->nickname;
            $registerd_user = User::create([
                'name' => $NewName,
                'email' => $user->email,
                'password' => Hash::make('123456'),
                'oauth_token' => $user->token,
            ]);
    
            Auth::login($registerd_user);
    
        }
        else
        {
            Auth::login($db_user);
        }
        return redirect(route('books.index'));
        // $user->token
    })->name('auth.github.callback');
    
    Route::get('/lang/ar' , [LangController::class,'ar']) ->name('lang.ar');
    Route::get('/lang/en' , [LangController::class,'en']) ->name('lang.en');
    
    
    
    
});

