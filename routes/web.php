<?php

use App\Http\Controllers\ActivityController;
use App\Http\Controllers\CompanyController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ContactController;
use App\Http\Controllers\ContactNoteController;
use App\Http\Controllers\TagController;
use App\Http\Controllers\TaskController;
use App\Http\Controllers\WelcomeController;
use App\Models\Contact;

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
    // Route::get('/contacts',[ContactController::class,'index'])->name('contacts.index');
    // Route::post('/contacts',[ContactController::class,'store'])->name('contacts.store');

    // Route::get('/contacts/create', [ContactController::class,'create'])->name('contacts.create');
    // Route::get('/contacts/{id}', [ContactController::class,'show'])->name('contacts.show');

    // Route::get('/contacts/{id}/edit', [ContactController::class,'edit'])->name('contacts.edit');
    // Route::put('/contacts/{id}', [ContactController::class,'update'])->name('contacts.update');

    // Route::delete('/contacts/{id}', [ContactController::class,'destroy'])->name('contacts.destroy');

    Route::resource('/contacts', ContactController::class);
    //soft delete
    Route::delete('contacts/{contact}/restore', [ContactController::class,'restore'])->name('contacts.restore');
    Route::delete('contacts/{contact}/force-delete', [ContactController::class,'forceDelete'])->name('contacts.force-delete');
    Route::resource('/companies', CompanyController::class);


    Route::resources([
        '/tags' => TagController::class,
        '/tasks' => TaskController::class
    ]);

    Route::resource('/contacts.notes', ContactNoteController::class)->shallow();
    Route::resource('/activities', ActivityController::class)->parameters([
        'activities' => 'active'
    ]);
