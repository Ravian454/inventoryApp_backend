<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Product; 
class UserController extends Controller
{
    public function insertData(Request $request)
    {
        // Validate the incoming request data
        $validatedData = $request->validate([
            'category' => 'required|string',
            'name' => 'required|string',
            'price' => 'required|numeric',
            'size' => 'required|string',
            'in_stock' => 'required|integer',
            'out_stock' => 'required|integer',
            'barcode' => 'required|numeric',
        ]);

        Product::create($validatedData);

        return response()->json(['message' => 'Data inserted successfully'], 201);
    }


    public function getData(Request $request)
{
    $products = Product::all(); 
    
    if ($products->isEmpty()) {
        return response()->json(['message' => 'No products found'], 404);
    }

    return response()->json(['products' => $products], 200);
}
}
