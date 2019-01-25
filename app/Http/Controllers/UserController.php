<?php

namespace App\Http\Controllers;

use Laravel\Lumen\Routing\Controller as BaseController;
use Illuminate\Support\Facades\Hash;
use App\User;
use Illuminate\Http\Request;

class UserController extends BaseController
{
    public function index()
    {
        return User::all();
    }

    public function test()
    {
        $fillable = [
            'name' => 'Kai',
            'username' => 'kai',
            'email' => 'kai@gmail.com',
            'password' => Hash::make('1550')
        ];

        $user = new User($fillable);
        $user->password = Hash::make('1550');
        $user->save();
    }

    public function create(Request $request)
    {
        $hashed = Hash::make($request->input('password'));

        $fillable = [
            'name' => $request->input('name'),
            'username' => $request->input('username'),
            'email' => $request->input('email'),
            'password' => $hashed
        ];

        $user = new User($fillable);
        $user->password = $hashed;
        $user->save();
    }

    public function show($id)
    {
        $data = User::findOrFail($id);
        return $data;
    }

    public function edit(Request $request, $id)
    {
        $data = User::where('_id', $id)->first();
        $data->name = $request->input('name');
        $data->username = $request->input('username');
        $data->email = $request->input('email');
        $data->password = Hash::make($request->input('password'));
        $data->save();
        return response()->json([
            'status' => 'Data submitted'
        ], 200);
    }
}