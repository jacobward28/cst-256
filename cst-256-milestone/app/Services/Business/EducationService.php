<?php

namespace App\Services\Business;

use App\Services\Utility\Connection;
use App\Services\Utility\ILoggerService;
use App\Services\Data\EducationDAO;
use App\Models\EducationModel;

class EducationService{
    
    public function findByID(int $id, ILoggerService $logger){

        $logger->info("Entering EducationService.findByID()");
        
        //Gets a connection to the database
        $connection = new Connection();
        
        //Creates an instance of the data access object
        $DAO = new EducationDAO($connection, $logger);
        
        //Calls the associated dao function and stores the results
        $results = $DAO->getByID($id);
        
        //Destroys the connection to the database 
        $connection = null;
        
        $logger->info("Exiting EducationService.findByID()");
        
        return $results;
    }
    
    public function getAll(ILoggerService $logger){
        
        $logger->info("Entering EducationService.getAll()");
        
        //Gets a connection to the database
        $connection = new Connection();
        
        //Creates an instance of the data access object
        $DAO = new EducationDAO($connection, $logger);
        
        //Calls the associated dao function and stores the results
        $results = $DAO->getAll();
        
        //Destroys the connection to the database
        $connection = null;
        
        $logger->info("Exiting EducationService.getAll()");
        
        return $results;
    }
    
    public function create(EducationModel $education, ILoggerService $logger){
        
        $logger->info("Entering EducationService.create()");
        
        //Gets a connection to the database
        $connection = new Connection();
        
        //Creates an instance of the data access object
        $DAO = new EducationDAO($connection, $logger);
        
        //Calls the associated dao function and stores the results
        $results = $DAO->create($education);
        
        //Destroys the connection to the database
        $connection = null;
        
        $logger->info("Exiting EducationService.create()");
        
        return $results;
    }
    
    public function update(EducationModel $education, ILoggerService $logger){
        
        $logger->info("Entering EducationService.update()");
        
        //Gets a connection to the database
        $connection = new Connection();
        
        //Creates an instance of the data access object
        $DAO = new EducationDAO($connection, $logger);
        
        //Calls the associated dao functino and stores the results
        $results = $DAO->update($education);
        
        //Destroys the connection to the database
        $connection = null;
        
        $logger->info("Exiting EducationService.update()");
        
        return $results;
    }
    
    public function remove(int $id, ILoggerService $logger){
        
        $logger->info("Entering EducationService.remove()");
        
        //Gets a connection to the database
        $connection = new Connection();
        
        //Creates an instance of the data access object
        $DAO = new EducationDAO($connection, $logger);
        
        //Calls the associated dao functino and stores the results
        $results = $DAO->remove($id);
        
        //Destroys the connection to the database
        $connection = null;
        
        $logger->info("Exiting EducationService.remove()");
        
        return $results;
    }
}