<?php

class Shippo_RateLimitError extends Shippo_InvalidRequestError
{
    public function __construct($message, $param, $httpStatus = null, $httpBody = null, $jsonBody = null)
    {
        parent::__construct($message, $httpStatus, $httpBody, $jsonBody);
    }
}
