<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Api\ApiController;
use App\Http\Requests\Hospitalization\StoreHospitalizationRequest;
use App\Http\Requests\Hospitalization\UpdateHospitalizationRequest;
use App\Http\Resources\HospitalizationResource;
use App\Models\Hospitalization;
use Exception;

class HospitalizationController extends ApiController
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
            $hospitalizations = Hospitalization::all();

            if ($hospitalizations)
            {
                return $this->sendResponse(HospitalizationResource::collection($hospitalizations), 'Hospitalizations sucessfully listed.');
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
    public function store(StoreHospitalizationRequest $request)
    {
        try
        {
            $hospitalization = Hospitalization::create($request->validated());

            if ($hospitalization)
            {
                return $this->sendResponse(new HospitalizationResource($hospitalization), 'Hospitalization sucessfully created.');
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
     * @param  \App\Models\Hospitalization  $hospitalization
     * @return \Illuminate\Http\Response
     */
    public function show($hospitalization_id)
    {
        try
        {
            $hospitalization = Hospitalization::find($hospitalization_id);

            if ($hospitalization)
            {
                return $this->sendResponse(new HospitalizationResource($hospitalization), 'Hospitalization sucessfully found.');
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
     * @param  \App\Models\Hospitalization  $hospitalization
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateHospitalizationRequest $request, $hospitalization_id)
    {
        try
        {
            $validated = $request->safe()->except(['hospitalization_id']);
            $hospitalization = Hospitalization::find($hospitalization_id);

            if ($hospitalization)
            {
                $hospitalization->update($validated);
                return $this->sendResponse(new HospitalizationResource($hospitalization), 'Hospitalization sucessfully updated.');
            }
            else
            {
                return $this->sendError('Hospitalization not found');
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
     * @param  \App\Models\Hospitalization  $hospitalization
     * @return \Illuminate\Http\Response
     */
    public function destroy($hospitalization_id)
    {
        try
        {
            $hospitalization = Hospitalization::find($hospitalization_id);

            if ($hospitalization)
            {
                $hospitalization->delete();
                return $this->sendResponse([], 'Hospitalization sucessfully deleted.');
            }
            else
            {
                return $this->sendError('Hospitalization not found');
            }
        }
        
        catch(Exception $e)
        {
            return $this->sendError($e->errorInfo[2]);
        }
    }
}
