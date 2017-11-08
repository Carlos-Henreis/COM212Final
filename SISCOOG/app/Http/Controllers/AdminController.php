<?php

namespace App\Http\Controllers;

use DB;
use Illuminate\Http\Request;
use App\Admin;
use App\Http\Requests;
use Illuminate\Support\Facades\Auth;

class AdminController extends Controller
{
    public function __construct(){
    	$this->middleware('admin');
    }

    public function index(){
    	// return Auth::guard('admin')->user();
    	return view('admin.dashboard');
    }

    public function edit() {
    	$admin = Auth::guard('admin')->user();
        return view('admin.auth.edit', compact('admin'));
    }
    
    public function update(Request $request) {

    	try {
        	$Admin = Admin::find(Auth::guard('admin')->user()->id)->update($request->all());
        	$ok = true;
        	return view ('admin.dashboard', compact('ok'));
	    } catch (\Illuminate\Database\QueryException $e) {
        	$ok = false;;
        	return view ('admin.dashboard', compact('ok', 'e'));
	    }
        
    }
}
