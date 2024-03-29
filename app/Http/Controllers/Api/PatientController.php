<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Api\ApiController;
use App\Http\Requests\Patient\StorePatientRequest;
use App\Http\Requests\Patient\UpdatePatientRequest;
use App\Http\Resources\PatientResource;
use App\Models\Patient;
use App\Models\PatientAddress;
use App\Models\Person;
use Exception;

class PatientController extends ApiController
{
    // TODO: agregar lista de teléfono en el store y en el update, y ver si remover el phone controller.
    // TODO: también analizar si agregar teléfono al crear un user común (personal sanidad)

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
            $person = Person::create(
                $request->only([
                    'dni',
                    'first_name',
                    'last_name',
                    'birth_date'
                ])
            );

            $patientAddress = PatientAddress::create(
                $request->only([
                    'province_id',
                    'city_id',
                    'street',
                    'number'
                ])
            );

            $patient = Patient::create(
                $request->merge([
                    'person_id' => $person->id,
                    'patient_address_id' => $patientAddress->id
                ])->only([
                    'os_number',
                    'is_military',
                    'unit_id',
                    'phone',
                    'person_id',
                    'patient_address_id'
                ])
            );

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
            $patient = Patient::find($patient_id);
            
            if ($patient)
            {
                if ($request->hasAny(['dni', 'first_name', 'last_name', 'birth_date']))
                {
                    $patient->person()->update($request->only([
                        'dni',
                        'first_name',
                        'last_name',
                        'birth_date'
                    ]));
                }

                if ($request->hasAny(['province_id', 'city_id', 'street', 'number']))
                {
                    $patient->address()->update($request->only([
                        'province_id',
                        'city_id',
                        'street',
                        'number'
                    ]));
                }
    
                if ($request->hasAny(['os_number', 'is_military', 'unit_id', 'phone']))
                {
                    $patient->update($request->only([
                        'os_number',
                        'is_military',
                        'unit_id',
                        'phone'
                    ]));
                }

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
                $patient->person()->delete(); //cascade
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
