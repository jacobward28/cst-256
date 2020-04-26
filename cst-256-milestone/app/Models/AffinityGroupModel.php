<?php

namespace App\Models;

class AffinityGroupModel{
    
    private $id;
    private $name;
    private $description;
    private $focus;
    private $userID;
    
    public function __construct($id, $name, $description, $focus, $userID){
        $this->id = $id;
        $this->name = $name;
        $this->description = $description;
        $this->focus = $focus;
        $this->userID = $userID;
    }
    
    /**
     * @return mixed
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * @return mixed
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * @return mixed
     */
    public function getDescription()
    {
        return $this->description;
    }

    /**
     * @return mixed
     */
    public function getFocus()
    {
        return $this->focus;
    }

    /**
     * @return mixed
     */
    public function getUserID()
    {
        return $this->userID;
    }
}