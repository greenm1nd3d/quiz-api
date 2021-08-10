<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Repositories\Email\IEmail;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Log;
use Validator;

use App\Models\Creator;
use App\Models\Patron;
use App\Models\User;


class UserController extends Controller
{
    public function __construct() {

    }

    public function index() {
        return "Boo!";
    }

    public function createAccount(Request $request) {
        Log::debug("Attempting to create user account...");

        $rules = [
            'email' => 'required|email|unique:users,email|max:100',
            'password' => [
                'required',
                'min:8',
                'regex:/\d/',
                'regex:/\W/',
            ],
            'first_name' => [
                'required',
                'min:2',
                'max:30',
                'regex:/^[-a-zA-Z .]+$/',
            ],
            'last_name' => [
                'required',
                'min:2',
                'max:30',
                'regex:/^[-a-zA-Z .]+$/',
            ]
        ];

        $data = [
            'email' => $request->email,
            'password' => $request->password,
            'first_name' => $request->first_name,
            'last_name' => $request->last_name
        ];

        $validator = Validator::make($data, $rules);

        if ($validator->fails()) {
            return response()->json([
                'error' => $validator->errors()
            ], 401);
        }

        $password = Hash::make($request->password, [
            'rounds' => 12,
        ]);

        // save data to the users table
        $user_data = [
            'email' => $request->email,
            'password' => $password,
            'first_name' => $request->first_name,
            'last_name' => $request->last_name,
            'status' => 'A'
        ];
        $user = User::create($user_data);

        Log::debug("User account {$user->id} successfully created");

        return response()->json([
            'content' => 'User account successfully created'
        ], 201);
    }
}