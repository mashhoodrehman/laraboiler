<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;


class SmsUserController extends Controller
{
    public function index(){
    	return view('smsuser.index');	
    }

    public function create(){
    	return view('smsuser.create');
    }
}
