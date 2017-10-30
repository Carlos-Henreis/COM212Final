<?php

namespace App\Http\Controllers;

use DB;
use App\Http\Requests;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\User;


class HomeController extends Controller
{

    public function __construct()
    {
        $this->middleware('auth');
    } 


    public function index()
    {   
        return view('home');
    }

    public function edit() {
        $user = Auth::guard('user')->user();
        return view('auth.edit', compact('user'));
    }
    
    public function update(Request $request) {

        try {
            $User = User::find(Auth::guard('user')->user()->id)->update($request->all());
            $ok = true;
            return view ('home', compact('ok'));
        } catch (\Illuminate\Database\QueryException $e) {
            $ok = false;;
            return view ('home', compact('ok', 'e'));
        }
        
    }
}
 