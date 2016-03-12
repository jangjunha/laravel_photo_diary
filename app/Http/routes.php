<?php

use Illuminate\Http\Request;
use App\Password;

/*
|--------------------------------------------------------------------------
| Routes File
|--------------------------------------------------------------------------
|
| Here is where you will register all of the routes in an application.
| It's a breeze. Simply tell Laravel the URIs it should respond to
| and give it the controller to call when that URI is requested.
|
*/

/*
|--------------------------------------------------------------------------
| Application Routes
|--------------------------------------------------------------------------
|
| This route group applies the "web" middleware group to every route
| it contains. The "web" middleware group is defined in your HTTP
| kernel and includes session state, CSRF protection, and more.
|
*/

Route::group(['middleware' => ['web']], function () {

    Route::get('/', function () {
        return redirect()->route('photos::list');
    });

    // Route::get('/register-password', function () {
    //     return view('get_password', [
    //         'title' => 'Register Password',
    //         'action' => '',
    //         'confirm' => true
    //     ]);
    // });
    //
    // Route::post('/register-password', function (Request $request) {
    //     $hashed_password = Hash::make($request->input('password'));
    //
    //     $password = new Password;
    //     $password->password = $hashed_password;
    //     $password->save();
    //
    //     return redirect('/');
    // });
});

Route::group(['prefix' => 'photos', 'as' => 'photos::', 'middleware' => ['web']], function () {
    Route::get('/', ['uses' => 'PhotosController@list', 'as' => 'list']);
    Route::get('/upload/auth', ['as' => 'upload_auth', function (Request $request) {
        return view('get_password', [
            'title' => 'Enter Password',
            'action' => '',
            'confirm' => false
        ]);
    }]);
    Route::post('/upload/auth', ['uses' => 'PhotosController@upload_auth']);
    Route::get('/upload', ['uses' => 'PhotosController@upload_form', 'as' => 'upload_form']);
    Route::post('/upload', ['uses' => 'PhotosController@create', 'as' => 'upload']);
    
    Route::get('/{photo}', ['uses' => 'PhotosController@view', 'as' => 'view']);
});
