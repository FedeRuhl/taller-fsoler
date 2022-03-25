<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Api\ApiController;
use App\Http\Requests\Generic\StoreGenericRequest;
use App\Http\Requests\Generic\UpdateGenericRequest;
use App\Http\Resources\GenericResource;
use App\Models\Generic;
use DB;
use Exception;

class GenericController extends ApiController
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
            $generics = Generic::all();

            if ($generics)
            {
                return $this->sendResponse(GenericResource::collection($generics), 'Generics sucessfully listed.');
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
    public function store(StoreGenericRequest $request)
    {
        try
        {
            $presentationIds = $request->get('presentation_ids');
            $genericData = $request->safe()->except('presentation_ids');

            DB::beginTransaction();

            $generic = Generic::create($genericData);
            $generic->presentations()->sync($presentationIds);

            if ($generic)
            {
                DB::commit();
                return $this->sendResponse(new GenericResource($generic), 'Generic sucessfully created.');
            }

            DB::rollback();
        }
        
        catch(Exception $e)
        {
            dd($e);
            DB::rollback();
            return $this->sendError($e->errorInfo[2]);
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Generic  $generic
     * @return \Illuminate\Http\Response
     */
    public function show($generic_id)
    {
        try
        {
            $generic = Generic::find($generic_id);

            if ($generic)
            {
                return $this->sendResponse(new GenericResource($generic), 'Generic sucessfully found.');
            }
            else
            {
                return $this->sendError('Generic not found');
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
     * @param  \App\Models\Generic  $generic
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateGenericRequest $request, $generic_id)
    {
        try
        {
            $validated = $request->safe()->except(['generic_id', 'presentation_ids']);
            $generic = Generic::find($generic_id);

            if ($generic)
            {
                $generic->update($validated);

                if ($request->has('presentation_ids'))
                {
                    $presentationIds = $request->get('presentation_ids');
                    $generic->presentations()->sync($presentationIds);
                }

                return $this->sendResponse(new GenericResource($generic), 'Generic sucessfully updated.');
            }
            else
            {
                return $this->sendError('Generic not found');
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
     * @param  \App\Models\Generic  $generic
     * @return \Illuminate\Http\Response
     */
    public function destroy($generic_id)
    {
        try
        {
            $generic = Generic::find($generic_id);

            if ($generic)
            {
                $generic->delete();
                return $this->sendResponse([], 'Generic sucessfully deleted.');
            }
            else
            {
                return $this->sendError('Generic not found');
            }
        }
        
        catch(Exception $e)
        {
            return $this->sendError($e->errorInfo[2]);
        }
    }
}
