<?php

use App\Livewire\Settings\Appearance;
use App\Livewire\Settings\Password;
use App\Livewire\Settings\Profile;
use App\Livewire\Settings\TwoFactor;
use Illuminate\Support\Facades\Route;
use Laravel\Fortify\Features;

use App\Http\Controllers\Auth\CustomLoginController;


Route::redirect('/', '/auth/login');

// Authentication routes with /auth prefix
Route::prefix('auth')->group(function () {
    Route::get('/login', [CustomLoginController::class, 'showLoginForm'])->name('login');
    Route::post('/custom/login', [CustomLoginController::class, 'login'])->name('custom.login');
    Route::post('/logout', [CustomLoginController::class, 'logout'])->name('logout');

    // Password reset routes (optional)
    Route::get('/forgot-password', function () {
        return view('auth.forgot-password');
    })->name('password.request');
});

Route::middleware(['auth'])->group(function () {
// Dashboard - Route through controller instead of view
    Route::get('/dashboard', [\App\Http\Controllers\DashboardController::class, 'index'])
        ->name('dashboard');

    // User Routes
    Route::prefix('dataentry/user')->name('user.')->group(function () {
        // Route::get('/', [App\Http\Controllers\DataEntry\UserController::class, 'index'])->name('index');
        // Route::post('/store', [App\Http\Controllers\DataEntry\UserController::class, 'store'])->name('store');
        // Route::get('/edit/{id}/{hash}', [App\Http\Controllers\DataEntry\UserController::class, 'edit'])->name('edit');
        // Route::put('/update/{id}/{hash}', [App\Http\Controllers\DataEntry\UserController::class, 'update'])->name('update');
        // Route::get('/delete/{id}/{hash}', [App\Http\Controllers\DataEntry\UserController::class, 'delete'])->name('delete');

        // Password Management Routes with Hash
        Route::get('/change-password/{id}/{hash}', [App\Http\Controllers\DataEntry\UserController::class, 'changePasswordForm'])->name('change-password-form');
        Route::post('/change-password/{id}/{hash}', [App\Http\Controllers\DataEntry\UserController::class, 'changePassword'])->name('change-password-update');
        Route::get('/reset-password/{id}/{hash}', [App\Http\Controllers\DataEntry\UserController::class, 'resetPassword'])->name('reset-password');
    });

    // Classes Routes
    Route::get('/classes', [App\Http\Controllers\DataEntry\ClassesController::class, 'index'])->name('classes.index');
    Route::post('/classes/store', [App\Http\Controllers\DataEntry\ClassesController::class, 'store'])->name('classes.store');
    Route::get('/classes/edit/{id}/{hash}', [App\Http\Controllers\DataEntry\ClassesController::class, 'edit'])->name('classes.edit');
    Route::post('/classes/update/{id}/{hash}', [App\Http\Controllers\DataEntry\ClassesController::class, 'update'])->name('classes.update');
    Route::get('/classes/delete/{id}/{hash}', [App\Http\Controllers\DataEntry\ClassesController::class, 'delete'])->name('classes.delete');

    // Academic Year Routes
    Route::get('/academicyear', [App\Http\Controllers\DataEntry\AcademicYearController::class, 'index'])->name('academicyear.index');
    Route::post('/academicyear/store', [App\Http\Controllers\DataEntry\AcademicYearController::class, 'store'])->name('academicyear.store');
    Route::get('/academicyear/edit/{id}/{hash}', [App\Http\Controllers\DataEntry\AcademicYearController::class, 'edit'])->name('academicyear.edit');
    Route::post('/academicyear/update/{id}/{hash}', [App\Http\Controllers\DataEntry\AcademicYearController::class, 'update'])->name('academicyear.update');
    Route::get('/academicyear/delete/{id}/{hash}', [App\Http\Controllers\DataEntry\AcademicYearController::class, 'delete'])->name('academicyear.delete');

    // Aarakshya Main Routes
    Route::get('/aarakshyamain', [App\Http\Controllers\DataEntry\AarakshyaMainController::class, 'index'])->name('aarakshyamain.index');
    Route::post('/aarakshyamain/store', [App\Http\Controllers\DataEntry\AarakshyaMainController::class, 'store'])->name('aarakshyamain.store');
    Route::get('/aarakshyamain/edit/{id}/{hash}', [App\Http\Controllers\DataEntry\AarakshyaMainController::class, 'edit'])->name('aarakshyamain.edit');
    Route::post('/aarakshyamain/update/{id}/{hash}', [App\Http\Controllers\DataEntry\AarakshyaMainController::class, 'update'])->name('aarakshyamain.update');
    Route::get('/aarakshyamain/delete/{id}/{hash}', [App\Http\Controllers\DataEntry\AarakshyaMainController::class, 'delete'])->name('aarakshyamain.delete');

    // School Routes
    Route::get('/school', [App\Http\Controllers\DataEntry\SchoolController::class, 'index'])->name('school.index');
    Route::post('/school/store', [App\Http\Controllers\DataEntry\SchoolController::class, 'store'])->name('school.store');
    Route::get('/school/edit/{id}/{hash}', [App\Http\Controllers\DataEntry\SchoolController::class, 'edit'])->name('school.edit');
    Route::post('/school/update/{id}/{hash}', [App\Http\Controllers\DataEntry\SchoolController::class, 'update'])->name('school.update');
    Route::get('/school/delete/{id}/{hash}', [App\Http\Controllers\DataEntry\SchoolController::class, 'delete'])->name('school.delete');

    // User Routes
    Route::get('/user', [App\Http\Controllers\Admin\UserController::class, 'index'])->name('user.index');
    Route::post('/user/store', [App\Http\Controllers\Admin\UserController::class, 'store'])->name('user.store');
    Route::get('/user/edit/{id}/{hash}', [App\Http\Controllers\Admin\UserController::class, 'edit'])->name('user.edit');
    Route::post('/user/update/{id}/{hash}', [App\Http\Controllers\Admin\UserController::class, 'update'])->name('user.update');
    Route::get('/user/delete/{id}/{hash}', [App\Http\Controllers\Admin\UserController::class, 'delete'])->name('user.delete');

});
