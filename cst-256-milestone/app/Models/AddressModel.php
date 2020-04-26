<?php

namespace App\Models;

class AddressModel{
    
    //Attrubutes corresponding to the database columns for the table representing the same object type
    private $id;
    private $street;
    private $city;
    private $state;
    private $zip;
    private $userID;
    
    //Constructor that sets all of the attributes equal to the arguments passed
    public function __construct($id, $street, $city, $state, $zip, $userID){
        $this->id = $id;
        $this->street = $street;
        $this->city = $city;
        $this->state = $state;
        $this->zip = $zip;
        $this->userID = $userID;
    }
    
    /**
     * @return string
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * @return string
     */
    public function getStreet()
    {
        return $this->street;
    }

    /**
     * @return string
     */
    public function getCity()
    {
        return $this->city;
    }

    /**
     * @return string
     */
    public function getState()
    {
        return $this->state;
    }

    /**
     * @return string
     */
    public function getZip()
    {
        return $this->zip;
    }

    /**
     * @return int
     */
    public function getUserID()
    {
        return $this->userID;
    }

}