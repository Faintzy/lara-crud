<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Helpers\Validate;
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
}
