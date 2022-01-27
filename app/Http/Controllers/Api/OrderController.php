<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Api\ApiController;
use App\Http\Requests\Order\StoreOrderRequest;
use App\Http\Requests\Order\UpdateOrderRequest;
use App\Http\Resources\OrderResource;
use App\Models\Order;
use Exception;

class OrderController extends ApiController
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        try
        {
            $orders = Order::all();

            if ($orders)
            {
                return $this->sendResponse(OrderResource::collection($orders), 'Orders sucessfully listed.');
            }
        }
        
        catch(Exception $e)
        {
            return $this->sendError($e->errorInfo[2]);
        }
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreOrderRequest $request)
    {
        try
        {
            $order = Order::create($request->validated());

            if ($order)
            {
                return $this->sendResponse(new OrderResource($order), 'Order sucessfully created.');
            }
        }
        
        catch(Exception $e)
        {
            return $this->sendError($e->errorInfo[2]);
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Order  $order
     * @return \Illuminate\Http\Response
     */
    public function show($order_id)
    {
        try
        {
            $order = Order::find($order_id);

            if ($order)
            {
                return $this->sendResponse(new OrderResource($order), 'Order sucessfully found.');
            }
            else
            {
                return $this->sendError('Order not found');
            }
        }
        
        catch(Exception $e)
        {
            return $this->sendError($e->errorInfo[2]);
        }
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Order  $order
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateOrderRequest $request, $order_id)
    {
        try
        {
            $validated = $request->safe()->except(['order_id']);
            $order = Order::find($order_id);

            if ($order)
            {
                $order->update($validated);
                return $this->sendResponse(new OrderResource($order), 'Order sucessfully updated.');
            }
            else
            {
                return $this->sendError('Order not found');
            }
        }
        
        catch(Exception $e)
        {
            return $this->sendError($e->errorInfo[2]);
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Order  $order
     * @return \Illuminate\Http\Response
     */
    public function destroy($order_id)
    {
        try
        {
            $order = Order::find($order_id);

            if ($order)
            {
                $order->delete();
                return $this->sendResponse([], 'Order sucessfully deleted.');
            }
            else
            {
                return $this->sendError('Order not found');
            }
        }
        
        catch(Exception $e)
        {
            return $this->sendError($e->errorInfo[2]);
        }
    }
}
