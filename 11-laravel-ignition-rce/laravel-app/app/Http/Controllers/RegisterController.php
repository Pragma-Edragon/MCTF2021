<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Hash;


class RegisterController extends Controller
{
    function register_post(Request $request) {
        $validator = Validator::make($request->all(), [
            'email'=>'required|unique:users|max:32|email:rfc,dns',
            'password'=>'required|max:32',
            'confirmpassword'=>'same:password',
            'name'=>"max:32"
            ]);

        if ($validator->fails()) {
            return redirect()->back()
                ->withErrors($validator)
                ->withInput();
        }

        $validated = $validator->validated();
        $validated = $validator->safe()->except(["_token", "confirmpassword"]);
        $validated["password"] = Hash::make($validated["password"]);
        User::create($validated);
        return redirect("login");
    }
}
