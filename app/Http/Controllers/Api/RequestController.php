<?php

namespace App\Http\Controllers\Api;

use Exception;
use App\Models\Request;
use App\Http\Resources\RequestResource;
use App\Http\Requests\Request\StoreRequestRequest;
use App\Http\Requests\Request\UpdateRequestRequest;

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
            $requestModel = Request::create($request->validated());

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
        try
        {
            $validated = $request->safe()->except(['request_id']);
            $request = Request::find($request_id);

            if ($request)
            {
                $request->update($validated);
                return $this->sendResponse(new RequestResource($request), 'Request sucessfully updated.');
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
}
