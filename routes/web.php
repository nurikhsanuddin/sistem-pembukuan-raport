<?php

use App\Http\Controllers\ClassController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\SemesterController;
use Illuminate\Support\Facades\Route;

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
use App\Http\Controllers\ReportCardController;

Route::middleware(['auth'])->group(function () {
    // API route for DataTables
    Route::get('/api/students', [ReportCardController::class, 'getStudents'])
        ->name('api.students.list')
        ->middleware('web'); // Tambahkan middleware web untuk session

    Route::get('/reportcard/upload', [ReportCardController::class, 'showUploadForm'])->name('reportcard.upload');
    Route::post('/reportcard/import', [ReportCardController::class, 'import'])->name('reportcard.import');

    // Class routes
    Route::get('/classes/create', [ClassController::class, 'create'])->name('classes.create');
    Route::post('/classes', [ClassController::class, 'store'])->name('classes.store');

    // Semester routes
    Route::get('/semesters/create', [SemesterController::class, 'create'])->name('semesters.create');
    Route::post('/semesters', [SemesterController::class, 'store'])->name('semesters.store');

    // List all students with their current class
    Route::get('/report-cards', [ReportCardController::class, 'index'])->name('report-cards.index');

    // Show student's semesters 
    Route::get('/report-cards/{student}/semesters', [ReportCardController::class, 'showSemesters'])
        ->name('report-cards.semesters');

    // Show specific report card
    Route::get('/report-cards/{student}/semester/{semester}', [ReportCardController::class, 'show'])
        ->name('report-cards.show');

    // Delete report card
    Route::delete('/report-cards/{reportCard}', [ReportCardController::class, 'destroy'])
        ->name('report-cards.destroy');
});


require __DIR__ . '/auth.php';
