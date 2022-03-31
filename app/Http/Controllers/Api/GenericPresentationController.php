<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Api\ApiController;
use App\Http\Requests\Generic\StoreGenericRequest;
use App\Http\Requests\GenericPresentation\StoreGenericPresentationRequest;
use App\Http\Requests\GenericPresentation\UpdateGenericPresentationRequest;
use App\Http\Resources\GenericPresentationResource;
use App\Models\GenericPresentation;
use DB;
use Exception;

class GenericPresentationController extends ApiController
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
            $generics = GenericPresentation::all();

            if ($generics)
            {
                return $this->sendResponse(GenericPresentationResource::collection($generics), 'Generic presentations sucessfully listed.');
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
    public function store(StoreGenericPresentationRequest $request)
    {
        try
        {
            $genericPresentation = GenericPresentation::create($request->validated());

            if ($genericPresentation)
            {
                return $this->sendResponse(new GenericPresentationResource($genericPresentation), 'Generic presentation sucessfully created.');
            }
        }
        
        catch(Exception $e)
        {
            return $this->sendError($e->errorInfo[2]);
        }
    }

    // /**
    //  * Display the specified resource.
    //  *
    //  * @param  \App\Models\Generic  $generic
    //  * @return \Illuminate\Http\Response
    //  */
    public function show($generic_id)
    {
        try
        {
            $generic = GenericPresentation::find($generic_id);

            if ($generic)
            {
                return $this->sendResponse(new GenericPresentationResource($generic), 'Generic Presentation sucessfully found.');
            }
            else
            {
                return $this->sendError('Generic Presentation not found');
            }
        }
        
        catch(Exception $e)
        {
            return $this->sendError($e->errorInfo[2]);
        }
    }

    // /**
    //  * Update the specified resource in storage.
    //  *
    //  * @param  \Illuminate\Http\Request  $request
    //  * @param  \App\Models\Generic  $generic
    //  * @return \Illuminate\Http\Response
    //  */
    public function update(UpdateGenericPresentationRequest $request, $generic_presentation_id)
    {
        try
        {
            $validated = $request->safe()->except(['generic_presentation_id']);
            $genericPresentation = GenericPresentation::find($generic_presentation_id);

            if ($genericPresentation)
            {
                $genericPresentation->update($validated);
                $genericPresentation->save();
                return $this->sendResponse(new GenericPresentationResource($genericPresentation), 'Generic Presentation sucessfully updated.');
            }
            else
            {
                return $this->sendError('Generic Presentation not found');
            }
        }
        
        catch(Exception $e)
        {
            return $this->sendError($e->errorInfo[2]);
        }
    }

    // /**
    //  * Remove the specified resource from storage.
    //  *
    //  * @param  \App\Models\Generic  $generic
    //  * @return \Illuminate\Http\Response
    //  */
    public function destroy($generic_presentation_id)
    {
        try
        {
            $genericPresentation = GenericPresentation::find($generic_presentation_id);

            if ($genericPresentation)
            {
                $genericPresentation->delete();
                return $this->sendResponse([], 'Generic Presentation sucessfully deleted.');
            }
            else
            {
                return $this->sendError('Generic Presentation not found');
            }
        }
        
        catch(Exception $e)
        {
            return $this->sendError($e->errorInfo[2]);
        }
    }
}
