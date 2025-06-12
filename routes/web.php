<?php
    use Illuminate\Support\Facades\Route;
    Route::get('profile', [\App\Http\Controllers\Site\Custom::class, 'profile'])->name('site.profile');
    Route::get('profile/field', [\App\Http\Controllers\Site\Custom::class, 'profileField'])->name('site.profile.field');
    Route::get('profile/season', [\App\Http\Controllers\Site\Custom::class, 'profileSeason'])->name('site.profile.season');
    # ->

