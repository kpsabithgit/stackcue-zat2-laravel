<?php

use Illuminate\Support\Facades\Route;
use Sabith\StackcueZat2Laravel\Http\Controllers\PageController;

// Route::get('/stackcue-zat2', [PageController::class, 'simplifiedinvoice'])->name('stackcue-zat2');

Route::prefix('stackcue-zat2')->group(function(){

    Route::get('/simplifiedinvoice', [PageController::class, 'simplifiedinvoice'])->name('simplifiedinvoice');
    Route::get('/simplifiedcreditnote', [PageController::class, 'simplifiedcreditnote'])->name('simplifiedcreditnote');
    Route::get('/simplifieddebitnote', [PageController::class, 'simplifieddebitnote'])->name('simplifieddebitnote');

    Route::get('/standardinvoice', [PageController::class, 'standardinvoice'])->name('standardinvoice');
    Route::get('/standarddebitnote', [PageController::class, 'standarddebitnote'])->name('standarddebitnote');
    Route::get('/standardcreditnote', [PageController::class, 'standardcreditnote'])->name('standardcreditnote');

    Route::get('/productioncsid', [PageController::class, 'productioncsid'])->name('productioncsid');
    Route::get('/compliancecsid', [PageController::class, 'compliancecsid'])->name('compliancecsid');


});

Route::get('stackcue-zat2-adminkit/{path}', function ($path) {
    // Ensure we properly navigate to the package's public folder
    $filePath = realpath(__DIR__ . '/../../public/adminkit/' . $path);
   
    // Check if the file exists before attempting to return it
    if ($filePath && file_exists($filePath)) {
        return response()->file($filePath);
    }

    // Return 404 if the file doesn't exist
    abort(404);
})->where('path', '.*');

