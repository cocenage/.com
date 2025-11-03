<?php

use App\Livewire\NotFound;
use App\Livewire\PageAbout;
use App\Livewire\PageHome;
use App\Livewire\PagePosters;
use App\Livewire\PageSites;
use Illuminate\Support\Facades\Route;

Route::get('/', PageHome::class)->name('page.home');

Route::get('/sites', PageSites::class)->name('page.sites');

Route::get('/posters', PagePosters::class)->name('page.posters');

Route::get('/about', PageAbout::class)->name('page.about');

Route::get('/{any}', NotFound::class)->where('any', '.*');
