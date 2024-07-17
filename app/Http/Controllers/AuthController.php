<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
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
        $credentials = request(['username', 'password']);

        // dd($credentials);
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
            'localDate' => date('c') ,
            'serverDate' => date('c'),
            'accountType' => auth()->user()->role,
            'serviceListVersion' => '1.0',
            'version ' => '1',
            'balance' => 'auth()->user()->balance',
            'availableBalance' => 'auth()->user()->balance',
            'expires_in' => auth()->factory()->getTTL() * 60 * 24
        ], 200);
    }

    public function getBalance($accountId)
    {
       // $balance = User::findOrFail($accountId);
        return response()->json([
            "Code" => 200,
            "Message" => "Success",
            "TotalAvailableBalance" => 438808.951,
            "Points" => 29.0,
            "TotalBalance" => 438903.855,
            "Balances" => [
                [
                    "ID" => 1,
                    "Name" => "ممكن رصيد",
                    "Balance" => 438888.855,
                    "AvailableBalance" => 438808.951
                ],
                [
                    "ID" => 2,
                    "Name" => "Nameرصيد كاش",
                    "Balance" => 15.0,
                    "AvailableBalance" => 0.0
                ]
            ]
        ]);
    }

    public function changePassword(Request $request)
    {
        $req = $request->validate([
            'username' => 'required',
            'password' => 'required',
            'changeType' => 'required',
            'newPassword' => 'required'
        ]);
        if(Auth()->attempt(['password'])){
            User::where('id')->set(['password',$request->newPassword]);
            return response()->json([
                "Message" => 'ناجحه عمليه',
                "Code" => 200,
                "AccountId" => 6,
                "LocalDate" => "0001-01-01T00:00:00",
                "ServerDate" => "0001-01-01T00:00:00",
                "Token" => "eyJhbGciOiJIUzI1NiIsInR5cCI6IkpXVCJ9.eyJ1bmlxdWVfbmFtZSI6IjExMXw2fDJ
                8MjIzMDciLCJ uYmYiOjE2MjI1NTIwNDEsImV4cCI6MTYyMjU1MjA0MSwiaWF0IjoxNjIyNTUyMDQxfQ.4
                3YcsKnRnsUPK UyIeys_HhoC1S5w4ehsRH9XdbhS8aY",
                "AccountName" => "IT",
                "AcountType" => 10,
                "ID" => 0,
                "ServiceListVersion" => null,
                "Version" => null,
                "Balance" => 0,
                "AvailableBalance" => 0
            ]);
        }
    }
}