<?php

use App\NativeComponents\Tasks;
use Illuminate\Support\Facades\Route;

Route::native('/', Tasks::class);
