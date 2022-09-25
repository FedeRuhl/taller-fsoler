<?php

namespace App\Http\Controllers\Api;

use App\Http\Requests\Depot\ModifyDepotProductRequest;
use App\Http\Requests\Depot\StoreDepotRequest;
use App\Http\Requests\Depot\UpdateDepotRequest;
use App\Http\Resources\DepotResource;
use App\Models\Depot;
use App\Models\DepotProduct;
use Exception;

class DepotController extends ApiController
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
            $depots = Depot::all();

            if ($depots)
            {
                return $this->sendResponse(DepotResource::collection($depots), 'Depots sucessfully listed.');
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
    public function store(StoreDepotRequest $request)
    {
        try
        {
            $depot = Depot::create($request->validated());

            if ($depot)
            {
                return $this->sendResponse(new DepotResource($depot), 'Depot sucessfully created.');
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
     * @param  \App\Models\Depot  $depot
     * @return \Illuminate\Http\Response
     */
    public function show($depot_id)
    {
        try
        {
            $depot = Depot::find($depot_id);

            if ($depot)
            {
                return $this->sendResponse(new DepotResource($depot), 'Depot sucessfully found.');
            }
            else
            {
                return $this->sendError('Depot not found');
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
     * @param  \App\Models\Depot  $depot
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateDepotRequest $request, $depot_id)
    {
        try
        {
            $validated = $request->safe()->except(['depot_id']);
            $depot = Depot::find($depot_id);

            if ($depot)
            {
                $depot->update($validated);
                $depot->save();
                return $this->sendResponse(new DepotResource($depot), 'Depot sucessfully updated.');
            }
            else
            {
                return $this->sendError('Depot not found');
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
     * @param  \App\Models\Depot  $depot
     * @return \Illuminate\Http\Response
     */
    public function destroy($depot_id)
    {
        try
        {
            $depot = Depot::find($depot_id);

            if ($depot)
            {
                $depot->delete();
                return $this->sendResponse([], 'Depot sucessfully deleted.');
            }
            else
            {
                return $this->sendError('Depot not found');
            }
        }
        
        catch(Exception $e)
        {
            return $this->sendError($e->errorInfo[2]);
        }
    }

    /**
     * Add depot details about a product.
     *
     * @param  \App\Models\Depot  $depot
     * @return \Illuminate\Http\Response
     */
    public function depotProduct($depot_id, $product_id, ModifyDepotProductRequest $request)
    {
        try
        {
            $depotProduct = DepotProduct::updateOrCreate(
                [
                    'depot_id' => $request->depot_id,
                    'product_id' => $request->product_id
                ],
                $request->validated()
            );

            if ($depotProduct)
            {
                
                $data = Depot::find($depotProduct->depot_id);
                $data->setAttribute('stock', $depotProduct->stock);
                $data->setAttribute('expiration_date', $depotProduct->expiration_date);
                $data->setAttribute('lote_code', $depotProduct->lote_code);

                return $this->sendResponse(new DepotResource($data), 'Depot product sucessfully modified.');
            }
        }
        
        catch(Exception $e)
        {
            return $this->sendError($e->errorInfo[2]);
        }
    }
}
