<?php

namespace App\Models;

class ExperienceModel{
    
    private $id;
    private $title;
    private $company;
    private $current;
    private $startyear;
    private $endyear;
    private $description;
    private $userID;
    
    public function __construct($id, $title, $company, $current, $startyear, $endyear, $description, $userID){
        $this->id = $id;
        $this->title = $title;
        $this->company = $company;
        $this->current = $current;
        $this->startyear = $startyear;
        $this->endyear = $endyear;
        $this->description = $description;
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
    public function getTitle()
    {
        return $this->title;
    }

    /**
     * @return mixed
     */
    public function getCompany()
    {
        return $this->company;
    }

    /**
     * @return mixed
     */
    public function getCurrent()
    {
        return $this->current;
    }

    /**
     * @return mixed
     */
    public function getStartyear()
    {
        return $this->startyear;
    }

    /**
     * @return mixed
     */
    public function getEndyear()
    {
        return $this->endyear;
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
    public function getUserID()
    {
        return $this->userID;
    }

}