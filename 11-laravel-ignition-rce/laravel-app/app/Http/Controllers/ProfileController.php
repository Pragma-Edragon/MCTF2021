<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\User;

class ProfileController extends Controller
{
    public function profile(Request $request){
        $sess_data = [Auth::user()->getAuthIdentifierName()=>Auth::user()->getAuthIdentifier()];
        $db_data = User::find(Auth::user()->getAuthIdentifier())->toArray();
        return view('index', array_filter($db_data));
    }
}
