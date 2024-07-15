<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\Controller;
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

    public function categories(Request $request)
    {
      try{

        if($request->server()['HTTP_AUTHORIZATION'])
        {
            return response()->json([
                "code" => "200",
                'message' => "عمليه ناجحه",
                "serviceListVersion" => "82",
                "serviceList" => [
                        "id" => 1,
                        "name" => "خدمات ممكن",
                        "parentID" => 0,
                        "lastNode" => false,
                        "index" => 0,
                        "level" => 0,
                        "serviceSubCategoryLabel" => "",
                        "services" => [],
                        "serviceCategory" => [
                                "id" => 195,
                                "name" => "مواصلات",
                                "parentID" => 1,
                                "lastNode" => false,
                                "index" => 195,
                                "level" => 2,
                                "serviceSubCategoryLabel" => "الشركه",
                                "services" => [],
                                "serviceCategory" => [
                                        "id" => 196,
                                        "name" => "جوباص",
                                        "parentID" => 195,
                                        "lastNode" => true,
                                        "index" => 196,
                                        "level" => 3,
                                        "serviceSubCategoryLabel" => "",
                                        "services" => [
                                                "serviceID" => 646,
                                                "serviceName" => "جو باص",
                                                "value" => 0.00,
                                                "categoryTitle" => "",
                                                "paymentModeID" => 1,
                                                "status" => 1,
                                                "currency" => "مصري",
                                                "minValue" => 1.00,
                                                "maxValue" => 1000000.00,
                                                "interval" => 5,
                                                "inquirable" => true,
                                                "billPaymentModeID" => 1,
                                                "serviceTypeID" => 3,
                                                "serviceParameter" => [
                                                        "label" => "الرقم الالكترونى",
                                                        "title" => "برجاء ادخال الرقم الالكترونى",
                                                        "valueModeID" => "2",
                                                        "valueTypeID" => "1",
                                                        "optional" => false,
                                                        "sequence" => "1",
                                                        "key" => "customerNumber",
                                                        "valueList" => [
                                                                "values" => []
                                                            ],
                                                        "value" => "0",
                                                        "validationExpression" => "^[0-9]{1,30}$",
                                                        "validationMessage" => "الرقم غير صحيح",
                                                        "methodIds" => "1",
                                                        "displayed" => true
                                                    ]
                                            ],
                                        "serviceCategory" => []


                                    ]

                            ]
                    ]

            ], 200);
        }else{
            return response()->json([
                "Code" => -16,
                "Message" => "لا توجد بيانات"
            ], 401);
        }
      }catch(Throwable $th){
            return response()->json([
                "code" => '500',
                "message" => 'فشل تسحيل الدخول',
            ],401);
      }
        
    }

    public function inquiry($serviceId, Request $request)
    {
        // dd($request->json());
        $req = $request->validate([
            'BillingAccount' => 'required',
            'Version' => 'required',
            'ServiceListVersion' => 'required',
            // 'Data' => 'optional',
        ]);

        if($req){
            try{
                return response()->json([
                    "Code" => 200,
                    "Message" => "عمليه ناجحه",
                    "TotalAmount" => 21995.0,
                    "Brn" => 145147,
                    "Data" => [
                        [
                            "key" => "CustomerName",
                            "value" => "سميحه وليم حنا",
                            "name" => "اسم العميل",
                        ],
                        [
                            "key" => "Installment",
                            "value" => "21995",
                            "name" => "القسط"
                        ],
                        [
                            "key" => "Penalty",
                            "value" => "2000",
                            "name" => "الغرامة"
                        ]
                    ],

                    "Invoices" => [

                        "Amount" => 21995.0,
                        "Sequence" => 2,
                        "mandatory" => "true",
                        "minAmount" => 21995.0,
                        "maxAmount" => 21995.0,
                        "alias" => null,
                        "Data" => []

                    ]
                ], 200);
            }
            catch(Throwable $th){
                return response()->json([
                    "code" => -31,
                    "message" => "رقم تلفون غير صحيح ",
                ], -31);
            }
        }
        else{
            return response()->json([
                "Code" => -13,
                "Message" => "يوجد بيانات ناقصة"

            ], -13);
        }
        
    }
}