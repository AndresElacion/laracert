<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\EventController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\CertificateController;
use App\Http\Controllers\EventRegistrationController;

Route::get('/', function () {
    return view('welcome');
});

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

Route::middleware(['auth'])->group(function () {
    Route::resource('events', EventController::class);
    Route::get('events/{event}', [EventController::class, 'show'])->name('events.show');
    Route::get('events/{event}/edit', [EventController::class, 'edit'])->name('events.edit');
    Route::put('events/{event}/template', [EventController::class, 'updateTemplate'])->name('events.update-template');
    Route::get('events/{event}/template', [EventController::class, 'downloadTemplate'])->name('events.download-template');
    Route::post('/events/{event}/register', [EventController::class, 'register'])->name('events.register');
    Route::post('/events/{event}/request-certificate', [CertificateController::class, 'requestCertificate'])->name('certificates.request');
    Route::get('/my-certificates', [CertificateController::class, 'userCertificates'])->name('certificates.my-certificates');
    Route::get('/events/{event}/registrations', [EventRegistrationController::class, 'index'])->name('events.registrations.index');
    Route::patch('/events/{event}/registrations/{registration}', [EventRegistrationController::class, 'updateStatus'])->name('events.registrations.update-status');
    Route::get('/admin/certificates', [CertificateController::class, 'showApprovalPage'])->name('admin.certificates');
    Route::post('/admin/certificates/bulk-action', [CertificateController::class, 'bulkAction'])->name('admin.certificates.bulkAction');
    Route::get('/certificates/{certificate}/download', [CertificateController::class, 'download'])->name('certificates.download');

});
require __DIR__.'/auth.php';
