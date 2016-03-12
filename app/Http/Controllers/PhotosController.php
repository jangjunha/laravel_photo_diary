<?php

namespace App\Http\Controllers;

use \Hash;
use App\Password;
use App\Photo;
use Illuminate\Http\Request;
use DateTime;
use Log;

class PhotosController extends Controller
{
    const UPLOAD_DIR = 'upload/photos';

    private static function is_authenticated(Request $request) {
        return $request->session()->has('password_id');
    }


    public function list() {
        $photos = Photo::all();
        return view('list', ['photos' => $photos]);
    }

    public function view(Photo $photo) {
        return view('detail', ['photo' => $photo]);
    }

    public function upload_form(Request $request) {
        if (!$this->is_authenticated($request)) {
            return redirect(route('photos::upload_auth'));
        }

        return view('upload');
    }

    public function upload_auth(Request $request) {
        $user_password = $request->input('password');

        $authenticated = false;
        foreach (Password::all() as $password) {
            if (Hash::check($user_password, $password->password)) {
                $authenticated = true;
                $password_id = $password->id;
                break;
            }
        }

        if ($authenticated) {
            $request->session()->put('password_id', $password_id);
            return redirect(route('photos::upload_form'));
        }

        return redirect()->back()->withErrors(['Authentication Failed.']);
    }

    public function create(Request $request) {
        # Check Authentication
        if (!$this->is_authenticated($request)) {
            return redirect(route('photos::upload_auth'));
        }

        # Validate forms
        $this->validate($request, [
            'title' => 'required',
            'description' => 'required'
        ]);

        $title         = $request->input('title');
        $description   = $request->input('description');

        # Validate image
        if (!$request->hasFile('image') || !$request->file('image')->isvalid()) {
            return redirect()->back()->withErrors(['Image is not valid.']);
        }

        # Validate image extension
        $ext = strtolower($request->file('image')->getClientOriginalExtension());
        if (!in_array($ext, ['jpg', 'jpeg', 'png', 'gif'])) {
            return redirect()->back()->withErrors(['Image extension is not valid. (jpg|jpeg|png|gif allowed)']);
        }

        # Create DB Entity
        $photo = new Photo;
        $photo->title = $title;
        $photo->description = $description;

        # Randomly create filename and Save image
        $date = new DateTime();
        $file_name = rand(10000, 99999).'_'.$date->getTimestamp().'.'.$ext;

        $request->file('image')->move(self::UPLOAD_DIR, $file_name);

        $photo->image = '/'.self::UPLOAD_DIR.'/'.$file_name;
        $photo->save();

        # Clear Authentication
        $request->session()->forget('password_id');

        return redirect(route('photos::list'));
    }
}
