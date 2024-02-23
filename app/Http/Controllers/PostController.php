<?php

namespace App\Http\Controllers;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Http\Response;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use App\Models\Hotel;

class PostController extends Controller
{
    public static  $products;
    private static $product,$image,$imageName,$directory,$imageUrl,$otherImage,$imageExtension;

    public function index()
    {
        $products=Hotel::all();
        return response()->json($products);
    }

    
    public function create()
    {
        //
    }


    public static function getImageUrl($request)
    {
        self::$image        = $request->file('Single_image');
        self::$imageName    = self::$image->getClientOriginalName();
        self::$directory    = 'upload/product-images/';
        self::$image->move(self::$directory, self::$imageName);
        self::$imageUrl     = self::$directory.self::$imageName;
        return self::$imageUrl;
    }
    public static function getMultiImageUrl($request)
    {
        if ($request->hasFile('multiple_image')) {
            $images = $request->file('multiple_image');
            $imageUrls = [];

            foreach ($images as $image) {
                if ($image->isValid()) {
                    $imageExtension = $image->getClientOriginalExtension();
                    $imageName = rand(1, 500000) . '.' . $imageExtension;
                    $directory = 'upload/product-other-images/';
                    $image->move($directory, $imageName);

                    $imageUrl = $directory . $imageName;
                    $imageUrls[] = $imageUrl;
                } else {

                }
            }
            return $imageUrls;
        } else {
            return [];
        }
    }

    
    public function store(Request $request)
    {
        


        $rules = [
            'country' => 'required|string',
            'city' => 'required|string',
            'hotel_name' => 'required|string',
            'embed_code' => 'required|string',
            'landmark' => 'required|string',
            'rating' => 'required|numeric',
            'address' => 'required|string',
            'highlights' => 'required|string',
            'long_decription' => 'required|string',
            'currency' => 'required|string',
            'term_condition' => 'required|string',
            //'single_image' => 'required', // Single image validation
            'multiple_image.*' => 'required|image|mimes:jpeg,png,jpg,gif|max:2048', // Multiple image validation
          
        ];
    
        // Apply validation on the incoming request data
        $validator = Validator::make($request->all(), $rules);
    
        // Check if validation fails
        if ($validator->fails()) {
            return response()->json(['error' => $validator->errors()], 400);
            // You can modify this response according to your application's needs
        }


$extraBedValue = $request->input('extra_bed');
if ($extraBedValue === null || $extraBedValue === '') {
    $extraBedValue = 'No';
}
    $product = new Hotel();
    $product->country = $request->country;
    $product->city = $request->city;
    $product->hotel_name = $request->hotel_name;
    $product->embed_code = $request->embed_code;
    $product->landmark = $request->landmark;
    $product->rating = $request->rating;
    $product->address = $request->address;
    $product->highlights = $request->highlights;
    $product->long_decription = $request->long_decription;
    $product->currency = $request->currency;
    $product->term_condition = $request->term_condition;
    $product->single_image = self::getImageUrl($request);
    $multipleImageUrls = self::getMultiImageUrl($request);
    if ($multipleImageUrls !== null && is_array($multipleImageUrls)) {
       $product->multiple_image = serialize($multipleImageUrls);
    }
    $includeFacilities = is_array($request->facilities) ? implode(',', $request->facilities) : $request->facilities;
    $product->facilities = $includeFacilities;

    $product->save();

    return response()->json(['message' => 'Product Stored successfully']);

        
    }

  
    public function show($id)
    {
        $product=Hotel::find($id);
        if (!$product) {
            return response()->json(['error' => 'Product not found'], Response::HTTP_NOT_FOUND);
        }
        return response()->json($product);
    }

   
    public function edit($id)
    {
        //
    }

  
    public function update(Request $request, $id)
    {
        

        $rules = [
            'country' => 'required|string',
            'city' => 'required|string',
            'hotel_name' => 'required|string',
            'embed_code' => 'required|string',
            'landmark' => 'required|string',
            'rating' => 'required|numeric',
            'address' => 'required|string',
            'highlights' => 'required|string',
            'long_decription' => 'required|string',
            'currency' => 'required|string',
            'term_condition' => 'required|string',
            //'single_image' => 'required', // Single image validation
            'multiple_image.*' => 'required|image|mimes:jpeg,png,jpg,gif|max:2048', // Multiple image validation
          
        ];

        $product = Hotel::find($id);
    
        // Apply validation on the incoming request data
        $validator = Validator::make($request->all(), $rules);
    
        // Check if validation fails
        if ($validator->fails()) {
            return response()->json(['error' => $validator->errors()], 400);
            // You can modify this response according to your application's needs
        }


$extraBedValue = $request->input('extra_bed');
if ($extraBedValue === null || $extraBedValue === '') {
    $extraBedValue = 'No';
}
    $product = new Hotel();
    $product->country = $request->country;
    $product->city = $request->city;
    $product->hotel_name = $request->hotel_name;
    $product->embed_code = $request->embed_code;
    $product->landmark = $request->landmark;
    $product->rating = $request->rating;
    $product->address = $request->address;
    $product->highlights = $request->highlights;
    $product->long_decription = $request->long_decription;
    $product->currency = $request->currency;
    $product->term_condition = $request->term_condition;
    $product->single_image = self::getImageUrl($request);
    $multipleImageUrls = self::getMultiImageUrl($request);
    if ($multipleImageUrls !== null && is_array($multipleImageUrls)) {
       $product->multiple_image = serialize($multipleImageUrls);
    }
    $includeFacilities = is_array($request->facilities) ? implode(',', $request->facilities) : $request->facilities;
    $product->facilities = $includeFacilities;

    $product->save();

    return response()->json(['message' => 'Product updated successfully']);

    }

    public function destroy($id)
    {
        $product = Hotel::find($id);
    
        if (!$product) {
            return response()->json(['error' => 'Product not found'], Response::HTTP_NOT_FOUND);
        }
    
        $product->delete();
    
        return response()->json(['message' => 'Product deleted successfully']);
    }
}
