<?php

namespace App\Http\Controllers;

use App\Models\Category;
use Illuminate\Http\Request;
use Throwable;

class ServiceControoler extends Controller
{
    public function __construct()
    {
        $this->middleware('auth:api', ['except' => ['login']]);
    }
    public function inquiry($serviceId, Request $request)
    {
        $req = $request->validate([
            'BillingAccount' => 'required',
            'Version' => 'required',
            'ServiceListVersion' => 'required',
            'Data' => 'nullable',
        ]);
        try {
            $category = Category::find($serviceId);
            return response()->json([
                "Code" => 200,
                "Message" => "عمليه ناجحه",
                "Data" => [
                    "serviceId" => $serviceId,
                    "ServiceName" => $category->name,
                    "Fees" => $category->fee_percet,
                ]
            ]);
        } catch (Throwable $e) {
            return response()->json([
                "Code" => -1,
                "Message" => "عمليه غير ناجحه",
            ]);
        }
    }

    public function fees($serviceId, Request $request)
    {
        $req = $request->validate([
            'amount' => 'required',
            'version' => 'required',
            "Brn" => 'required',
            'serviceListVersion' => 'required',
            'data' => 'nullable',
        ]);

        if(auth()->user()->balance < $request->amount){
            return response()->json([
                "Code" => -17,
                "Message" => "قيمه خاطئة يجب دفع المبلغ المطلوب من نتيجة الاستعلام"
            ], 401);
        }
        $category = Category::find($serviceId);
        $amount = $request->amount;
        $fees = $category->fee_percet;
        $amountWithFees = ($amount * $fees)/100 + $amount;
        return response()->json([
            "Code" => 200,
            "Message" => "عمليه ناجحه",
            "Data" => [
                "serviceId" => $serviceId,
                "ServiceName" => $category->name,
                "Fees" => $fees,
                "Amount" => $request->amount,
                "AmountWithFees" => $amountWithFees,
                "FeesAmount" => $amountWithFees - $amount,
            ]
        ], 200);
    }
}
