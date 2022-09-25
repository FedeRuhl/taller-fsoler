<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Api\ApiController;
use App\Http\Requests\Unit\StoreUnitRequest;
use App\Http\Requests\Unit\UpdateUnitRequest;
use App\Http\Resources\UnitResource;
use App\Models\Unit;
use App\Models\UnitUbication;
use Exception;

class UnitController extends ApiController
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
            $units = Unit::all();

            if ($units)
            {
                return $this->sendResponse(UnitResource::collection($units), 'Units sucessfully listed.');
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
    public function store(StoreUnitRequest $request)
    {
        try
        {
            $unitUbication = UnitUbication::create(
                $request->only([
                    'city_id',
                    'province_id',
                    'zip_code'
                ])
            );

            $unit = Unit::create(
                $request->merge([
                    'unit_ubication_id' => $unitUbication->id
                ])->only([
                    'name',
                    'unit_ubication_id'
                ])
            );

            if ($unit)
            {
                return $this->sendResponse(new UnitResource($unit), 'Unit sucessfully created.');
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
     * @param  \App\Models\Unit  $unit
     * @return \Illuminate\Http\Response
     */
    public function show($unit_id)
    {
        try
        {
            $unit = Unit::find($unit_id);

            if ($unit)
            {
                return $this->sendResponse(new UnitResource($unit), 'Unit sucessfully found.');
            }
            else
            {
                return $this->sendError('Unit not found');
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
     * @param  \App\Models\Unit  $unit
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateUnitRequest $request, $unit_id)
    {
        try
        {
            $unit = Unit::find($unit_id);

            if ($unit)
            {
                if ($request->hasAny(['city_id', 'province_id', 'zip_code']))
                {
                    $unit->ubication()->update($request->only([
                        'city_id',
                        'province_id',
                        'zip_code'
                    ]));
                }

                if ($request->has('name'))
                {
                    $unit->update($request->only([
                        'name'
                    ]));
                }

                return $this->sendResponse(new UnitResource($unit), 'Unit sucessfully updated.');
            }
            else
            {
                return $this->sendError('Unit not found');
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
     * @param  \App\Models\Unit  $unit
     * @return \Illuminate\Http\Response
     */
    public function destroy($unit_id)
    {
        try
        {
            $unit = Unit::find($unit_id);

            if ($unit)
            {
                $unit->delete();
                return $this->sendResponse([], 'Unit sucessfully deleted.');
            }
            else
            {
                return $this->sendError('Unit not found');
            }
        }
        
        catch(Exception $e)
        {
            return $this->sendError($e->errorInfo[2]);
        }
    }
}
