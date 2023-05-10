<?php

use Illuminate\Http\Request;
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

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

Route::post('/courses/insert', function () {
    DB::table('courses')
        ->insert(array('title' => $_POST['title'] ? $_POST['title'] : NULL,
                       'abbreviation' => $_POST['abbreviation'] ? $_POST['abbreviation'] : NULL,
                       'credits' => $_POST['credits'] ? $_POST['credits'] : NULL)
    );
    return redirect('/admin');
});

Route::post('/courses/delete', function () {
    DB::table('courses')
        ->where('id', $_POST['id'])
        ->delete();
    
    return redirect('/admin');
});

Route::post('/evaluations/insert', function () {
    DB::table('evaluations')
        ->insert(array('course_id' => $_POST['course_id'] ? $_POST['course_id'] : NULL,
                       'credits_given_date' => $_POST['credits_given_date'] ? $_POST['credits_given_date'] : NULL,
                       'points' => $_POST['points'] ? $_POST['points'] : NULL,
                       'grade' => $_POST['grade'] ? $_POST['grade'] : NULL,
                       'grade_date' => $_POST['grade_date'] ? $_POST['grade_date'] : NULL,
                       'semester' => $_POST['semester'] ? $_POST['semester'] : NULL)
    );
    return redirect('/admin');
});

Route::post('/evaluations/delete', function () {
    DB::table('evaluations')
        ->where('id', $_POST['id'])
        ->delete();
    
    return redirect('/admin');
});