<?php

namespace App\Services;

class Error
{
    private $code; 
    private $description; 
    private $type; 
    private $httpCode; 

    function __construct($code, $description, $type, $httpcode)  
    {   
        $this->code = $code;
        $this->description = $description;
        $this->type = $type;
        $this->httpCode = $httpcode;
    }

    public function getCode()
    {
        return $this->code;
    }

    public function getDescription()
    {
        return $this->description;
    }

    public function getType()
    {
        return $this->type;
    }

    public function getHttpCode()
    {
        return $this->httpCode;
    }
}