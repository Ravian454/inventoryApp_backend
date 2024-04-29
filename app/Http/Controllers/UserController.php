<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Product; 
use Illuminate\Support\Facades\Storage;
class UserController extends Controller
{
    public function insertData(Request $request)
    {
        // Validate the incoming request data
        $validatedData = $request->validate([
            'category'  => 'required|string',
            'name'      => 'required|string',
            'price'     => 'required|numeric',
            'size'      => 'required|string',
            'in_stock'  => 'required|integer',
            'out_stock' => 'required|integer',
            'barcode'   => 'required|numeric',
            'image'     => 'required',
        ]);

        $imageData = $request->image;
        $image = base64_decode(preg_replace('#^data:image/\w+;base64,#i', '', $imageData));

        // Generate a unique file name for the image
        $imageName = uniqid() . '.' . explode('/', explode(':', substr($imageData, 0, strpos($imageData, ';')))[1])[1];

        // Store the image file
        Storage::disk('public')->put('images/' . $imageName, $image);

        // Check if the product with the given barcode already exists
        $existingProduct = Product::where('barcode', $validatedData['barcode'])->first();
        if ($existingProduct) {
            return response()->json(['message' => 'Data already exists'], 409);
        }

        // Create the product with the image file name
        $validatedData['image'] = $imageName;
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
