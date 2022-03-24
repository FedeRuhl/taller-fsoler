<?php

namespace App\Services;

use App\Models\User;
use App\Services\Error;

class BaseService 
{
    private $user;
    private $errorDefinitions; 
    private $lastError;     

    function __construct($user)
    {
        $this->errorDefinitions = [];
        $this->user = $user;
        
        $this->clearLastError();        
    }

    public function getUserId()
    {
        return $this->user->id ?? null;
    }

    public function setError($code)
    {   
        $this->lastError = $this->getErrorByCode($code);
    }

    public function clearLastError()
    {
        $this->lastError = null;
    }
    
    public function setErrorData($code, $description, $type, $httpcode)
    {
        $this->lastError = new Error($code, $description, $type, $httpcode);
    }

    public function hasErrors()
    {
        return ($this->lastError != null); 
    }

    public function getLastError()
    {
        return $this->lastError; 
    }

    private function getErrorByCode($code) 
    {
        foreach($this->errorDefinitions as $error) {
            if ($error->code == $code) {
                return $error;
            }
        }
    }
}