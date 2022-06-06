<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Api\ApiController;
use App\Http\Requests\Laboratory\StoreLaboratoryRequest;
use App\Http\Requests\Laboratory\UpdateLaboratoryRequest;
use App\Http\Resources\LaboratoryResource;
use App\Models\Laboratory;
use Exception;

class LaboratoryController extends ApiController
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
            $services = Laboratory::all();

            if ($services)
            {
                return $this->sendResponse(LaboratoryResource::collection($services), 'Laboratories sucessfully listed.');
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
    public function store(StoreLaboratoryRequest $request)
    {
        try
        {
            $service = Laboratory::create($request->validated());

            if ($service)
            {
                return $this->sendResponse(new LaboratoryResource($service), 'Laboratory sucessfully created.');
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
     * @param  \App\Models\Laboratory  $service
     * @return \Illuminate\Http\Response
     */
    public function show($service_id)
    {
        try
        {
            $service = Laboratory::find($service_id);

            if ($service)
            {
                return $this->sendResponse(new LaboratoryResource($service), 'Laboratory sucessfully found.');
            }
            else
            {
                return $this->sendError('Laboratory not found');
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
     * @param  \App\Models\Laboratory  $service
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateLaboratoryRequest $request, $service_id)
    {
        try
        {
            $validated = $request->safe()->except(['service_id']);
            $service = Laboratory::find($service_id);

            if ($service)
            {
                $service->update($validated);
                return $this->sendResponse(new LaboratoryResource($service), 'Laboratory sucessfully updated.');
            }
            else
            {
                return $this->sendError('Laboratory not found');
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
     * @param  \App\Models\Laboratory  $service
     * @return \Illuminate\Http\Response
     */
    public function destroy($service_id)
    {
        try
        {
            $service = Laboratory::find($service_id);

            if ($service)
            {
                $service->delete();
                return $this->sendResponse([], 'Laboratory sucessfully deleted.');
            }
            else
            {
                return $this->sendError('Laboratory not found');
            }
        }
        
        catch(Exception $e)
        {
            return $this->sendError($e->errorInfo[2]);
        }
    }
}