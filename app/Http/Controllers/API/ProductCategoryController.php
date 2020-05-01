<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\API\BaseController as BaseController;
use App\Http\Resources\ProductCategoryResource;
use App\ProductCategory;
use Illuminate\Http\Request;
use Validator;

class ProductCategoryController extends BaseController
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $product_category = ProductCategory::all();
        return $this->sendResponse(ProductCategoryResource::collection($product_category), 'Available product categories');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $input = $request->all();

        $validator = Validator::make($input, [
            'name' => 'required|unique:product_categories,name',
            'description' => 'required',
            'image' => 'required',
        ]);

        if ($validator->fails()) {
            return $this->sendError('Validation Error.', $validator->errors(), 400);
        }

        $product_category = ProductCategory::create($input);

        return $this->sendResponse(new ProductCategoryResource($product_category), 'Product Category created successfully.', 201);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $product_category = ProductCategory::find($id);

        if (is_null($product_category)) {
            return $this->sendError('Product Category not found.', [], 404);
        }

        return $this->sendResponse(new ProductCategoryResource($product_category), 'Product Category found.', 200);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $input = $request->all();

        $validator = Validator::make($input, [
            'name' => 'required|unique:product_categories,name,' . $id,
            'description' => 'required',
            'image' => 'required',
        ]);

        if ($validator->fails()) {
            return $this->sendError('Validation Error.', $validator->errors(), 400);
        }

        $product_category = ProductCategory::find($id);

        if (is_null($product_category)) {
            return $this->sendError('Product Category not found.', [], 404);
        }

        $product_category->name = $input['name'];
        $product_category->description = $input['description'];
        $product_category->image = $input['image'];
        $product_category->save();

        return $this->sendResponse(new ProductCategoryResource($product_category), 'Product Category updated successfully.', 201);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $product_category = ProductCategory::find($id);

        if (is_null($product_category)) {
            return $this->sendError('Product Category not found.', [], 404);
        }

        $product_category->products()->delete();
        $product_category->delete();

        return $this->sendResponse([], 'Product Category deleted successfully.', 204);
    }
}
