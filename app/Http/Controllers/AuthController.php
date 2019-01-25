<?php

namespace App\Http\Controllers;

use Laravel\Lumen\Routing\Controller as BaseController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Firebase\JWT\JWT;
use Firebase\JWT\ExpiredException;
use App\User;
use Illuminate\Validation\Validator;

class AuthController extends BaseController
{
    private $request;

    public function __construct(Request $request)
    {
        $this->request = $request;
    }

    protected function jwt(User $user) {
        $payload = [
            'iss' => "lumen-jwt", // Issuer of the token
            'sub' => $user->id, // Subject of the token
            'iat' => time(), // Time when JWT was issued.
            'exp' => time() + 60*60 // Expiration time
        ];
        return JWT::encode($payload, env('JWT_SECRET'));
    }

    public function authenticate(User $user)
    {
        $this->validate($this->request, [
            'email' => 'required|email',
            'password' => 'required'
        ]);

        $user = User::where('email', $this->request->input('email'))->first();

        if( !$user )
        {
            return response()->json([
                'error' => 'Email does not exist'
            ], 400);
        }

        if( Hash::check($this->request->input('password'), $user->password) )
        {
            return response()->json([
                'token' => $this->jwt($user)
            ], 200);
        }

        return response()->json([
            'error' => 'Email or Password is wrong..'
        ], 400);
    }
}
