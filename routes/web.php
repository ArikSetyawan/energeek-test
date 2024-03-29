<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\apiController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

// Route::get('/', function () {
//     return view('welcome');
// });

//?  ------------------------   API Lamar Kerja   ------------------------ !!
Route::group([],function () {
    Route::get('/', [apiController::class, 'Index']);
    Route::post('/api/v1/new-candidate', [apiController::class, 'saveCandidate']);
    Route::get('/api/v1/get-candidates', [apiController::class, 'getCandidates']);
});
