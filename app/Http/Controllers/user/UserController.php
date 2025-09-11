<?php

namespace App\Http\Controllers\user;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
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
            try {
                $request->validate([
                    "userPhoto" => "required|mimes:jpeg,png,jpg,svg",
                ]);
                $user = User::find(Auth::user()->id);
                $previous_img = explode($request->getSchemeAndHttpHost(), $user->profile_url)[1];
                if (Storage::disk('public')->exists($previous_img)) {
                    Storage::disk('public')->delete($previous_img);
                }
                $img_url = $request->file("userPhoto")->store("avatar", 'public');
                $user->profile_url = asset($img_url);
                $user->save();
                return redirect()->back()->with("SuccessMessage", "Profile is updated successfully.");
            } catch (\Throwable $th) {
                Log::error($th->getMessage());
                return redirect()->back()->with("ErrorMessage", "Something went wrong try again.");
            }
        }
    }
}
