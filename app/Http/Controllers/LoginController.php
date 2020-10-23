<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Request;
use Illuminate\Support\Facades\Response;

class LoginController extends Controller
{
    public function token() {
		$credentials = Request::only('email', 'password');
		
		if (Auth::attempt($credentials)) {
			return Response::json(Auth::user()->api_token);
		}
		return Response::json("Invalid username / password combination.", 403);
	}
}
