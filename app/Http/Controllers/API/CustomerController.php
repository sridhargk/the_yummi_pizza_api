<?php

namespace App\Http\Controllers\API;

use App\Customer;
use App\Http\Controllers\API\BaseController as BaseController;
use App\Http\Resources\CustomerResource;
use Illuminate\Database\QueryException;
use Illuminate\Http\Request;
use Validator;

class CustomerController extends BaseController
{
    /**
     * Display a listing of the resource.
     *
     * @return App\Http\Controllers\API\BaseController sendError or sendResponse
     */
    public function index()
    {
        $customers = Customer::all();
        return $this->sendResponse(CustomerResource::collection($customers), 'Available customers');
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
                'first_name' => 'required',
                'last_name' => 'required',
                'phone' => 'required',
                'email' => 'required|unique:customers,email',
                'house_number' => 'required',
                'address' => 'required',
                'locality' => 'required',
            ]);

            if ($validator->fails()) {
                return $this->sendError('Validation Error.', $validator->errors(), 400);
            }

            $customer = Customer::create($input);

            return $this->sendResponse(new CustomerResource($customer), 'Customer created successfully.', 201);
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
        $customer = Customer::find($id);

        if (is_null($customer)) {
            return $this->sendError('Customer not found.', [], 404);
        }

        return $this->sendResponse(new CustomerResource($customer), 'Customer found.', 200);
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
            'first_name' => 'required',
            'last_name' => 'required',
            'phone' => 'required',
            'email' => 'required|unique:customers,email,' . $id,
            'house_number' => 'required',
            'address' => 'required',
            'locality' => 'required',
        ]);

        if ($validator->fails()) {
            return $this->sendError('Validation Error.', $validator->errors(), 400);
        }

        $customer = Customer::find($id);

        if (is_null($customer)) {
            return $this->sendError('Customer not found.', [], 404);
        }

        $customer->first_name = $input['first_name'];
        $customer->last_name = $input['last_name'];
        $customer->phone = $input['phone'];
        $customer->email = $input['email'];
        $customer->house_number = $input['house_number'];
        $customer->address = $input['address'];
        $customer->locality = $input['locality'];
        $customer->save();

        return $this->sendResponse(new CustomerResource($customer), 'Customer updated successfully.', 201);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return App\Http\Controllers\API\BaseController sendError or sendResponse
     */
    public function destroy($id)
    {
        $customer = Customer::find($id);

        if (is_null($customer)) {
            return $this->sendError('Customer not found.', [], 404);
        }

        $customer->delete();

        return $this->sendResponse([], 'Customer deleted successfully.', 204);
    }
}
