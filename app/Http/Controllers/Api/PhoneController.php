<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Api\ApiController;
use App\Http\Requests\Phone\IndexPhoneRequest;
use App\Http\Requests\Phone\StorePhoneRequest;
use App\Http\Requests\Phone\UpdatePhoneRequest;
use App\Http\Resources\PhoneResource;
use App\Models\Phone;
use Exception;
use Illuminate\Http\Request;

class PhoneController extends ApiController
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(IndexPhoneRequest $request)
    {
        try
        {
            $personId = $request->route('person_id');
            $phones = Phone::where('person_id', $personId)->get();

            if ($phones)
            {
                return $this->sendResponse(PhoneResource::collection($phones), 'Phones sucessfully listed.');
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
    public function store(StorePhoneRequest $request)
    {
        try
        {
            $phone = Phone::create($request->validated());

            if ($phone)
            {
                return $this->sendResponse(new PhoneResource($phone), 'Phone sucessfully created.');
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
     * @param  \App\Models\Phone  $phone
     * @return \Illuminate\Http\Response
     */
    public function show($phone_id)
    {
        try
        {
            $phone = Phone::find($phone_id);

            if ($phone)
            {
                return $this->sendResponse(new PhoneResource($phone), 'Phone sucessfully found.');
            }
            else
            {
                return $this->sendError('Phone not found');
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
     * @param  \App\Models\Phone  $phone
     * @return \Illuminate\Http\Response
     */
    public function update(UpdatePhoneRequest $request, $phone_id)
    {
        try
        {
            $validated = $request->safe()->except(['phone_id']);
            $phone = Phone::find($phone_id);

            if ($phone)
            {
                $phone->update($validated);
                return $this->sendResponse(new PhoneResource($phone), 'Phone sucessfully updated.');
            }
            else
            {
                return $this->sendError('Phone not found');
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
     * @param  \App\Models\Phone  $phone
     * @return \Illuminate\Http\Response
     */
    public function destroy($phone_id)
    {
        try
        {
            $phone = Phone::find($phone_id);

            if ($phone)
            {
                $phone->delete();
                return $this->sendResponse([], 'Phone sucessfully deleted.');
            }
            else
            {
                return $this->sendError('Phone not found');
            }
        }
        
        catch(Exception $e)
        {
            return $this->sendError($e->errorInfo[2]);
        }
    }
}
