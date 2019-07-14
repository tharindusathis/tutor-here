<?php

use Illuminate\Http\Request;

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


Route::get('learners',			'LearnerController@index');
Route::get('learnerlocations',	'LearnerlocationController@index');
Route::get('payments',			'PaymentController@index');
Route::get('qualifications',	'QualificationController@index');
Route::get('requests',			'RequestController@index');
Route::get('reviews',			'ReviewController@index');
Route::get('singletimeslots',	'SingletimeslotController@index');
Route::get('subjects',			'SubjectController@index');
Route::get('tuitions',			'TuitionController@index');
Route::get('tutors',			'TutorController@index');
Route::get('tutorlocations',	'TutorlocationController@index');
Route::get('weeklytimeslots',	'WeeklytimeslotController@index');

Route::get('learners/{id}',			'LearnerController@show');
Route::get('learnerlocations/{id}',	'LearnerlocationController@show');
Route::get('payments/{id}',			'PaymentController@show');
Route::get('qualifications/{id}',	'QualificationController@show');
Route::get('requests/{id}',			'RequestController@show');
Route::get('reviews/{id}',			'ReviewController@show');
Route::get('singletimeslots/{id}',	'SingletimeslotController@show');
Route::get('subjects/{id}',			'SubjectController@show');
Route::get('tuitions/{id}',			'TuitionController@show');
Route::get('tutors/{id}',			'TutorController@show');
Route::get('tutorlocations/{id}',	'TutorlocationController@show');
Route::get('weeklytimeslots/{id}',	'WeeklytimeslotController@show');

Route::post('learners',			'LearnerController@store');
Route::post('learnerlocations',	'LearnerlocationController@store');
Route::post('payments',			'PaymentController@store');
Route::post('qualifications',	'QualificationController@store');
Route::post('requests',			'RequestController@store');
Route::post('reviews',			'ReviewController@store');
Route::post('singletimeslots',	'SingletimeslotController@store');
Route::post('subjects',			'SubjectController@store');
Route::post('tuitions',			'TuitionController@store');
Route::post('tutors',			'TutorController@store');
Route::post('tutorlocations',	'TutorlocationController@store');
Route::post('weeklytimeslots',	'WeeklytimeslotController@store');

Route::put('learners/{id}',			'LearnerController@update');
Route::put('learnerlocations/{id}',	'LearnerlocationController@update');
Route::put('payments/{id}',			'PaymentController@update');
Route::put('qualifications/{id}',	'QualificationController@update');
Route::put('requests/{id}',			'RequestController@update');
Route::put('reviews/{id}',			'ReviewController@update');
Route::put('singletimeslots/{id}',	'SingletimeslotController@update');
Route::put('subjects/{id}',			'SubjectController@update');
Route::put('tuitions/{id}',			'TuitionController@update');
Route::put('tutors/{id}',			'TutorController@update');
Route::put('tutorlocations/{id}',	'TutorlocationController@update');
Route::put('weeklytimeslots/{id}',	'WeeklytimeslotController@update');

Route::delete('learners/{id}',			'LearnerController@delete');
Route::delete('learnerlocations/{id}',	'LearnerlocationController@delete');
Route::delete('payments/{id}',			'PaymentController@delete');
Route::delete('qualifications/{id}',	'QualificationController@delete');
Route::delete('requests/{id}',			'RequestController@delete');
Route::delete('reviews/{id}',			'ReviewController@delete');
Route::delete('singletimeslots/{id}',	'SingletimeslotController@delete');
Route::delete('subjects/{id}',			'SubjectController@delete');
Route::delete('tuitions/{id}',			'TuitionController@delete');
Route::delete('tutors/{id}',			'TutorController@delete');
Route::delete('tutorlocations/{id}',	'TutorlocationController@delete');
Route::delete('weeklytimeslots/{id}',	'WeeklytimeslotController@delete');

//subjects
Route::get('subjects_dist',
			'SubjectController@distinct');

Route::get('tutors/{id}/subjects',			'TutorController@subjects');
Route::get('tutors/{id}/locations',			'TutorController@locations');
Route::get('tutors/{id}/singletimeslots',			'TutorController@singletimeslots');
Route::get('tutors/{id}/weeklytimeslots',			'TutorController@weeklytimeslots');
Route::get('learners/{id}/locations',			'LearnerController@locations');

Route::post('tutors/search', 'TutorController@findTutorsWithGrade');
Route::post('subjects/search/grades', 'SubjectController@findGrades');


Route::get('subjects/search/subjects', 'SubjectController@findSubjects');
Route::get('mail', 'SubjectController@mail');



//Route::middleware('auth:api')->get('/user', function (Request $request) {
//    return $request->user();
//});

Route::group([
    'prefix' => 'auth'
], function () {
    Route::post('login', 'AuthController@login');
    Route::post('signup', 'AuthController@signup');

    Route::get('signup/activate/{token}', 'AuthController@signupActivate');

    Route::group([
        'middleware' => 'auth:api'
    ], function() {
        Route::get('logout', 'AuthController@logout');
        Route::get('user', 'AuthController@user');
    });
});