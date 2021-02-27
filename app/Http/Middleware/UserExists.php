<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class UserExists
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle(Request $request, Closure $next)
    {
        $body = $request->json()->all();

        $user = DB::table('users')
            ->where('email', $body['email'])
            ->orWhere('username', $body['username'])
            ->get();

        if (isset($user[0]->id))
        {
            return response()->json([
                'status' => 'fail',
                'content' => 'Username or Email already exists'
            ]);
        }

        return $next($request);
    }
}
