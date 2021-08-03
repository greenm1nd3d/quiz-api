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

        $basic_rules = [
            'email' => 'required|email|unique:users,email|max:100',
            'password' => [
                'required',
                'min:8',
                'regex:/\d/',
                'regex:/\W/',
            ],
            'fname' => [
                'required',
                'min:2',
                'max:30',
                'regex:/^[-a-zA-Z .]+$/',
            ],
            'lname' => [
                'required',
                'min:2',
                'max:30',
                'regex:/^[-a-zA-Z .]+$/',
            ],
            'alias' => [
                'required',
                'min:4',
                'max:30',
                'regex:/^[-a-zA-Z.]+$/',
            ],
            'bdate' => 'required|date',
        ];

        if ($request->user_type === 'C') {
            $extra_rules = [
                'about' => 'max|255',
                'country' => 'size:2',
                'referrer' => 'nullable|exists:users,id'
            ];

            $data = [
                'email' => $request->email,
                'password' => $request->password,
                'fname' => $request->fname,
                'lname' => $request->lname,
                'alias' => $request->alias,
                'bdate' => $request->bdate,
                'country' => $request->country,
                'referrer' => $request->referrer
            ];
        } elseif ($request->user_type === 'P') {
            $extra_rules = [];

            $data = [
                'email' => $request->email,
                'password' => $request->password,
                'fname' => $request->fname,
                'lname' => $request->lname,
                'alias' => $request->alias,
                'bdate' => $request->bdate
            ];
        } else {
            return response()->json([
                'error' => 'Valid user type is required'
            ], 401);
        }

        $rules = array_merge($basic_rules, $extra_rules);
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
            'user_type' => 'C',
            'referrer' => $request->referrer,
            'status' => 'A'
        ];
        $user = User::create($user_data);

        Log::debug("User account {$user->id} successfully created");

        if ($request->user_type === 'C') {
            // save data to the creators table
            $creator_data = [
                'user_id' => $user->id,
                'fname' => $request->fname,
                'lname' => $request->lname,
                'alias' => strtolower($request->alias),
                'bdate' => $request->bdate,
                'country' => $request->country,
                'referrer' => $request->referrer
            ];
            Creator::create($creator_data);

            Log::debug("Content Creator account {$user->id} successfully created");
        } else {
            // save data to the patrons table
            $creator_data = [
                'user_id' => $user->id,
                'fname' => $request->fname,
                'lname' => $request->lname,
                'alias' => strtolower($request->alias),
                'bdate' => $request->bdate
            ];
            Patron::create($creator_data);

            Log::debug("Patron account {$user->id} successfully created");
        }

        return response()->json([
            'content' => 'User account successfully created'
        ], 201);
    }

    public function getUserDetails(Request $request) {
        $user = $request->user();
        if ($user->user_type === 'C') {
            return [
                'account' => $user,
                'personal' => $user->creator,
                'posts' => $user->posts
            ];
        }

        return [
            'account' => $user,
            'personal' => $user->patron
        ];
    }

    public function getUserContents(Request $request) {
        $user = $request->user();
        if ($user->user_type === 'C') {
            return [
                'posts' => $user->posts,
                'galleries' => $user->galleries
            ];
        }

        return [
            'account' => $user,
            'personal' => $user->patron
        ];
    }
}