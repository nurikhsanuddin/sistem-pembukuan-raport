<?php

use App\Http\Controllers\ClassController;
use App\Http\Controllers\HomeroomTeacherController;
use App\Http\Controllers\MapelController;
use App\Http\Controllers\PredikatController;
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
    Route::get('/classes/{class}/edit', [ClassController::class, 'edit'])->name('classes.edit');
    Route::put('/classes/{class}', [ClassController::class, 'update'])->name('classes.update');
    Route::delete('/classes/{class}', [ClassController::class, 'destroy'])->name('classes.destroy');

    // Semester routes
    Route::get('/semesters/create', [SemesterController::class, 'create'])->name('semesters.create');
    Route::post('/semesters', [SemesterController::class, 'store'])->name('semesters.store');
    Route::delete('/semesters/{semester}', [SemesterController::class, 'destroy'])->name('semesters.destroy');
    Route::get('/semesters/{semester}/edit', [SemesterController::class, 'edit'])->name('semesters.edit');
    Route::put('/semesters/{semester}', [SemesterController::class, 'update'])->name('semesters.update');

    Route::get('/predikat/index', [PredikatController::class, 'index'])->name('predikat.index');
    Route::post('/predikat', [PredikatController::class, 'store'])->name('predikat.store');
    Route::delete('/predikat/{predikat}', [PredikatController::class, 'destroy'])->name('predikat.destroy');
    Route::get('/predikat/{predikat}/edit', [PredikatController::class, 'edit'])->name('predikat.edit');
    Route::put('/predikat/{predikat}', [PredikatController::class, 'update'])->name('predikat.update');

    // Remove these individual routes since they're duplicating the resource route
    // Route::get('/mapel/index', [MapelController::class, 'index'])->name('mapel.index');
    // Route::post('/mapel', [MapelController::class, 'store'])->name('mapel.store');
    // Route::delete('/mapel/{mapel}', [MapelController::class, 'destroy'])->name('mapel.destroy');
    // Route::get('/mapel/{mapel}/edit', [MapelController::class, 'edit'])->name('mapel.edit');
    // Route::put('/mapel/{mapel}', [MapelController::class, 'update'])->name('mapel.update');

    // Keep only this resource route
    Route::resource('mapel', MapelController::class)->parameter('mapel', 'subject')->except([
        'create',
        'store',
        'show'
    ]);
    Route::resource('homeroom', HomeroomTeacherController::class);
    // Report Card Routes
    Route::prefix('report-cards')->name('report-cards.')->group(function () {
        Route::get('/', [ReportCardController::class, 'index'])->name('index');
        Route::get('/upload', [ReportCardController::class, 'showUploadForm'])->name('upload');
        Route::post('/import', [ReportCardController::class, 'import'])->name('import');
        Route::get('/students', [ReportCardController::class, 'getStudents'])->name('students');
        Route::get('/students/{student}/semesters', [ReportCardController::class, 'showSemesters'])->name('semesters');
        Route::get('/students/{student}/semester/{semester}', [ReportCardController::class, 'show'])->name('show');
        Route::delete('/{reportCard}', [ReportCardController::class, 'destroy'])->name('destroy');
        Route::get('/class/{classId}', [ReportCardController::class, 'classStudents'])->name('class-students');
        Route::get('/class/{classId}/export', [ReportCardController::class, 'exportClassReportCards'])->name('export-class');
    });

    Route::get('/reportcard/class/{class}/export-pdf', [ReportCardController::class, 'exportPDF'])
        ->name('reportcard.export-pdf');
    Route::get('/reportcard/class/{class}/browser-print', [ReportCardController::class, 'browserPrint'])
        ->name('reportcard.browser-print');

    Route::get('/reportcard/class/{classId}/export-class', [ReportCardController::class, 'exportClassReportCards'])
        ->name('reportcard.export-class');
});


require __DIR__ . '/auth.php';
