<?php

use App\Http\Controllers\ActivityController;
use App\Http\Controllers\CompanyController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ContactController;
use App\Http\Controllers\ContactNoteController;
use App\Http\Controllers\TagController;
use App\Http\Controllers\TaskController;
use App\Http\Controllers\WelcomeController;


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

// Catatan
// Route Controller Group
// Route::controller(ContactController::class)->name('.contacts')->group( function() {
//     Route::get('/contacts', 'index')->name('index');
//     Route::get('/contacts/create','create')->name('create');
//     Route::get('/contacts/{id}','show')->name('show');
// });


Route::get('/',WelcomeController::class);
    Route::get('/contacts',[ContactController::class,'index'])->name('contacts.index');
    Route::post('/contacts',[ContactController::class,'store'])->name('contacts.store');
    Route::get('/contacts/create', [ContactController::class,'create'])->name('contacts.create');
    Route::get('/contacts/{id}', [ContactController::class,'show'])->name('contacts.show');

    Route::resource('/companies', CompanyController::class);

    Route::resource('/companies', CompanyController::class);

    Route::resources    ([
        '/tags' => TagController::class,
        '/tasks' => TaskController::class
    ]);

    Route::resource('/activities', ActivityController::class)->parameters([
        'activities' => 'active'
    ]);


    Route::resource('/contacts.notes', ContactNoteController::class)->shallow();
