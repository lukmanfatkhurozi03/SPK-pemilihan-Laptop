<?php

use App\Http\Controllers\AlternativeController;
use App\Http\Controllers\CriteriaController;
use App\Http\Controllers\SpkController;
use Illuminate\Support\Facades\Route;

// Main SPK Wizard Routes
Route::get('/', [SpkController::class, 'index'])->name('spk.index');
Route::post('/spk/weights', [SpkController::class, 'updateWeights'])->name('spk.weights.update');
Route::post('/spk/weights/auto-normalize', [SpkController::class, 'autoNormalizeWeights'])->name('spk.weights.normalize');
Route::post('/spk/reset-default', [SpkController::class, 'resetDefault'])->name('spk.reset');
Route::post('/api/spk/calculate', [SpkController::class, 'apiCalculate'])->name('spk.api.calculate');
Route::get('/spk/print', [SpkController::class, 'printReport'])->name('spk.print');

// Dynamic Criteria Routes
Route::post('/criterias', [CriteriaController::class, 'store'])->name('criterias.store');
Route::put('/criterias/{criteria}', [CriteriaController::class, 'update'])->name('criterias.update');
Route::delete('/criterias/{criteria}', [CriteriaController::class, 'destroy'])->name('criterias.destroy');
Route::post('/criterias/{criteria}/scales', [CriteriaController::class, 'addScale'])->name('criterias.scales.store');
Route::post('/criterias/{criteria}/scales/batch', [CriteriaController::class, 'batchUpdateScales'])->name('criterias.scales.batch');
Route::post('/criterias/{criteria}/scales/reset', [CriteriaController::class, 'resetCriteriaScales'])->name('criterias.scales.reset');
Route::put('/criteria-scales/{scale}', [CriteriaController::class, 'updateScale'])->name('criterias.scales.update');
Route::delete('/criteria-scales/{scale}', [CriteriaController::class, 'deleteScale'])->name('criterias.scales.destroy');

// Dynamic Alternative Routes
Route::post('/alternatives', [AlternativeController::class, 'store'])->name('alternatives.store');
Route::put('/alternatives/{alternative}', [AlternativeController::class, 'update'])->name('alternatives.update');
Route::delete('/alternatives/{alternative}', [AlternativeController::class, 'destroy'])->name('alternatives.destroy');
Route::post('/api/alternatives/quick-score', [AlternativeController::class, 'quickScore'])->name('alternatives.quickScore');
