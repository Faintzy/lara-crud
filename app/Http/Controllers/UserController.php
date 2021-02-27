<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Helpers\Validate;
use Illuminate\Support\Facades\DB;
use App\Models\User;

class UserController extends Controller
{
    public function create(Request $request)
    {
        $body = $request->json()->all();

        $body['password'] = md5($body['password']);

        $rules = [
            'email' => 'required|email',
            'username' => 'required|min:4',
            'password' => 'required|min:6'
        ];

        $validator = $this->getValidationFactory()
            ->make($body, $rules);
            
        if ($validator->fails())
        {
            return response()->json([
                'status' => 'fail',
                'content' => $validator->getMessageBag()
            ], 401);
        }

        $created = User::create($body);

        return response()->json([
            'status' => 'ok',
            'content' => 'User created successful'
        ]);
    }

    public function auth(Request $request)
    {
        $body = $request->json()->all();

        $rules = [
            'email' => 'required|email'
        ];

        $validator = $this->getValidationFactory()
            ->make($body, $rules);

        if ($validator->fails())
        {
            return response()->json([
                'status' => 'fail',
                'content' => $validator->getMessageBag()
            ]);
        }

        $user = DB::table('users')
            ->where('email', $body['email'])
            ->where('password', md5($body['password']))
            ->get();

        if (count($user) == 0)
        {
            return response()->json([
                'status' => 'fail',
                'content' => 'Incorrect credentials'
            ]);
        }

        return response()->json([
            'status' => 'ok',
            'content' => 'authenticated successful'
        ]);
    }
}
