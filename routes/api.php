<?php
use App\Http\Controllers\Dashboard\ContentCreator\ContentCreatorController;
use Illuminate\Support\Facades\Route;

Route::post('fetchTrends', [ContentCreatorController::class, 'fetchTrends']);