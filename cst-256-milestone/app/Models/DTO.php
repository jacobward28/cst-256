<?php

namespace App\Models;

class DTO implements \JsonSerializable
{

    private $errorCode;
    private $errorMessage;
    private $data;

    /**
     * DTO constructor.
     * @param $errorCode
     * @param $errorMessage
     * @param $data
     */
    public function __construct($errorCode, $errorMessage, $data)
    {
        $this->errorCode = $errorCode;
        $this->errorMessage = $errorMessage;
        $this->data = $data;
    }

    /**
     * Specify data which should be serialized to JSON.
     *
     * @link http://php.net/manual/en/jsonserializable.jsonserialize.php
     *
     * @return mixed data which can be serialized by <b>json_encode</b>,
     *               which is a value of any type other than a resource.
     *
     * @since 5.4.0
     */
    public function jsonSerialize()
    {
        return get_object_vars($this);
    }
}