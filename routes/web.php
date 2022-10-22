<?php

use App\Http\Controllers\Admin\BackendController;
use App\Http\Controllers\Admin\DataCollectionController;
use App\Http\Controllers\Admin\DataCollectorController;
use App\Http\Controllers\Admin\DirectedController;
use App\Http\Controllers\Admin\DirectedLanguageController;
use App\Http\Controllers\Admin\DirectedSentenceController;
use App\Http\Controllers\Admin\DistrictController;
use App\Http\Controllers\Admin\GroupController;
use App\Http\Controllers\Admin\GroupTaskAssignController;
use App\Http\Controllers\Admin\GuideController;
use App\Http\Controllers\Admin\LanguageAssignController;
use App\Http\Controllers\Admin\LanguageDetailController;
use App\Http\Controllers\Admin\ManagerController;
use App\Http\Controllers\Admin\NoticeController;
use App\Http\Controllers\Admin\SingleTaskAssignController;
use App\Http\Controllers\Admin\SpeakerController;
use App\Http\Controllers\Admin\SpontaneousController;
use App\Http\Controllers\Admin\SpontaneousLanguageController;
use App\Http\Controllers\Admin\StaffGroupController;
use App\Http\Controllers\Admin\SupervisorController;
use App\Http\Controllers\Admin\TaskAssignController;
use App\Http\Controllers\Admin\UnionController;
use App\Http\Controllers\Admin\UpazilaController;
use App\Http\Controllers\Admin\VillageController;
use App\Http\Controllers\PermissionController;
use App\Http\Controllers\RoleController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\Admin\ValidatorTaskAssignController;
use App\Http\Controllers\Admin\LinguistTaskAssignController;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Admin\LanguageController;
use App\Http\Controllers\Auth\ForgotPasswordController;
use App\Http\Controllers\Admin\AudioTrimController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\NotificationController;
use App\Http\Controllers\ViewTableController;
use App\Http\Controllers\Admin\ReDataCollectionController;

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
    return redirect()->route('login');
});

// for localization
Route::get('lang/{lang}', ['as' => 'lang.switch', 'uses' => 'App\Http\Controllers\LanguageController@switchLang']);
Route::get('/languageDemo', 'App\Http\Controllers\HomeController@languageDemo');

Route::get('clear-cache', function () {
    $exitCode = Artisan::call('config:clear');
    $exitCode = Artisan::call('cache:clear');
    $exitCode = Artisan::call('config:cache');

    return redirect()->back(); //Return anything
});

Auth::routes();



Route::group(['prefix'=>'admin', 'middleware'=>['auth'], 'as'=>'admin.'], function (){

    Route::get('/dashboard', [App\Http\Controllers\HomeController::class, 'index'])->name('dashboard');

    Route::get('/viewTable', [App\Http\Controllers\ViewTableController::class, 'index'])->name('viewTable');

    Route::get('/profile', [ BackEndController::class, 'profile'])->name('profile');
    Route::post('/update/profile', [BackEndController::class, 'updateProfile'])->name('update.profile');
    Route::post('/update/password', [BackEndController::class, 'updatePassword'])->name('updatePassword');
    Route::post('/update/user/password',[UserController::class, 'updatePassword'])->name('update.password');


    Route::resource('users', UserController::class);
    Route::resource('roles', RoleController::class);
    Route::resource('permissions', PermissionController::class);
    Route::resource('languages', LanguageController::class);
    Route::get('/directed/language/{id}/list', [DirectedLanguageController::class, 'getDirectedLanguageList'])->name('directed.languages.list');
    Route::get('/directed/{topic_id}/{language_id}/list', [DirectedLanguageController::class, 'topicBySentenceList'])->name('directed.language.topic.sentence');
    Route::get('/directed/language/topic/{task_assign_id}/{topic_id}/list', [DirectedLanguageController::class, 'getTopicBySentence'])->name('directed.languages.sentence.list');

    Route::get('/spontaneous/language/{id}/list', [SpontaneousLanguageController::class, 'getSpontaneousLanguageList'])->name('spontaneous.languages.list');
    Route::put('update-spontaneous', [SpontaneousController::class, 'spontaneousUpdate']);
    Route::resource('spontaneouses', SpontaneousController::class);
    Route::put('update-directeds', [DirectedController::class, 'directedUpdate']);
    Route::resource('directeds', DirectedController::class);
    Route::get('directed_sentences/{topic_id}/list', [DirectedSentenceController::class, 'index'])->name('directed_sentence.index');
    Route::get('directed_sentences/create/{topic_id}', [DirectedSentenceController::class, 'create'])->name('directed_sentence.create');
    Route::post('directed_sentences', [DirectedSentenceController::class, 'store'])->name('directed_sentence.store');
    Route::get('directed_sentences/{id}/edit', [DirectedSentenceController::class, 'edit'])->name('directed_sentence.edit');
    Route::put('directed_sentences/{id}/update', [DirectedSentenceController::class, 'update'])->name('directed_sentence.update');
    Route::delete('directed_sentences/{id}', [DirectedSentenceController::class, 'destroy'])->name('directed_sentence.destroy');
    Route::resource('districts', DistrictController::class);
    Route::resource('upazilas', UpazilaController::class);
    Route::resource('unions', UnionController::class);
    Route::resource('villages', VillageController::class);
    Route::get('languageList', [LanguageAssignController::class, 'languageList'])->name('languageList');
    Route::resource('language_assigns', LanguageAssignController::class);
    Route::resource('managers', ManagerController::class);
    Route::resource('supervisors', SupervisorController::class);
    Route::resource('guides', GuideController::class);
    Route::resource('validator_task_assigns', ValidatorTaskAssignController::class);
    Route::resource('linguist_task_assigns', LinguistTaskAssignController::class);
    Route::get('getValidatorUpazila', [ValidatorTaskAssignController::class, 'getValidatorUpazila']);
    Route::get('getValidatorUnion', [ValidatorTaskAssignController::class, 'getValidatorUnion']);
    Route::get('getLinguistUpazila', [LinguistTaskAssignController::class, 'getLinguistUpazila']);
    Route::get('getLinguistUnion', [LinguistTaskAssignController::class, 'getLinguistUnion']);
    Route::get('getSubLanguage', [LinguistTaskAssignController::class, 'getSubLanguage']);
    // Route::get('validator_task_assigns/create',  [ValidatorTaskAssignController::class, 'create'])->name('validator.task-assign.create');
    Route::resource('data_collectors', DataCollectorController::class);
    Route::resource('groups', GroupController::class);
    Route::post('getCollector', [TaskAssignController::class, 'getCollector'])->name('groupFetch');
    Route::get('getGroupByCollector', [TaskAssignController::class, 'getGroupByCollector']);
    Route::get('getTaskUser', [TaskAssignController::class, 'getTaskUser']);
    Route::get('directedTopic', [TaskAssignController::class, 'directedTopic']);
    Route::get('selectedSpontaneous', [TaskAssignController::class, 'selectedSpontaneous']);
    Route::get('getDirectedTopic', [TaskAssignController::class, 'getDirectedTopic']);
    Route::get('getSpontaneous', [TaskAssignController::class, 'getSpontaneous']);
    Route::get('getUpazila', [TaskAssignController::class, 'getUpazila']);
    Route::get('getUnion', [TaskAssignController::class, 'getUnion']);
    Route::get('getVillage', [TaskAssignController::class, 'getVillage']);

    Route::get('task-assigns/list', [TaskAssignController::class, 'taskAssignListByLanguage'])->name('task-assign.language.list');

    Route::get('/directed/language/task-assign/{id}/list', [TaskAssignController::class, 'getDirectedTaskByLanguage'])->name('directed.language.tasks.list');
    Route::get('/spontaneous/language/task-assign/{id}/list', [TaskAssignController::class, 'getSpontaneousTaskByLanguage'])->name('spontaneous.language.tasks.list');
    Route::resource('task_assigns', TaskAssignController::class);
    Route::get('getDistrict', [SingleTaskAssignController::class, 'getDistrict']);
    Route::resource('single_task_assigns', SingleTaskAssignController::class);
    Route::get('speakers/task/{task_assign_id?}',[SpeakerController::class, 'createSpeaker'])->name('speakers.task.create');
    Route::get('speakers/validator/{task_assign_id?}',[SpeakerController::class, 'createValidator'])->name('speakers.validator.create');
    Route::post('speakers/validator/store',[SpeakerController::class, 'validatorStore'])->name('speakers.validatorStore');
    Route::get('getLangDistrict', [SpeakerController::class, 'getLangDistrict']);
    Route::resource('speakers', SpeakerController::class);
    Route::post('getTopic', [DataCollectionController::class, 'getTopic'])->name('topicFetch');
    Route::post('getDirectedSentence', [DataCollectionController::class, 'getDirectedSentence'])->name('sentenceFetch');
    Route::get('data_collections/directed/{id}/edit', [DataCollectionController::class, 'editDirected'])->name('data_collections.directed.edit');
    //approve or reject
    Route::get('data_approval/directed/{id}/sendToApprove', [DataCollectionController::class, 'directedSendToApprove'])->name('data_approval.directed.sendToApprove');
    Route::get('revert/directed/{id}/revertData', [DataCollectionController::class, 'directedDataRevert'])->name('data_approval.revert.directed');
    // Route::post('/approve/store', [DataCollectionController::class, 'sendToApprove'])->name('collection.approve.store');
    Route::put('sent_to_data_approved/{id}', [DataCollectionController::class, 'sentToDataApproved'])->name('send.data.approved');
    Route::get('directed/revert/{id}', [DataCollectionController::class, 'directedRevert'])->name('data_approval.directed.revert');
    Route::get('validator/revert/{id}', [DataCollectionController::class, 'directedDataValidationRevert'])->name('validator.directed.revert');
    Route::put('directed/reject', [DataCollectionController::class, 'directedSendToRevert'])->name('data_approval.directed.send.revert');
    Route::put('revert/directed/reject', [DataCollectionController::class, 'directedToRevertData'])->name('directed.revert.ByValidator');
    Route::post('/approved/spon/word', [DataCollectionController::class, 'wordWiseApprove'])->name('approved.spontaneous.word.store');

    Route::put('data_collections/directed/{data_collection}', [DataCollectionController::class, 'updateDirected'])->name('data_collections.directed.update');
    Route::delete('data_collections/directed/{data_collection}', [DataCollectionController::class, 'destroyDirected'])->name('data_collections.directed.destroy');

    Route::get('data_collections/spontaneous/{id}/edit', [DataCollectionController::class, 'editSpontaneous'])->name('data_collections.spontaneous.edit');
    Route::put('data_collections/spontaneous/{id}', [DataCollectionController::class, 'updateSpontaneous'])->name('data_collections.spontaneous.update');
    Route::get('data_collections/{id}/view', [BackendController::class, 'getCollection'])->name('data_collections.view');
    Route::get('data_collections/pending/list', [DataCollectionController::class, 'pendingCollectionList'])->name('data_collections.pending.list');
    Route::get('data_collections/userpending/list', [DataCollectionController::class, 'userPending'])->name('data_collections.userpending.list');
    Route::get('data_collections/userapproval/list', [DataCollectionController::class, 'userApproval'])->name('data_collections.userapproval.list');

    Route::resource('data_collections', DataCollectionController::class);
    Route::get('/data_collections/direc/{task_assign_id?}/{topic_id?}', [DataCollectionController::class, 'getTopicWiseDataCollection'])->name('data_collection.directed.topic');
    Route::get('/validations/direc/{task_assign_id?}/{topic_id?}', [DataCollectionController::class, 'getTopicWiseValidation'])->name('validation.directed.topic');
    Route::post('/validations/direc/store', [DataCollectionController::class, 'topicWiseValidationStore'])->name('validation.directed.topic.store');
    Route::get('/data_collections/spon/{task_assign_id?}/{spontaneous_id?}', [DataCollectionController::class, 'getWordWiseDataCollection'])->name('data_collection.spontaneous.word');
    Route::get('/validations/spon/{task_assign_id?}/{spontaneous_id?}', [DataCollectionController::class, 'getWordWiseValidation'])->name('validation.spontaneous.word');
    Route::post('/validations/spon/store', [DataCollectionController::class, 'wordWiseValidationStore'])->name('validation.spontaneous.word.store');
    Route::get('/data_collections/{type?}/{id?}', [DataCollectionController::class, 'showDataCollectionWithTrim'])->name('data_collections.trim.show');

    Route::get('/data_collections/{language_id?}/{district_id?}/{collector_id?}/{speaker_id?}', [DataCollectionController::class, 'getDataCollectionList'])->name('data.list.show');

    Route::get('getGroupByData', [DataCollectionController::class, 'getGroupByData']);
    Route::get('data_collection/corrections', [DataCollectionController::class, 'dataCollectionCorrectionList'])->name('data_collection.correction');

    //admin approve list
    Route::get('user_wise_data_collection/corrections', [DataCollectionController::class, 'dataCollectionCorrectionForAdminList'])->name('user_wise_data_collection.correction');
    //update single trim
    Route::get('audio_trims/spontaneous/trim/{id}/edit', [AudioTrimController::class, 'editTrim'])->name('data_collections.spont.trim.edit');
    Route::put('audio_trims/spontaneous/trim/{id}', [AudioTrimController::class, 'updateTrim'])->name('data_collections.spont.trim.update');

    // trim controller
    Route::put('trim/revert', [AudioTrimController::class, 'sendToRevert'])->name('trim.send.revert');
    Route::get('revert/{id}', [AudioTrimController::class, 'revertTrim'])->name('trim.revert');
    Route::put('sent_to_pending/{id}', [AudioTrimController::class, 'sendToPending'])->name('send.trim.pending');
    Route::put('sent_to_approved/{id}', [AudioTrimController::class, 'sendToApproved'])->name('send.trim.approved');
    Route::get('/trim-approved/{type?}/{id?}', [AudioTrimController::class, 'trimApproved'])->name('trim-approved');

    // Route::get('/collectionTable',[HomeController::class,'collectionTable'])->name('trim.')
    Route::get('/directed-collections/revert/{task_assign_id?}/{topic_id?}/{directed_id?}', [ReDataCollectionController::class, 'getTopicWiseReDataCollection'])->name('data_collection.redirected.topic.revert');

      //replace parent audio
    Route::get('/trim-parent-audio/{type?}/{dc_sentence_id?}', [DataCollectionController::class, 'trimParentAudio'])->name('trim-parent-audio');
    Route::post('/replace-parent-trim-audio1', [AudioTrimController::class, 'replaceTrimAudio'])->name('replace-parent-trim-audio');
    //spontaneous trim list
    Route::get('/spontaneous/trim/{dc_spontaneous_id?}/list', [AudioTrimController::class, 'getSpontaneousTrim'])->name('spontaneous.trim.list');
    // Route::resource('audio_trim', AudioTrimController::class);
    // Route::post('');


    //notice controller
    Route::get('/notices', [NoticeController::class, 'index'])->name('notices.index');
    Route::get('/send_notices', [NoticeController::class, 'create'])->name('notices.create');
    Route::post('/send_notices', [NoticeController::class, 'sendNotice'])->name('notices.store');
    Route::put('/send_notices/{id}/seen', [NoticeController::class, 'seenNotice'])->name('notices.seen');
    Route::delete('/send_notices/{id}', [NoticeController::class, 'destroy'])->name('notices.destroy');


    //Activity Log
    Route::get('/activity-log', [BackendController::class, 'activity'])->name('activity.log');
    // send to approved
    Route::post('/approve/store', [DataCollectionController::class, 'sendToApprove'])->name('collection.approve.store');

    Route::get('/notifications', [BackendController::class, 'activity'])->name('notifications');

    Route::get('/task_assign/language/{language_id?}/list', [TaskAssignController::class, 'getTaskAssignByLanguageToday'])->name('taskAssign.task_assign_by_language_list');
 //import system
    Route::get('file-import-export', [DirectedController::class, 'fileImportExport'])->name('file-import-export');
    Route::post('file-import', [DirectedController::class, 'fileImport'])->name('file-import');

    Route::get('directed-file-import-export', [DirectedController::class, 'DirectedFileImportExport'])->name('directed-file-import-export');
    Route::post('directed-file-import', [DirectedController::class, 'DirectedFileImport'])->name('directed-file-import');

});

Route::post('/get-type-content', [DataCollectionController::class, 'getTypeContent']);
Route::post('/get-type-sub-content', [DataCollectionController::class, 'getTypeSubContent']);
Route::post('/check-spo-audio-status', [DataCollectionController::class, 'checkSpoAudioStatus']);
Route::post('/check-spon-in-dc', [DataCollectionController::class, 'checkSponInDc']);

// Reset Password
Route::get('forget-password', [ForgotPasswordController::class, 'showForgetPasswordForm'])->name('forget.password.get');
Route::post('forget-password', [ForgotPasswordController::class, 'submitForgetPasswordForm'])->name('forget.password.post');
Route::get('reset-password/{token}', [ForgotPasswordController::class, 'showResetPasswordForm'])->name('reset.password.get');
Route::post('reset-password', [ForgotPasswordController::class, 'submitResetPasswordForm'])->name('reset.password.post');

//use audiotrimcontroller
Route::get('/manage-audio', [AudioTrimController::class, 'manageAudioTrim'])->name('manage-audio');
Route::post('/trim-audio1', [AudioTrimController::class, 'trimAudio'])->name('trim-audio');
Route::get('/get-trim-audios', [AudioTrimController::class, 'getTrimAudio'])->name('get-trim-audios');
Route::post('/delete-trim-audios/{id}', [AudioTrimController::class, 'delTrimAudio'])->name('del-trim-audio');
Route::get('/trim-audio1/{type?}/{id?}', [AudioTrimController::class, 'trimPage'])->name('trim-page');
// Route::get('audio_trim/{Audio_trim}/trim', [AudioTrimController::class, 'trim'])
Route::post('/correction-delete/{id}', [AudioTrimController::class, 'correctionDelete'])->name('correction.delete');
// ->name('audio_trims.trim');
Route::get('/push-notificaiton', [NotificationController::class, 'index'])->name('push-notificaiton');
Route::post('/store-token', [NotificationController::class, 'storeToken'])->name('store.token');
Route::post('/send-notification', [NotificationController::class, 'sendNotification'])->name('send.notification');
Route::post('/clear-notification', [NotificationController::class, 'clearNotification'])->name('clear.notification');
Route::post('/submit_sentence_data', [DataCollectionController::class, 'submitSentence'])->name('submit.sentence');

//monu code start
Route::get('/get-audio-trim-data/{id}', [AudioTrimController::class, 'getAudioTrimData'])->name('get-audio-trim-data');
Route::post('/update-audio-trim', [AudioTrimController::class, 'updateAudioTrim'])->name('update-audio-trim');









