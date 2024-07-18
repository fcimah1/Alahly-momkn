<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Http;
use Throwable;

class AuthController extends Controller
{
    /**
     * Create a new AuthController instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth:api', ['except' => ['login']]);
    }

    /**
     * Get a JWT via given credentials.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function login()
    {
        // dd(env('USER_NAME'));
        $credentials = ['username' => env('USER_NAME'),'password' =>  env('USER_PASSWORD')];

        if (! $token = auth()->attempt($credentials)) {
            return response()->json(['error' => 'لم يتم تسحيل الدخول'], 401);
        }

        //         $user->update(['api_token' => $token]);

        return $this->respondWithToken($token);
    }

  
    /**
     * Get the authenticated User.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function me()
    {
        return response()->json(auth()->user());
    }

    /**
     * Log the user out (Invalidate the token).
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function logout()
    {
        auth()->logout();

        return response()->json(['message' => 'Successfully logged out']);
    }

    /**
     * Refresh a token.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function refresh()
    {
        return $this->respondWithToken(auth()->refresh());
    }

    /**
     * Get the token array structure.
     *
     * @param  string $token
     *
     * @return \Illuminate\Http\JsonResponse
     */
    protected function respondWithToken($token)
    {
        return response()->json([
            'access_token' => $token,
            'username' => auth()->user()->username,
            'code' => '200',
            'message' => 'عمليه ناجحه',
            'token_type' => 'bearer',
            'accountId' => auth()->user()->id,
            'acountName' => auth()->user()->name,
            'balance' => auth()->user()->balance,
            'availableBalance' => auth()->user()->balance,
            'expires_in' => auth()->factory()->getTTL() * 60 * 24
        ], 200);
    }

    public function getBalance()
    {
       $balance = User::findOrFail(auth()->user()->id);
    //    dd($balance);
        
        return response()->json([
            "Code" => 200,
            "Message" => "Success",
            "TotalBalance" => $balance->balance,
        ]);
    }

    public function changePassword(Request $request)
    {
        $req = $request->validate([
            'username' => 'required',
            'password' => 'required',
            'newPassword' => 'required'
        ]);
        if(password_verify($request->password,auth()->user()->password)){

            User::where('id', auth()->user()->id)->update(['password'=> encrypt($request->newPassword)]);
            $token = auth()->user()->accessToken;
            return response()->json([
                "Code" => 200,
                "Message" => 'تم تغير كلمه السر بنجاح',
                "LocalDate" => "0001-01-01T00:00:00",
                "ServerDate" => "0001-01-01T00:00:00",
                "Token" => $token
            ]);
        }else{
            return response()->json([
                "Code" => 401,
                "Message" => 'كلمه السر غير صحيحه'
            ]);
        }
    }
}