<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\API\BaseController as BaseController;
use App\Http\Resources\ProductResource;
use App\Product;
use App\ProductPrice;
use Illuminate\Http\Request;
use Validator;

class ProductController extends BaseController
{
    /**
     * Display a listing of the resource.
     *
     * @return App\Http\Controllers\API\BaseController sendError or sendResponse
     */
    public function index()
    {
        $products = Product::all();
        return $this->sendResponse(ProductResource::collection($products), 'Available products');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return App\Http\Controllers\API\BaseController sendError or sendResponse
     */
    public function store(Request $request)
    {
        try {
            $input = $request->all();

            $validator = Validator::make($input, [
                'name' => 'required|unique:products,name',
                'description' => 'required',
                'image' => 'required',
                'category_id' => 'required',
                'prices' => 'required',
            ]);

            if ($validator->fails()) {
                return $this->sendError('Validation Error.', $validator->errors(), 400);
            }

            $product = Product::create($input);

            $prices = array();

            $input_prices = $input["prices"];
            foreach ($input_prices as $input_price) {
                $product_price = new ProductPrice;
                $product_price->size = $input_price["size"];
                $product_price->description = $input_price["description"];
                $product_price->price = $input_price["price"];
                array_push($prices, $product_price);
            }

            $product->prices()->saveMany($prices);

            return $this->sendResponse(new ProductResource($product), 'Product created successfully.', 201);
        } catch (QueryException $e) {
            $error_code = $e->errorInfo[1];
            if ($error_code == 1062) {
                return $this->sendError('Data Conflict.', $e->errorInfo, 409);
            } else {
                return $this->sendError('Query Error.', $e->errorInfo, 500);
            }
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return App\Http\Controllers\API\BaseController sendError or sendResponse
     */
    public function show($id)
    {
        $product = Product::find($id);

        if (is_null($product)) {
            return $this->sendError('Product not found.', [], 404);
        }

        return $this->sendResponse(new ProductResource($product), 'Product found.', 200);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return App\Http\Controllers\API\BaseController sendError or sendResponse
     */
    public function update(Request $request, $id)
    {
        $input = $request->all();

        $validator = Validator::make($input, [
            'name' => 'required|unique:products,name,' . $id,
            'description' => 'required',
            'image' => 'required',
            'category_id' => 'required',
            'prices' => 'required',
        ]);

        if ($validator->fails()) {
            return $this->sendError('Validation Error.', $validator->errors(), 400);
        }

        $product = Product::find($id);

        if (is_null($product)) {
            return $this->sendError('Product not found.', [], 404);
        }

        $product->name = $input['name'];
        $product->description = $input['description'];
        $product->image = $input['image'];
        $product->category_id = $input['category_id'];
        $product->save();

        $prices = array();

        $input_prices = $input["prices"];
        foreach ($input_prices as $input_price) {
            $product_price = new ProductPrice;
            $product_price->size = $input_price["size"];
            $product_price->description = $input_price["description"];
            $product_price->price = $input_price["price"];
            array_push($prices, $product_price);
        }
        $product->prices()->delete();
        $product->prices()->saveMany($prices);

        return $this->sendResponse(new ProductResource($product), 'Product updated successfully.', 201);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return App\Http\Controllers\API\BaseController sendError or sendResponse
     */
    public function destroy($id)
    {
        $product = Product::find($id);

        if (is_null($product)) {
            return $this->sendError('Product not found.', [], 404);
        }

        $product->prices()->delete();
        $product->delete();

        return $this->sendResponse([], 'Product deleted successfully.', 204);
    }
}
