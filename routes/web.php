<?php

use App\Livewire\Pages\About;
use App\Livewire\Pages\Contact;
use App\Livewire\Pages\Home;
use App\Livewire\Pages\ProjectIndex;
use App\Livewire\Pages\ProjectShow;
use Illuminate\Support\Facades\Cookie;
use Illuminate\Support\Facades\Route;

Route::get('/', Home::class)->name('home');
Route::get('/projects', ProjectIndex::class)->name('projects.index');
Route::get('/projects/{project:slug}', ProjectShow::class)->name('projects.show');
Route::get('/about', About::class)->name('about');
Route::get('/contact', Contact::class)->name('contact');

// Switch the site language, remember it in a cookie, and return where you were.
Route::get('/locale/{locale}', function (string $locale) {
    Cookie::queue(Cookie::forever('locale', $locale));

    return back();
})->whereIn('locale', array_keys(config('app.available_locales')))->name('locale.switch');
