<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Throwable;

class ServiceControoler extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }
    public function inquiry($serviceId, Request $request)
    {
        $req = $request->validate([
            'BillingAccount' => 'required',
            'Version' => 'required',
            'ServiceListVersion' => 'required',
            'Data' => 'nullable',
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

    public function fees($serviceId, Request $request)
    {
        if(!$request->has('Amount')){
            return response()->json([
                "Code" => -13,
                "Message" => "يوجد بيانات ناقصه"
            ], 401);
        }
        $req = $request->validate([
            'Amount' => 'required',
            'Version' => 'required',
            "Brn" => 'required',
            'ServiceListVersion' => 'required',
            'Data' => 'nullable',
        ]);

        if($req){
            try{
                
                return response()->json(
                    [
                    
                        "Code" => 200,
                        "Message" => "عمليه ناجحه",
                        "amount" => 21161,
                        "fees" => 20,
                        "taxes" => 0,
                        "totalAmount" => 21181,
                        "brn" => 65400
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
