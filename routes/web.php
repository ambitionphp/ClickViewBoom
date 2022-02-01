<?php

use Illuminate\Support\Facades\Route;
use Artesaos\SEOTools\Facades\SEOTools;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', function () {
    SEOTools::setTitle('Self destructing text');
    return view('welcome');
});

Route::get('/private/{text:private_key}', function(\App\Models\Text $text) {
    SEOTools::setTitle('You saved a text');
    return view('text.private', [
        'text' => $text
    ]);
})->name('text.private')->missing(function (\Illuminate\Http\Request $request) {
    SEOTools::setTitle('No such text');
    return response()->view('text.unknown');
});

Route::get('/secret/{text}', function(\App\Models\Text $text) {
    SEOTools::setTitle('You received a text');
    return view('text.secret', [
        'text' => $text
    ]);
})->name('text.secret')->missing(function (\Illuminate\Http\Request $request) {
    SEOTools::setTitle('No such text');
    return response()->view('text.unknown');
});

Route::get('/about', function() {
    SEOTools::setTitle('About');
    return view('about');
})->name('about');

Route::get('/privacy', function() {
    SEOTools::setTitle('Privacy Policy');
    return view('policy');
})->name('policy.show');

Route::get('/terms', function() {
    SEOTools::setTitle('Terms of Use');
    return view('terms');
})->name('terms.show');

Route::get('/contributors', function() {
    SEOTools::setTitle('Contributors');
    return view('contributors');
})->name('contributors');

Route::get('/docs/api', function() {
    SEOTools::setTitle('API Docs');
    return view('api.docs.overview');
})->name('docs.api');

Route::get('/docs/api/secrets', function() {
    SEOTools::setTitle('API Docs');
    return view('api.docs.secrets');
})->name('docs.api.secrets');

Route::get('/docs/api/postman', function() {
    SEOTools::setTitle('Run in Postman');
    return view('api.docs.postman');
})->name('docs.api.postman');

Route::middleware(['auth:sanctum', 'verified'])->get('/recent', function () {
    SEOTools::setTitle('Recent secrets');
    return view('text.recent', [
        'texts' => request()->user()->texts()->orderBy('created_at', 'desc')->get()
    ]);
})->name('recent');
