<?php

use Illuminate\Support\Facades\Route;
use Artesaos\SEOTools\Facades\SEOTools;
use App\Http\Controllers\SecretController;
use App\Http\Controllers\StatsController;
use Illuminate\Http\Request;

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

Route::get('/private/{text:private_key}', [SecretController::class, 'private'])->name('text.private')->missing(function (Request $request) {
    SEOTools::setTitle('No such text');
    return response()->view('text.unknown');
});

Route::get('/secret/{text}', [SecretController::class, 'secret'])->name('text.secret')->missing(function (Request $request) {
    SEOTools::setTitle('No such text');
    return response()->view('text.unknown');
});

Route::get('/stats', [StatsController::class, 'view'])->name('stats');

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

Route::get('/sponsors', function() {
    SEOTools::setTitle('Sponsors');
    return view('sponsors');
})->name('sponsors');

Route::get('/contributors', function() {
    return redirect()->route('sponsors');
})->name('contributors');

/*
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
*/

Route::middleware(['auth:sanctum', 'verified'])->get('/recent', function () {
    SEOTools::setTitle('Recent secrets');
    return view('text.recent', [
        'texts' => request()->user()->texts()->whereDate('expires_at', '>', now())->orderBy('created_at', 'desc')->get()
    ]);
})->name('recent');
