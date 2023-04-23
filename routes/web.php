<?php  
 
use Illuminate\Support\Facades\Route; 

use App\Http\Controllers\UserController;
Route::resource('users', UserController::class);

use App\Http\Controllers\ListingController;
Route::resource('listings', ListingController::class);  
 
// Show Register/Create Form
Route::get('/register', [UserController::class, 'create'])->middleware('guest');

Route::post('/logout', [UserController::class, 'logout']) ;
// Show Login Form
Route::get('/login', [UserController::class, 'login'])->name('login')->middleware('guest');

// Log In User
Route::post('/users/authenticate', [UserController::class, 'authenticate']);

// manage listings
// Route::get('/listings/manage', [ListingController::class, 'manage'])->middleware('auth');
 
Route::view('/listings/create', 'listings.create')->middleware('auth'); 
 

// Show Edit Form
Route::get('/listings/{listing}/edit',
[ListingController::class, 'edit'])->middleware('auth');

//  update listing
Route::put('/listings/{listing}',[ListingController::class,
'update'])->middleware('auth');  

// show Create form 
Route::get('/listings/create', [ListingController::class, 'create'])->middleware('auth');
  

Route::view('/', 'index'); 
 //

 Route::middleware('auth')->group(function () {
    Route::get('/listings/{listing}/edit', 'ListingController@edit')->name('listings.edit');
    Route::put('/listings/{listing}', 'ListingController@update')->name('listings.update');
});
?>
