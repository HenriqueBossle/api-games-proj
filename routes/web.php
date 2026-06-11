<?php

use App\Http\Controllers\GameController;
use Illuminate\Support\Facades\Route;

Route::apiResource('games', GameController::class)
    ->except(['create', 'edit']);
