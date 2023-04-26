<?php

use App\Http\Controllers\ActivityController;
use App\Http\Controllers\CompanyController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ContactController;
use App\Http\Controllers\ContactNoteController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\Settings\PasswordController;
use App\Http\Controllers\Settings\ProfileController;
use App\Http\Controllers\TagController;
use App\Http\Controllers\TaskController;
use App\Http\Controllers\WelcomeController;
use App\Models\Contact;
use App\Models\User;

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


    Route::get('/',WelcomeController::class);
    Route::middleware(['auth','verified'])->group( function (){
        Route::get('/dashboard',DashboardController::class);
        Route::get('/settings/profile-information', ProfileController::class)->name('user-profile-information.edit');
        Route::get('/settings/password', PasswordController::class)->name('user-password.edit');

        //soft delete contacts
        Route::resource('/contacts', ContactController::class);
        Route::delete('contacts/{contact}/restore', [ContactController::class,'restore'])
            ->name('contacts.restore')
            ->withTrashed();
        Route::delete('contacts/{contact}/force-delete', [ContactController::class,'forceDelete'])
            ->name('contacts.force-delete')
            ->withTrashed();

        //soft delete companies
        Route::resource('/companies', CompanyController::class);
        Route::delete('companies/{company}/restore', [CompanyController::class,'restore'])
        ->name('companies.restore')
        ->withTrashed();
    Route::delete('companies/{company}/force-delete', [CompanyController::class,'forceDelete'])
        ->name('companies.force-delete')
        ->withTrashed();

        Route::resources([
            '/tags' => TagController::class,
            '/tasks' => TaskController::class
        ]);

        Route::resource('/contacts.notes', ContactNoteController::class)->shallow();
        Route::resource('/activities', ActivityController::class)->parameters([
            'activities' => 'active'
        ]);
    });

    //eager loading multiple
    Route::get('/count-models', function () {
        // $users = User::select(['name', 'email'])->withCount([
        //     'contacts as contacts_number',
        //     'companies as companies_count_end_with_gmail' => function ($query) {
        //         $query->where('email', 'like', '%@gmail.com');
        //     }
        // ])->get();

        // foreach ($users as $user) {
        //     echo $user->name . "<br />";
        //     echo $user->companies_count_end_with_gmail . " companies<br />";
        //     echo $user->contacts_number . " contacts<br />";
        //     echo "<br />";
        // }
        $users = User::get();
        $users->loadCount(['companies' => function ($query) {
            $query->where('email', 'like', '%@gmail.com');
        }]);
        foreach ($users as $user) {
            echo $user->name . "<br />";
            echo $user->companies_count . " companies<br />";
            echo "<br />";
        }
    });
