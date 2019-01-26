<?php

namespace App\Http\Controllers;

use Laravel\Lumen\Routing\Controller as BaseController;
use Illuminate\Support\Facades\Hash;
use App\User;
use App\Post;
use Illuminate\Http\Request;
use Firebase\JWT\ExpiredException;
use Firebase\JWT\JWT;

class UserController extends BaseController
{
    public function index()
    {
        return User::all();
    }

    public function test()
    {
        /*
         * @author Ericsson Budhilaw <budhilaw.mail@gmail.com>
         * -------------------
         * Creating user test
         * -------------------
         */
        $fillable = [
            'name' => 'Kai',
            'email' => 'kai@gmail.com',
            'password' => Hash::make('1550')
        ];

        $user = new User($fillable);
        $user->password = Hash::make('1550');
        $user->save();

        return response()->json(compact('user'), 201);
    }

    public function create(Request $request)
    {
        /*
         * @author Ericsson Budhilaw <budhilaw.mail@gmail.com>
         * -------------------
         * Validation process
         * -------------------
         */
        $this->validate($request, [
            'name' => 'required',
            'email' => 'required|email|unique:users',
            'password' => 'required'
        ]);

        $hashed = Hash::make($request->input('password'));

        $fillable = [
            'name' => $request->input('name'),
            'email' => $request->input('email'),
            'password' => $hashed
        ];

        /*
         * @author Ericsson Budhilaw <budhilaw.mail@gmail.com>
         * -------------------
         * Create a user
         * -------------------
         */
        $user = new User($fillable);
        $user->password = $hashed;
        $user->save();

        return response()->json([
            'status' => 'The user data has been created!'
        ], 200);
    }

    public function show($id)
    {
        /*
         * @author Ericsson Budhilaw <budhilaw.mail@gmail.com>
         * -------------------
         * Get a user by id
         * -------------------
         */
        $data = User::find($id);

        if( !$data )
        {
            return response()->json([
                'status' => 'User not found!'
            ], 404);
        }

        return response()->json(compact('data'), 200);
    }

    public function edit(Request $request, $id)
    {
        /*
         * @author Ericsson Budhilaw <budhilaw.mail@gmail.com>
         * -------------------
         * Validation process
         * -------------------
         */
        $this->validate($request, [
            'name' => 'required',
            'email' => 'required|email|unique:users',
            'password' => 'required'
        ]);

        /*
         * @author Ericsson Budhilaw <budhilaw.mail@gmail.com>
         * -------------------
         * Saving process
         * -------------------
         */
        $data = User::where('_id', $id)->first();
        $data->name = $request->input('name');
        $data->username = $request->input('username');
        $data->email = $request->input('email');
        $data->password = Hash::make($request->input('password'));
        $data->save();

        return response()->json([
            'status' => 'The user data successfuly edited!'
        ], 200);
    }
}