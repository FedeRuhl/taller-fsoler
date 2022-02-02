<?php

namespace App\Http\Controllers\Api;

use Exception;
use App\Models\User;
use App\Models\Person;
use App\Http\Resources\UserResource;
use App\Http\Controllers\Api\ApiController;
use App\Http\Requests\User\StoreUserRequest;
use App\Http\Requests\User\UpdateUserRequest;

class UserController extends ApiController
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
            $users = User::all();

            if ($users)
            {
                return $this->sendResponse(UserResource::collection($users), 'Users sucessfully listed.');
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
    public function store(StoreUserRequest $request)
    {
        try
        {
            $person = Person::create(
                $request->only([
                    'dni',
                    'first_name',
                    'last_name',
                    'birth_date'
                ])
            );

            $user = User::create(
                $request->merge([
                    'person_id' => $person->id
                ])->only([
                    'docket',
                    'email',
                    'password',
                    'user_class_id',
                    'person_id'
                ])
            );

            if ($user)
            {
                return $this->sendResponse(new UserResource($user), 'User sucessfully created.');
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
     * @param  \App\Models\User  $user
     * @return \Illuminate\Http\Response
     */
    public function show($user_id)
    {
        try
        {
            $user = User::find($user_id);

            if ($user)
            {
                return $this->sendResponse(new UserResource($user), 'User sucessfully found.');
            }
            else
            {
                return $this->sendError('User not found');
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
     * @param  \App\Models\User  $user
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateUserRequest $request, $user_id)
    {
        try
        {
            $user = User::find($user_id);
            
            if ($user)
            {
                if ($request->hasAny(['dni', 'first_name', 'last_name', 'birth_date']))
                {
                    $user->person()->update($request->only([
                        'dni',
                        'first_name',
                        'last_name',
                        'birth_date'
                    ]));
                }
    
                if ($request->hasAny(['docket', 'email', 'password', 'user_class_id']))
                {
                    $user->update($request->only([
                        'docket',
                        'email',
                        'password',
                        'user_class_id'
                    ]));
                }

                return $this->sendResponse(new UserResource($user), 'User sucessfully updated.');
            }
            else
            {
                return $this->sendError('User not found');
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
     * @param  \App\Models\User  $user
     * @return \Illuminate\Http\Response
     */
    public function destroy($user_id)
    {
        try
        {
            $user = User::find($user_id);

            if ($user)
            {
                $user->person()->delete(); //cascade
                return $this->sendResponse([], 'User sucessfully deleted.');
            }
            else
            {
                return $this->sendError('User not found');
            }
        }
        
        catch(Exception $e)
        {
            return $this->sendError($e->errorInfo[2]);
        }
    }
}
