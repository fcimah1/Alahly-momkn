<?php

namespace App\Http\Controllers;

use App\Models\Category;
class CategoryController extends Controller
{

    public function __construct()
    {
        $this->middleware('auth:api', ['except' => ['login']]);
    }
    public function showCategories()
    {
        if(auth()->user()->balance>100){
            $categories = Category::get()->toArray();
            return response()->json([
                "code" => "200",
                'message' => "عمليه ناجحه",
                "خدمات ممكن" => array_filter($categories, function ($categ) {
                    return $categ['name'];
                })
            ]);
        }else{
            return response()->json([
                "code" => "-16",
                'message' => "لا توجد بيانات",
            ]);
        }
    }
        
}

