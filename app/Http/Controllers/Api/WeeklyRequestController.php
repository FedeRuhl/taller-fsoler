<?php

namespace App\Http\Controllers\Api;

use Exception;
use App\Models\WeeklyRequest;
use App\Http\Resources\WeeklyRequestResource;
use App\Http\Requests\WeeklyRequest\StoreWeeklyRequestRequest;
use App\Http\Requests\WeeklyRequest\UpdateWeeklyRequestRequest;

class WeeklyRequestController extends ApiController
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
            $requests = WeeklyRequest::all();

            if ($requests)
            {
                return $this->sendResponse(WeeklyRequestResource::collection($requests), 'Weekly Requests sucessfully listed.');
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
    public function store(StoreWeeklyRequestRequest $request)
    {
        try
        {
            $requestModel = WeeklyRequest::create($request->validated());

            if ($requestModel)
            {
                return $this->sendResponse(new WeeklyRequestResource($requestModel), 'Weekly Request sucessfully created.');
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
            $request = WeeklyRequest::find($request_id);

            if ($request)
            {
                return $this->sendResponse(new WeeklyRequestResource($request), 'Weekly Request sucessfully found.');
            }
            else
            {
                return $this->sendError('Weekly Request not found');
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
    public function update(UpdateWeeklyRequestRequest $request, $request_id)
    {
        try
        {
            $validated = $request->safe()->except(['request_id']);
            $request = WeeklyRequest::find($request_id);

            if ($request)
            {
                $request->update($validated);
                return $this->sendResponse(new WeeklyRequestResource($request), 'Weekly Request sucessfully updated.');
            }
            else
            {
                return $this->sendError('Weekly Request not found');
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
     * @param  \App\Models\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function destroy($request_id)
    {
        try
        {
            $request = WeeklyRequest::find($request_id);

            if ($request)
            {
                $request->delete();
                return $this->sendResponse([], 'Weekly Request sucessfully deleted.');
            }
            else
            {
                return $this->sendError('Weekly Request not found');
            }
        }
        
        catch(Exception $e)
        {
            return $this->sendError($e->errorInfo[2]);
        }
    }
}
