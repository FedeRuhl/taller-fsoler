<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Api\ApiController;
use App\Http\Requests\Service\StoreServiceRequest;
use App\Http\Requests\Service\UpdateServiceRequest;
use App\Http\Resources\ServiceResource;
use App\Models\Service;
use Exception;

class ServiceController extends ApiController
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
            $services = Service::all();

            if ($services)
            {
                return $this->sendResponse(ServiceResource::collection($services), 'Services sucessfully listed.');
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
    public function store(StoreServiceRequest $request)
    {
        try
        {
            $service = Service::create($request->validated());

            if ($service)
            {
                return $this->sendResponse(new ServiceResource($service), 'Service sucessfully created.');
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
     * @param  \App\Models\Service  $service
     * @return \Illuminate\Http\Response
     */
    public function show($service_id)
    {
        try
        {
            $service = Service::find($service_id);

            if ($service)
            {
                return $this->sendResponse(new ServiceResource($service), 'Service sucessfully found.');
            }
            else
            {
                return $this->sendError('Service not found');
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
     * @param  \App\Models\Service  $service
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateServiceRequest $request, $service_id)
    {
        try
        {
            $validated = $request->safe()->except(['service_id']);
            $service = Service::find($service_id);

            if ($service)
            {
                $service->update($validated);
                return $this->sendResponse(new ServiceResource($service), 'Service sucessfully updated.');
            }
            else
            {
                return $this->sendError('Service not found');
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
     * @param  \App\Models\Service  $service
     * @return \Illuminate\Http\Response
     */
    public function destroy($service_id)
    {
        try
        {
            $service = Service::find($service_id);

            if ($service)
            {
                $service->delete();
                return $this->sendResponse([], 'Service sucessfully deleted.');
            }
            else
            {
                return $this->sendError('Service not found');
            }
        }
        
        catch(Exception $e)
        {
            return $this->sendError($e->errorInfo[2]);
        }
    }
}
