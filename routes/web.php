<?php

use App\Livewire\PageHome;
use App\Livewire\PageSites;
use Illuminate\Support\Facades\Route;

Route::get('/', PageHome::class)->name('page.home');

Route::get('/sites', PageSites::class)->name('page.sites');
