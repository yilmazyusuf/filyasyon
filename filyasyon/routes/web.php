<?php

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

Auth::routes([
    'register' => false, // Registration Routes...
    'reset'    => false, // Password Reset Routes...
    'verify'   => false, // Email Verification Routes...
]);

Route::middleware(['auth'])->group(function () {

    Route::resource('/users', 'UserController');
    Route::get('/users/index/data_table', 'UserController@indexDataTable')->name('users.index.data_table');

    //<editor-fold desc="Patient">
    Route::resource('/patient', 'PatientController');
    Route::get('/patient/index/data_table', 'PatientController@indexDataTable')->name('patient.index.data_table');

    Route::get('/patient/{id}/daily_checks', 'PatientController@dailyChecks')->name('patient.daily_checks');
    Route::post('/patient/{id}/daily_checks', 'PatientController@saveDailyChecks')->name('patient.daily_checks.save');

    Route::get('/patients/daily_checks/{patientIds}', 'PatientController@batchDailyChecks')->name('patient.batch_daily_checks');
    Route::post('/patients/daily_checks/{patientIds}', 'PatientController@saveBatchDailyChecks')->name('patient.batch_daily_checks.save');


    Route::get('/patient/{id}/vaccines', 'PatientController@vaccines')->name('patient.vaccines');
    Route::post('/patient/{id}/vaccines', 'PatientController@saveVaccines')->name('patient.vaccines.save');

    //</editor-fold>

    //<editor-fold desc="Districts">
    Route::post('/neighborhoods_by_village/{villageId}', 'DistrictsController@neighborhoodsByVillage')->name('districts.neighborhoods');
    //</editor-fold>


});


