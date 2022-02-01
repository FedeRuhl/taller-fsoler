<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Api\ApiController;
use App\Http\Requests\Supplier\StoreSupplierRequest;
use App\Http\Requests\Supplier\UpdateSupplierRequest;
use App\Http\Resources\SupplierResource;
use App\Models\Supplier;
use App\Models\SupplierAddress;
use Exception;

class SupplierController extends ApiController
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
            $suppliers = Supplier::all();

            if ($suppliers)
            {
                return $this->sendResponse(SupplierResource::collection($suppliers), 'Suppliers sucessfully listed.');
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
    public function store(StoreSupplierRequest $request)
    {
        try
        {
            $supplierAddress = SupplierAddress::create(
                $request->only([
                    'zip_code',
                    'street',
                    'number'
                ])
            );

            $supplier = Supplier::create(
                $request->merge([
                    'supplier_address_id' => $supplierAddress->id
                ])->only([
                    'CUIT',
                    'company_name',
                    'supplier_address_id'
                ])
            );

            if ($supplier)
            {
                return $this->sendResponse(new SupplierResource($supplier), 'Supplier sucessfully created.');
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
     * @param  \App\Models\Supplier  $supplier
     * @return \Illuminate\Http\Response
     */
    public function show($supplier_id)
    {
        try
        {
            $supplier = Supplier::find($supplier_id);

            if ($supplier)
            {
                return $this->sendResponse(new SupplierResource($supplier), 'Supplier sucessfully found.');
            }
            else
            {
                return $this->sendError('Supplier not found');
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
     * @param  \App\Models\Supplier  $supplier
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateSupplierRequest $request, $supplier_id)
    {
        try
        {
            $supplier = Supplier::find($supplier_id);

            if ($supplier)
            {
                if ($request->hasAny(['zip_code', 'street', 'number']))
                {
                    $supplier->address()->update($request->only([
                        'zip_code',
                        'street',
                        'number'
                    ]));
                }

                if ($request->hasAny(['CUIT', 'company_name']))
                {
                    $supplier->update($request->only([
                        'CUIT',
                        'company_name'
                    ]));
                }

                return $this->sendResponse(new SupplierResource($supplier), 'Supplier sucessfully updated.');
            }
            else
            {
                return $this->sendError('Supplier not found');
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
     * @param  \App\Models\Supplier  $supplier
     * @return \Illuminate\Http\Response
     */
    public function destroy($supplier_id)
    {
        try
        {
            $supplier = Supplier::find($supplier_id);

            if ($supplier)
            {
                $supplier->delete();
                return $this->sendResponse([], 'Supplier sucessfully deleted.');
            }
            else
            {
                return $this->sendError('Supplier not found');
            }
        }
        
        catch(Exception $e)
        {
            return $this->sendError($e->errorInfo[2]);
        }
    }
}
