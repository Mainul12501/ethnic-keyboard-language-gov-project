<?php

use App\Http\Controllers\Api\AuthController;
use App\Http\Controllers\Api\DataCollectionController;
use App\Http\Controllers\Api\DirectedController;
use App\Http\Controllers\Api\LanguageAssignController;
use App\Http\Controllers\Api\NotificationController;
use App\Http\Controllers\Api\SpeakerController;
use App\Http\Controllers\Api\SpontaneousController;
use App\Http\Controllers\Api\TaskAssignController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::post('login', [AuthController::class, 'login']);
Route::post('forget-password', [AuthController::class, 'submitForgetPasswordForm']);
Route::get('test', [AuthController::class, 'test']);
Route::get('active-notification/{id}/list', [AuthController::class, 'test']);


/*Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});*/

Route::group(['middleware'=>['auth:sanctum']], function (){

  /*  Route::get('spontaneouses', [SpontaneousController::class, 'index'])->name('spontaneouses.index');
    Route::post('spontaneouses', [SpontaneousController::class, 'store'])->name('spontaneouses.store');
    Route::get('spontaneouses/{id}', [SpontaneousController::class, 'show'])->name('spontaneouses.show');
    Route::put('spontaneouses/{id}', [SpontaneousController::class, 'update'])->name('spontaneouses.update');

    Route::get('directeds',[DirectedController::class, 'index'])->name('directeds.index');
    Route::get('directeds/{id}',[DirectedController::class, 'show'])->name('directeds.show');
    Route::post('directeds',[DirectedController::class, 'store'])->name('directeds.store');
    Route::put('directeds/{id}',[DirectedController::class, 'update'])->name('directeds.update');*/

    Route::get('/profile', [AuthController::class, 'getProfile']);
    Route::post('/update/profile', [AuthController::class, 'updateProfile']);
    Route::post('/update/password', [AuthController::class, 'updatePassword']);


    Route::get('language_assigns', [LanguageAssignController::class, 'index'])->name('language_assigns.index');
    Route::get('language_assigns/language/topic/{id}/list', [LanguageAssignController::class, 'getDirectedLanguageTopic'])->name('language_assigns.directed');
    Route::get('language_assigns/directed/{id}/list', [LanguageAssignController::class, 'getDirectedLanguageList'])->name('language_assigns.directed.topic.list');
    Route::get('language_assigns/spontaneous/{id}/list', [LanguageAssignController::class, 'getSpontaneousLanguageList'])->name('language_assigns.spontaneous.list');

    Route::get('task_assigns',[TaskAssignController::class, 'index'])->name('task_assigns.language.index');
    Route::get('task_assigns/language/{id}/district/{name}/topic/list',[TaskAssignController::class, 'getTaskDirectedLanguageTopic'])->name('task_assigns.language.topic.list');
    Route::get('task_assigns/language/topic/{id}/sentence/list',[TaskAssignController::class, 'getTaskDirectedLanguageTopicBySentence'])->name('task_assigns.language.topic.sentence.list');
    Route::get('task_assigns/language/{id}/district/{name}/spontaneous/list',[TaskAssignController::class, 'getSpontaneousLanguageByWordList'])->name('task_assigns.language.spontaneous.list');
    Route::get('data_collections/spontaneous/{word}/task_assign/{id}/language/{s}/district/{name}/list', [DataCollectionController::class, 'getSpontaneousAudio']);
    Route::get('speakers', [SpeakerController::class, 'index'])->name('speakers.index');
    Route::post('speakers', [SpeakerController::class, 'store'])->name('speakers.store');

    Route::get('getDistricts', [SpeakerController::class, 'getDistricts'])->name('districts.list');
    Route::get('upazila/district/{id}/list', [SpeakerController::class, 'getUpazila'])->name('upazila.list');
    Route::get('union/upazila/{id}/list', [SpeakerController::class, 'getUnion'])->name('union.list');
    Route::get('village/union/{id}/list', [SpeakerController::class, 'getVillage'])->name('village.list');

    Route::post('data_collections',[DataCollectionController::class, 'store'])->name('data_collections.store');

    Route::get('speakers/{language_id}', [SpeakerController::class, 'getSpeakers'])->name('speaker.lists');
    Route::post('/logout', [AuthController::class, 'logout']);
});


