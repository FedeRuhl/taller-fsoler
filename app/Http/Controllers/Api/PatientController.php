<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Api\ApiController;
use App\Http\Requests\Patient\StorePatientRequest;
use App\Http\Requests\Patient\UpdatePatientRequest;
use App\Http\Resources\PatientResource;
use App\Models\Patient;
use Exception;

class PatientController extends ApiController
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
            $patients = Patient::all();

            if ($patients)
            {
                return $this->sendResponse(PatientResource::collection($patients), 'Patients sucessfully listed.');
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
    public function store(StorePatientRequest $request)
    {
        try
        {
            $patient = Patient::create($request->validated());

            if ($patient)
            {
                return $this->sendResponse(new PatientResource($patient), 'Patient sucessfully created.');
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
     * @param  \App\Models\Patient  $patient
     * @return \Illuminate\Http\Response
     */
    public function show($patient_id)
    {
        try
        {
            $patient = Patient::find($patient_id);

            if ($patient)
            {
                return $this->sendResponse(new PatientResource($patient), 'Patient sucessfully found.');
            }
            else
            {
                return $this->sendError('Patient not found');
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
     * @param  \App\Models\Patient  $patient
     * @return \Illuminate\Http\Response
     */
    public function update(UpdatePatientRequest $request, $patient_id)
    {
        try
        {
            $validated = $request->safe()->except(['patient_id']);
            $patient = Patient::find($patient_id);

            if ($patient)
            {
                $patient->update($validated);
                return $this->sendResponse(new PatientResource($patient), 'Patient sucessfully updated.');
            }
            else
            {
                return $this->sendError('Patient not found');
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
     * @param  \App\Models\Patient  $patient
     * @return \Illuminate\Http\Response
     */
    public function destroy($patient_id)
    {
        try
        {
            $patient = Patient::find($patient_id);

            if ($patient)
            {
                $patient->delete();
                return $this->sendResponse([], 'Patient sucessfully deleted.');
            }
            else
            {
                return $this->sendError('Patient not found');
            }
        }
        
        catch(Exception $e)
        {
            return $this->sendError($e->errorInfo[2]);
        }
    }
}
