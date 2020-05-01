<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\API\BaseController as BaseController;
use App\Http\Resources\OrderResource;
use App\Order;
use App\OrderItems;
use Illuminate\Http\Request;
use Validator;

class OrderController extends BaseController
{
    /**
     * Display a listing of the resource.
     *
     * @return App\Http\Controllers\API\BaseController sendError or sendResponse
     */
    public function index()
    {
        $orders = Order::all();
        return $this->sendResponse(OrderResource::collection($orders), 'Available orders');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return App\Http\Controllers\API\BaseController sendError or sendResponse
     */
    public function store(Request $request)
    {
        $input = $request->all();

        $validator = Validator::make($input, [
            'customer_id' => 'required',
            'name' => 'required',
            'delivery_address' => 'required',
            'locality' => 'required',
            'total_quantity' => 'required',
            'total_amount' => 'required',
            'tax' => 'required',
            'payable_amount' => 'required',
            'items' => 'required',
        ]);

        if ($validator->fails()) {
            return $this->sendError('Validation Error.', $validator->errors(), 400);
        }

        $order = Order::create($input);

        $items = array();

        $input_items = $input["items"];
        foreach ($input_items as $input_item) {
            $order_item = new OrderItems;
            $order_item->product_id = $input_item["product_id"];
            $order_item->name = $input_item["name"];
            $order_item->description = $input_item["description"];
            $order_item->quantity = $input_item["quantity"];
            $order_item->price = $input_item["price"];
            $order_item->total = $input_item["total"];
            array_push($items, $order_item);
        }

        $order->items()->saveMany($items);

        return $this->sendResponse(new OrderResource($order), 'Order created successfully.', 201);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return App\Http\Controllers\API\BaseController sendError or sendResponse
     */
    public function show($id)
    {
        $order = Order::find($id);

        if (is_null($order)) {
            return $this->sendError('Order not found.', [], 404);
        }

        return $this->sendResponse(new OrderResource($order), 'Order found.', 200);
    }

    /**
     * Display the specified customer resource.
     *
     * @param  int  $id
     * @return App\Http\Controllers\API\BaseController sendError or sendResponse
     */
    public function show_customers($customer_id)
    {
        $orders = Order::where('customer_id', '=', $customer_id)->get();

        return $this->sendResponse(OrderResource::collection($orders), 'Customer Order found.', 200);
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
            'customer_id' => 'required',
            'name' => 'required',
            'delivery_address' => 'required',
            'locality' => 'required',
            'total_quantity' => 'required',
            'total_amount' => 'required',
            'tax' => 'required',
            'payable_amount' => 'required',
            'items' => 'required',
        ]);

        if ($validator->fails()) {
            return $this->sendError('Validation Error.', $validator->errors(), 400);
        }

        $order = Order::find($id);

        if (is_null($order)) {
            return $this->sendError('Order not found.', [], 404);
        }

        $order->customer_id = $input['customer_id'];
        $order->name = $input['name'];
        $order->delivery_address = $input['delivery_address'];
        $order->locality = $input['locality'];
        $order->total_quantity = $input['total_quantity'];
        $order->total_amount = $input['total_amount'];
        $order->tax = $input['tax'];
        $order->payable_amount = $input['payable_amount'];
        $order->save();

        $items = array();

        $input_items = $input["items"];
        foreach ($input_items as $input_item) {
            $order_item = new OrderItems;
            $order_item->product_id = $input_item["product_id"];
            $order_item->name = $input_item["name"];
            $order_item->description = $input_item["description"];
            $order_item->quantity = $input_item["quantity"];
            $order_item->price = $input_item["price"];
            $order_item->total = $input_item["total"];
            array_push($items, $order_item);
        }

        $order->items()->delete();
        $order->items()->saveMany($items);

        return $this->sendResponse(new OrderResource($order), 'Order updated successfully.', 201);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return App\Http\Controllers\API\BaseController sendError or sendResponse
     */
    public function destroy($id)
    {
        $order = Order::find($id);

        if (is_null($order)) {
            return $this->sendError('Order not found.', [], 404);
        }

        $order->items()->delete();
        $order->delete();

        return $this->sendResponse([], 'Order deleted successfully.', 204);
    }
}
