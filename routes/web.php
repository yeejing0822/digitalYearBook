<?php

use Illuminate\Support\Facades\Route;
use Admin\AdminController;
use User\Profile;
use User\Password;

use App\Http\Controllers\UserController; //import controller
use App\Http\Controllers\CategoriesController; //import controller
use App\Http\Controllers\ContentsController; //import controller
use App\Http\Controllers\EventsController; //import controller
use App\Http\Controllers\HomeController; 

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

//Route::get('/', function () {
//    return view('index');
//});



// User Routes
Route::prefix('user')->middleware(['auth', 'verified'])->name('user.')->group(function(){
    Route::get('/users', Profile::class)->name('profile');

});

// Admin Routes
Route::prefix('admin')->middleware(['auth', 'auth.isAdmin'])->name('admin.')->group(function() {
    Route::resource('/users', AdminController::class);
});

//Route::get('/', function () {
//    return view('index');
//});

//Category
Route::get("/categories",[CategoriesController::class, 'index']);
Route::get("/",[CategoriesController::class, 'index']);
Route::get("/categories/create",[CategoriesController::class, 'create'])->name('category-create');
Route::post("/categories/store",[CategoriesController::class, 'store'])->name('category-store');
Route::get('/categories/{id}', [CategoriesController::class, 'show'])->name('category-show');

//Content
Route::get("/contents/create/{categoryId}",[ContentsController::class, 'create'])->name('content-create');
Route::post("/contents/store",[ContentsController::class, 'store'])->name('content-store');
Route::get('/contents/{id}/', [ContentsController::class, 'show'])->name('content-show');
Route::delete('/contents/{id}', [ContentsController::class, 'destroy'])->name('content-destroy');

//Event
Route::get("/events",[EventsController::class, 'index'])->name('event-list');
Route::get("/events/create",[EventsController::class, 'create'])->name('event-create');
Route::post("/events/store",[EventsController::class, 'store'])->name('event-store');
Route::get('/events/{id}', [EventsController::class, 'show'])->name('event-show');
Route::delete('/events/{id}', [EventsController::class, 'destroy'])->name('event-destroy');

Route::get('/search', [CategoriesController::class, 'search']);

Route::view('/user/password', 'user.password')->middleware('auth');

Route::post("/addtofav",[CategoriesController::class, 'addToFav'])->name('category-addToFav');
Route::get("/favlist",[CategoriesController::class, 'favList'])->name('category-favList');
Route::get("/removefav/{id}",[CategoriesController::class, 'removeFav']);

Route::get("/notify",[EventsController::class, 'notify'])->name('event-notify');

Route::post("/eventaddtofav",[EventsController::class, 'addToFav'])->name('event-addToFav');
Route::get("/eventfavlist",[EventsController::class, 'favList'])->name('event-favList');
Route::get("/eventremovefav/{id}",[EventsController::class, 'removeFav']);

Route::get("/userfavlist",[CategoriesController::class, 'userfavList'])->name('category-userfavList');

Route::get("/sortuserfavlist",[CategoriesController::class, 'sort'])->name('category-sort');




