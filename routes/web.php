<?php

use App\Models\Event;
use App\Models\CertificateRequest;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\UserController;
use App\Http\Controllers\EventController;
use App\Http\Controllers\ContactController;
use App\Http\Controllers\ProfileController;
use App\Models\CertificateTemplateCategory;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\CertificateController;
use App\Http\Controllers\CoordinatorController;
use App\Http\Controllers\EventSearchController;
use App\Http\Controllers\AnnouncementController;
use App\Http\Controllers\EventRegistrationController;
use App\Http\Controllers\SingleCertificateController;
use App\Http\Controllers\Auth\RegisteredUserController;
use Illuminate\Foundation\Auth\EmailVerificationRequest;
use App\Http\Controllers\CertificateTemplateCategoryController;


Route::middleware(['auth'])->group(function () {
    Route::get('/email/verify', function () {
        return view('auth.verify-email');
    })->middleware('auth')->name('verification.notice');

    Route::get('/email/verify/{id}/{hash}', function (EmailVerificationRequest $request) {
        $request->fulfill();
        return redirect('/dashboard')->with('verified', true);
    })->middleware(['auth', 'signed'])->name('verification.verify');

    Route::post('/email/verification-notification', function (\Illuminate\Http\Request $request) {
        $request->user()->sendEmailVerificationNotification();
        return back()->with('message', 'Verification email sent!');
    })->middleware(['auth', 'throttle:6,1'])->name('verification.send');
});

Route::get('/', function () {
    $upcomingEvents = Event::where('end_date', '>=', now())
        ->with('certificateTemplateCategory')
        ->with(['eventCoordinators' => function($query){
            $query->with(['coordinators']);
        }])
        ->orderBy('end_date')
        ->take(4)
        ->get();

    $certificates = CertificateTemplateCategory::orderBy('name')->take(3)->get();
        
    return view('welcome', compact('upcomingEvents', 'certificates'));
});

Route::get('/dashboard', [DashboardController::class, 'index'], function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

Route::middleware(['auth'])->group(function () {
    Route::get('/events/search', [EventSearchController::class, 'search'])->name('events.search');
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
    Route::post('/admin/dashboard/certificates/bulk-action', [DashboardController::class, 'bulkAction'])->name('admin.dashboard.certificates.bulkAction');
    Route::get('/certificates/{certificate}/download', [CertificateController::class, 'download'])->name('certificates.download');
    // Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');
    Route::post('/certificate-requests/{id}/approve', [DashboardController::class, 'approve'])->name('certificate-requests.approve');
    Route::post('/certificate-requests/{id}/deny', [DashboardController::class, 'deny'])->name('certificate-requests.deny');
    Route::get('/events/create', [EventController::class, 'create'])->name('events.create');
    Route::post('/events', [EventController::class, 'store'])->name('events.store');
    Route::get('/users', [RegisteredUserController::class, 'index'])->name('users.index');
    Route::get('/users/create', [RegisteredUserController::class, 'create'])->name('users.create');
    Route::post('/users', [RegisteredUserController::class, 'store'])->name('users.store');
    Route::get('/users/{user}/edit', [RegisteredUserController::class, 'edit'])->name('users.edit');
    Route::put('/users/{user}', [RegisteredUserController::class, 'update'])->name('users.update');
    Route::delete('/users/{user}', [RegisteredUserController::class, 'destroy'])->name('users.destroy');
    Route::get('/coordinators', [CoordinatorController::class, 'index'])->name('coordinators.index');
    Route::get('/coordinators/create', [CoordinatorController::class, 'create'])->name('coordinators.create');
    Route::post('/coordinators/store', [CoordinatorController::class, 'store'])->name('coordinators.store');
    Route::get('/coordinators/{coordinator}/edit', [CoordinatorController::class, 'edit'])->name('coordinators.edit');
    Route::put('/coordinators/{coordinator}', [CoordinatorController::class, 'update'])->name('coordinators.update');
    Route::delete('/coordinators/{coordinator}', [CoordinatorController::class, 'destroy'])->name('coordinators.destroy');
    Route::get('/users/{user}/certificate', [SingleCertificateController::class, 'showUserCertificateForm'])->name('users.certificate.create');
    Route::post('/users/{user}/certificate', [SingleCertificateController::class, 'generateSingleCertificate'])->name('users.certificate.generate');
    Route::post('/users/{user}/certificate/preview', [SingleCertificateController::class, 'previewSingleCertificate'])->name('users.certificate.preview');
    Route::get('/users/search', [UserController::class, 'search'])->name('users.search');
    Route::resource('announcements', AnnouncementController::class);
});

    Route::post('/contact-submit', [ContactController::class, 'submit'])->name('contact.submit');

Route::middleware(['auth'])->group(function () {
    Route::get('/certificate-categories', [CertificateTemplateCategoryController::class, 'index'])
        ->name('admin.certificate-categories.index');
    
    Route::get('/certificate-categories/create', [CertificateTemplateCategoryController::class, 'create'])
        ->name('admin.certificate-categories.create');
    
    Route::post('/certificate-categories', [CertificateTemplateCategoryController::class, 'store'])
        ->name('admin.certificate-categories.store');
    
    Route::get('/certificate-categories/{certificate_category}', [CertificateTemplateCategoryController::class, 'show'])
        ->name('admin.certificate-categories.show');
    
    Route::get('/certificate-categories/{certificate_category}/edit', [CertificateTemplateCategoryController::class, 'edit'])
        ->name('admin.certificate-categories.edit');
    
    Route::put('/certificate-categories/{certificate_category}', [CertificateTemplateCategoryController::class, 'update'])
        ->name('admin.certificate-categories.update');
    
    Route::delete('/certificate-categories/{certificate_category}', [CertificateTemplateCategoryController::class, 'destroy'])
        ->name('admin.certificate-categories.destroy');

    Route::get('/certificates/{certificate}/preview', [CertificateController::class, 'preview'])
        ->name('certificates.preview');
});

require __DIR__.'/auth.php';
