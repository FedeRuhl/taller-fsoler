<?php

namespace App\Http\Controllers\Api;

use App\Http\Requests\Product\StoreProductRequest;
use App\Http\Requests\Product\UpdateProductRequest;
use App\Http\Resources\ProductResource;
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
            $depots = $request->get('depots');
            $syncDepotsData = [];

            foreach($depots as $depot)
            {
                $syncDepotsData[$depot['id']]['stock'] = $depot['stock'];

                if (array_key_exists('expiration_date', $depot))
                {
                    $syncDepotsData[$depot['id']]['expiration_date'] = $depot['expiration_date'];
                }

                if (array_key_exists('lote_code', $depot))
                {
                    $syncDepotsData[$depot['id']]['lote_code'] = $depot['lote_code'];
                }
            }

            DB::beginTransaction();
            
            $product = Product::create($request->except('depots'));
            $product->depots()->sync($syncDepotsData);

            if ($product)
            {
                DB::commit();
                return $this->sendResponse(new ProductResource($product), 'Product sucessfully created.');
            }

            DB::rollback();
        }
        
        catch(Exception $e)
        {
            DB::rollback();
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
            $validated = $request->safe()->except(['product_id', 'depots']);
            $product = Product::find($product_id);

            if ($product)
            {
                $product->update($validated);

                if ($depots = $request->get('depots'))
                {
                    $syncDepotsData = [];

                    foreach($depots as $depot)
                    {
                        $syncDepotsData[$depot['id']]['stock'] = $depot['stock'];

                        if (array_key_exists('expiration_date', $depot))
                        {
                            $syncDepotsData[$depot['id']]['expiration_date'] = $depot['expiration_date'];
                        }

                        if (array_key_exists('lote_code', $depot))
                        {
                            $syncDepotsData[$depot['id']]['lote_code'] = $depot['lote_code'];
                        }
                    }

                    $product->depots()->sync($syncDepotsData);
                }

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
}
