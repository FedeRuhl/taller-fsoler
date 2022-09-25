<?php

namespace App\Http\Controllers\Api;

use App\Constants;
use App\Http\Requests\Product\StoreProductRequest;
use App\Http\Requests\Product\UpdateProductRequest;
use App\Http\Resources\ProductResource;
use App\Models\OrderType;
use App\Models\Product;
use DB;
use Exception;

class ProductController extends ApiController
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
            $products = Product::all();

            if ($products)
            {
                return $this->sendResponse(ProductResource::collection($products), 'Products sucessfully listed.');
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
    public function store(StoreProductRequest $request)
    {
        try
        {            
            $product = Product::create($request->validated());

            if ($product)
            {
                return $this->sendResponse(new ProductResource($product), 'Product sucessfully created.');
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
     * @param  \App\Models\Product  $product
     * @return \Illuminate\Http\Response
     */
    public function show($product_id)
    {
        try
        {
            $product = Product::find($product_id);

            if ($product)
            {
                return $this->sendResponse(new ProductResource($product), 'Product sucessfully found.');
            }
            else
            {
                return $this->sendError('Product not found');
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
     * @param  \App\Models\Product  $product
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateProductRequest $request, $product_id)
    {
        try
        {
            $validated = $request->safe()->except(['product_id']);
            $product = Product::find($product_id);

            if ($product)
            {
                $product->update($validated);
                return $this->sendResponse(new ProductResource($product), 'Product sucessfully updated.');
            }
            else
            {
                return $this->sendError('Product not found');
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
     * @param  \App\Models\Product  $product
     * @return \Illuminate\Http\Response
     */
    public function destroy($product_id)
    {
        try
        {
            $product = Product::find($product_id);

            if ($product)
            {
                $product->delete();
                return $this->sendResponse([], 'Product sucessfully deleted.');
            }
            else
            {
                return $this->sendError('Product not found');
            }
        }
        
        catch(Exception $e)
        {
            return $this->sendError($e->errorInfo[2]);
        }
    }

    /**
     * Display a listing of the resource by OrderType.
     *
     * @return \Illuminate\Http\Response
     */
    public function indexByOrderType($order_type_id)
    {
        try
        {
            $orderType = OrderType::find($order_type_id);

            if ($orderType)
            {
                switch($orderType->name)
                {
                    case Constants::ORDER_TYPES['orden_compra']: 
                        $products = Product::whereRelation('depots', 'name', Constants::DEPOTS['plan_18'])->get();
                        break;
                    case Constants::ORDER_TYPES['remito']: 
                        $products = Product::whereRelation('depots', 'name', Constants::DEPOTS['fusea'])->get();
                        break;
                    default:
                        $products = collect();
                        break;
                }

                return $this->sendResponse(ProductResource::collection($products), 'Products sucessfully listed by Order Type.');
            }
            else
            {
                return $this->sendError('Order Type not found');
            }
        }
        
        catch(Exception $e)
        {
            return $this->sendError($e->errorInfo[2]);
        }
    }
}
