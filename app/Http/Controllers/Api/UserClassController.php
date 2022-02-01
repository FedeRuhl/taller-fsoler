<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Api\ApiController;
use App\Http\Requests\UserClass\StoreUserClassRequest;
use App\Http\Requests\UserClass\UpdateUserClassRequest;
use App\Http\Resources\UserClassResource;
use App\Models\UserClass;
use Exception;

class UserClassController extends ApiController
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
            $userClasses = UserClass::all();

            if ($userClasses)
            {
                return $this->sendResponse(UserClassResource::collection($userClasses), 'User classes sucessfully listed.');
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
    public function store(StoreUserClassRequest $request)
    {
        try
        {
            $userClass = UserClass::create($request->validated());

            if ($userClass)
            {
                return $this->sendResponse(new UserClassResource($userClass), 'User class sucessfully created.');
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
     * @param  \App\Models\UserClass  $userClass
     * @return \Illuminate\Http\Response
     */
    public function show($user_class_id)
    {
        try
        {
            $userClass = UserClass::find($user_class_id);

            if ($userClass)
            {
                return $this->sendResponse(new UserClassResource($userClass), 'User class sucessfully found.');
            }
            else
            {
                return $this->sendError('User class not found');
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
     * @param  \App\Models\UserClass  $userClass
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateUserClassRequest $request, $user_class_id)
    {
        try
        {
            $validated = $request->safe()->except(['user_class_id']);
            $userClass = UserClass::find($user_class_id);

            if ($userClass)
            {
                $userClass->update($validated);
                $userClass->save();
                return $this->sendResponse(new UserClassResource($userClass), 'User class sucessfully updated.');
            }
            else
            {
                return $this->sendError('User class not found');
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
     * @param  \App\Models\UserClass  $userClass
     * @return \Illuminate\Http\Response
     */
    public function destroy($user_class_id)
    {
        try
        {
            $userClass = UserClass::find($user_class_id);

            if ($userClass)
            {
                $userClass->delete();
                return $this->sendResponse([], 'User class sucessfully deleted.');
            }
            else
            {
                return $this->sendError('User class not found');
            }
        }
        
        catch(Exception $e)
        {
            return $this->sendError($e->errorInfo[2]);
        }
    }
}
