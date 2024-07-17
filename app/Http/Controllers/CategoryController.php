<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Http\Requests\StoreCategoryRequest;
use App\Http\Requests\UpdateCategoryRequest;

class CategoryController extends Controller
{

    public function __construct()
    {
        $this->middleware('auth');
    }
    public function showCategories()
    {
        $categories = Category::all();
        foreach( $categories as $category)
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
        }            
    }
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreCategoryRequest $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(Category $category)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Category $category)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateCategoryRequest $request, Category $category)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Category $category)
    {
        //
    }
}
