<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;

class LoginController extends Controller
{
    public function login_post(Request $request) {
        $validator = Validator::make($request->all(),[
            'email'=>'email:rfc,dns|max:32|required',
            'password'=>'required|max:32'
        ]);

        if ($validator->fails()) {
            return redirect()->back()
                ->withErrors($validator->errors())
                ->withInput();
        }

        $validated = $validator->validated();
        $validated = $validator->safe()->except("_token");
        if (!Auth::attempt($validated)) {
            return redirect("login");
        }
        return redirect("profile");
    }
}
