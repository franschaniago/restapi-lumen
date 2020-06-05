<?php

namespace App\Http\Controllers;

use App\Model\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class UserController extends Controller
{
    public function register(Request $req)
    {
        $this->validate($req, [
            'email' => 'required|unique:users|email',
            'password' => 'required|min:6'
        ]);

        $email = $req->input('email');
        $pwd = $req->input('password');
        $hashPwd = Hash::make($pwd);

        $user = User::create([
        	'email' => $email,
        	'password' => $hashPwd
        ]);

        return response()->json(['message' => 'Success'],201);
    }

    public function show()
    {
    	$data = User::all();

        return response()->json($data);
    }

    public function login(Request $req)
    {
    	$this->validate($req, [
    		'email' => 'required|email',
    		'password' => 'required|min:6',
    	]);

    	$email = $req->input('email');
    	$pwd = $req->input('password');

    	$user = User::where('email',$email)->first();

    	if(!$user)
    	{
    		return response()->json(['message' => 'Login gagal'],401);
    	}

    	$checkPwd = Hash::check($pwd,$user->password);

    	if(!$checkPwd)
    	{
    		return response()->json(['message' => 'Password salah'],401);
    	}

    	$token = bin2hex(random_bytes(40));

    	$user->update([
    		'token' => $token
    	]);

    	return response()->json($user);
    }
}
