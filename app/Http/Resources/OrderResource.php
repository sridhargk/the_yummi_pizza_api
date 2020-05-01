<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class OrderResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function toArray($request)
    {
        return [
            'id' => $this->id,
            'customer_id' => $this->customer_id,
            'name' => $this->name,
            'delivery_address' => $this->delivery_address,
            'locality' => $this->locality,
            'total_quantity' => $this->total_quantity,
            'total_amount' => $this->total_amount,
            'tax' => $this->tax,
            'payable_amount' => $this->payable_amount,
            'items' => $this->items,
            'created_at' => $this->created_at->format('d/m/Y'),
            'updated_at' => $this->updated_at->format('d/m/Y'),
        ];
    }
}
