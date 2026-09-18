<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;

class AuthController extends Controller
{

    public function login(Request $request)
    {

        if ($request->isMethod("post")) {

            $validator = $request->validate([
                "email" => "required|max:225",
                "password" => "required"
            ]);

            try {
                $user = User::where("email", $validator["email"])->firstOrFail();
                if (Auth::attempt($validator, true)) {
                    if ($user->hasRole('super-admin')) {
                        return redirect()->route("dashboard")->with("SuccessMessage", "Admin is logged successfully!");
                    }
                    return redirect()->back()->with('SuccessMessage', 'Logged in successfully.');
                } else {
                    return redirect("/login")->with("ErrorMessage", "User details are invalid.");
                }
            } catch (\Throwable $th) {
                Log::error($th->getMessage());
                return redirect()->back()->with("ErrorMessage", "Something went wrong try again.");
            }
        }
        return view('admin/login');
    }

    public function register(Request $request)
    {


        if ($request->isMethod('post')) {

            $validator = $request->validate([
                "name" => 'required|max:225',
                "email" => 'required|unique:users,email',
                "password" => 'required'
            ]);


            try {
                $user = User::create([
                    "name" => $validator["name"],
                    "email" => $validator["email"],
                    "password" => bcrypt($validator["password"])
                ]);


                // if (Auth::attempt($validator)) {
                return redirect()->back()->with("SuccessMessage", "We have sent email verification link.");
                // } else {
                //     return redirect("/login")->with("SuccessMessage", "registered successfully!");
                // }
            } catch (\Throwable $th) {
                Log::error($th->getMessage());
                return redirect()->back()->with("ErrorMessage", "Can't register");
            }
        }

        return view('admin/register');
    }
    public function verifyOtp(Request $request)
    {


        if ($request->isMethod('post')) {

            $validator = $request->validate([
                "email" => 'required|unique:users,email',
                "otp" => 'required|max:6'
            ]);


            try {


                // if (Auth::attempt($validator)) {
                //     return redirect("/")->with("SuccessMessage", "registered successfully!");
                // } else {
                //     return redirect("/login")->with("SuccessMessage", "registered successfully!");
                // }
                return print_r($request);
            } catch (\Throwable $th) {
                return redirect()->back()->with("ErrorMessage", "Can't Verify Try Again!.");
                // echo "exception is executed";
            }
        }

        return view('admin/otp');
    }

    public function logout(Request $request)
    {
        // print_r(Auth::user());
        $request->session()->flush();
        Auth::logout();
        return redirect()->to('/');
    }
}
