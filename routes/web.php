<?php

use App\Livewire\NotFound;
use App\Livewire\PageHome;
use Illuminate\Support\Facades\Route;

Route::get('/', PageHome::class)->name('page.home');

Route::get('/{any}', NotFound::class)->where('any', '.*');
