<?php

namespace App\Http\Controllers\user;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class UserController extends Controller
{
    public function dashboard(Request $request)
    {
        return view('user/profile');
    }

    public function uploadPhoto(Request $request)
    {
        if ($request->isMethod("post")) {

            $validator = $request->validate([
                "userPhoto" => "required|mimes:jpeg,png,jpg,svg",
            ]);

            // $name = $request->file("userPhoto")->hashName();
            // echo $request->file("userPhoto")->extension();
            // Storage::disk("local")->put('example.txt', 'Contents');
            // Storage::disk("public")->put('example.txt', 'Contents');
            // Storage::put('avatars/example.txt', "Contents new");
            // Storage::put($name, "Contents new");
            // $contents = Storage::get('example.txt');
            // echo var_dump($contents);
            // return Storage::download('example.txt');
            // return Storage::url('example.txt');
            // $path = Storage::putFile('photos', $request->file("userPhoto"));
            // $path = Storage::putFileAs('photos', $request->file("userPhoto"), 'photo.jpg');
            // $path = $request->file("userPhoto")->storeAs("khetsingh","khetsingh.jpg");
            // $path = $request->file('userPhoto')->storeAs(
            //     'avatars', $request->user()->id."."."jpg"
            // );
            // $path =  Storage::delete('example.txt');
            // $files = Storage::files("avatars");
            //    print_r($files);

            try {
                $user = User::find(Auth::user()->id);

                if (Storage::disk('public')->exists($user->profile_url ?? false)) {
                    Storage::disk('public')->delete($user->profile_url ?? false);
                }

                $path = $request->file("userPhoto")->store("public/avatar");
                $user->profile_url = removeStorageFolderaImage($path);
                $result = $user->save();
                if ($result) {
                    return redirect()->back()->with("SuccessMessage", "Profile is updated successfully!");
                } else {
                    return redirect()->back()->with("ErrorMessage", "Something went wrong try again!.");
                }
            } catch (\Throwable $th) {
                // return redirect()->back()->with("ErrorMessage", "Something went wrong try again!.");

                die("throw error");
            }
        }
    }
}
