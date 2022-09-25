<?php

namespace App\Http\Controllers\Api;

use App\Http\Requests\Request\ConsumeRequestRequest;
use App\Http\Requests\Request\StoreRequestRequest;
use App\Http\Requests\Request\UpdateRequestRequest;
use App\Http\Resources\RequestResource;
use App\Models\DepotProduct;
use App\Models\GenericRequest;
use App\Models\GenericRequestProduct;
use App\Models\Request;
use App\Services\GenericService;
use Auth;
use DB; 
use Exception;

class RequestController extends ApiController
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
            $requests = Request::all();

            if ($requests)
            {
                return $this->sendResponse(RequestResource::collection($requests), 'Requests sucessfully listed.');
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
    public function store(StoreRequestRequest $request)
    {
        try
        {
            // TODO: como extender la lógica a los pedidos semanales
            $requestModel = Request::create(
                $request->safe()->except(['generics'])
            );

            $service = new GenericService(Auth::id());
            $pivotData = $service->getTotalQuantities($request->generics);

            $requestModel->generics()->attach($pivotData);
            $generics = $requestModel->generics()->with('products')->get();

            $service->updateStocks($generics);

            if ($requestModel)
            {
                return $this->sendResponse(new RequestResource($requestModel), 'Request sucessfully created.');
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
     * @param  \App\Models\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function show($request_id)
    {
        try
        {
            $request = Request::find($request_id);

            if ($request)
            {
                return $this->sendResponse(new RequestResource($request), 'Request sucessfully found.');
            }
            else
            {
                return $this->sendError('Request not found');
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
     * @param  \App\Models\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateRequestRequest $request, $request_id)
    {
        return "En desarrollo";
        
        try
        {
            $validated = $request->safe()->except(['request_id', 'generics']);
            $requestModel = Request::find($request_id);

            if ($requestModel)
            {
                $requestModel->update($validated);

                if ($request->has('generics'))
                {

                    $generics = collect($request->generics);

                    $invalidGenerics = $requestModel->generics->filter(function ($generic) use ($generics) {
                        return !$generics->contains('id', $generic->id);
                    });

                    $this->removeInvalidGenerics($requestModel, $invalidGenerics);

                    $newGenerics = $generics->filter(function ($generic) use ($requestModel) {
                        return !$requestModel->generics->contains('id', $generic['id']);
                    });

                    $service = new GenericService(Auth::id());
                    $pivotData = $service->getTotalQuantities($newGenerics);
                    $requestModel->generics()->attach($pivotData);
                    $genericsToUpdate = $requestModel->generics()->with('products')->get();
                    $service->updateStocks($genericsToUpdate);

                    foreach($generics as $generic)
                    {
                        if ($requestModel->generics->contains('id', $generic['id']))
                        {
                            $oldGeneric = $requestModel->generics->where('id', $generic['id']);

                            if ($generic['total_quantity'] > $oldGeneric->first()->pivot->generics_total_quantity)
                            {
                                // dd([$oldGeneric], collect($oldGeneric));
                                $this->removeInvalidGenerics($requestModel, $oldGeneric);

                                $pivotData = $service->getTotalQuantities([$generic]);
                                $requestModel->generics()->attach($pivotData);
                                $genericsToUpdate = $requestModel->generics()
                                    ->where('generics.id', $generic['id'])    
                                    ->with('products')
                                    ->get();
                                $service->updateStocks($genericsToUpdate);
                            }
                            else if ($generic['total_quantity'] < $oldGeneric->first()->pivot->generics_total_quantity)
                            {
                                $genericRequest = GenericRequest::where('request_id', $request_id)
                                    ->where('generic_id', $generic['id'])
                                    ->update([
                                        'generics_total_quantity' => $generic['total_quantity']
                                    ]);

                                dd($genericRequest);

                                $genericRequestProduct = $genericRequest->product;

                                $genericRequestProduct->update([
                                    'products_quantity' => $generic['total_quantity']
                                ]);

                                DepotProduct::where('depot_id', $genericRequestProduct->depot_id)
                                    ->where('product_id', $genericRequestProduct->product_id)
                                    ->update([
                                        'stock' => DB::raw('stock + ' . $generic['total_quantity'])
                                    ]);
                            }
                        }
                    }
                }

                return $this->sendResponse(new RequestResource($requestModel), 'Request sucessfully updated.');
            }
            else
            {
                return $this->sendError('Request not found');
            }
        }
        
        catch(Exception $e)
        {
            dd($e);
            return $this->sendError($e->errorInfo[2]);
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function destroy($request_id)
    {
        try
        {
            $request = Request::find($request_id);

            if ($request)
            {
                $request->delete();
                return $this->sendResponse([], 'Request sucessfully deleted.');
            }
            else
            {
                return $this->sendError('Request not found');
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
     * @param  App\Http\Requests\Request\ConsumeRequestRequest $request
     * @param  \App\Models\Request  $request_id
     * @return \Illuminate\Http\Response
     */
    public function consume(ConsumeRequestRequest $request, $request_id)
    {
        try
        {
            $requestModel = Request::with('generics')
                ->find($request_id);

            if ($requestModel)
            {
                DB::beginTransaction();

                foreach($request->generics as $generic)
                {
                    if ($genericModel = $requestModel->generics->where('id', $generic['id'])->first())
                    {
                        if (($consumedQuantity = collect($generic['products'])->sum('consumed_quantity')) <= $genericModel->pivot->generics_total_quantity)
                        {
                            $requestModel->generics()->updateExistingPivot($generic['id'], [
                                'generics_consumed_quantity' => $consumedQuantity
                            ]);

                            if ($consumedQuantity < $genericModel->pivot->generics_total_quantity)
                            {
                                foreach($generic['products'] as $product)
                                {
                                    $genericRequestProduct = GenericRequestProduct::where('generic_request_id', $genericModel->pivot->id)
                                        ->where('product_id', $product['id'])
                                        ->first(['depot_id', 'products_quantity']);

                                    if ($genericRequestProduct->products_quantity > $product['consumed_quantity'])
                                    {
                                        $depot = DepotProduct::where('depot_id', $genericRequestProduct->depot_id)
                                            ->where('product_id', $product['id']);
                                        $currentStock = $depot->value('stock');

                                        $depot->update([
                                            'stock' => $currentStock + ($genericRequestProduct->products_quantity - $product['consumed_quantity'])
                                        ]);
                                    }
                                }
                            }
                        }
                        else
                        {
                            DB::rollback();
                            return $this->sendError("The consumed quantity in generic {$generic['id']} should not be greater than total quantity.");
                        }
                    }
                    else
                    {
                        DB::rollback();
                        return $this->sendError("The generic {$generic['id']} does not belong to this request.");
                    }
                }
                
                DB::commit();
                return $this->sendResponse([], 'Generics sucessfully consumed.');
            }
            else
            {
                return $this->sendError('Request not found');
            }
        }
        
        catch(Exception $e)
        {
            return $this->sendError($e->errorInfo[2]);
        }
    }

    /**
     * Detach invalidad generics and fix stock by Request.
     *
     * @param  \App\Models\Request  $request
     * @return \Illuminate\Http\Response
     */
    private function removeInvalidGenerics($request, $invalidGenerics)
    {
        dd($invalidGenerics->first());
        foreach ($invalidGenerics as $invalidGeneric)
        {
            $genericRequestProduct = GenericRequest::where('request_id', $request->id)
                ->where('generic_id', $invalidGeneric->id)
                ->first()
                ->product()
                ->first(['depot_id', 'product_id']);

            $oldTotalQuantity = $invalidGeneric->pivot->generics_total_quantity;
            
            DepotProduct::where('depot_id', $genericRequestProduct->depot_id)
                ->where('product_id', $genericRequestProduct->product_id)
                ->update([
                    'stock' => DB::raw('stock + ' . $oldTotalQuantity)
                ]);
        }

        $request->generics()->detach($invalidGenerics->pluck('id'));
    }
}