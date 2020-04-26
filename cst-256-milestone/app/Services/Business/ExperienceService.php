<?php


namespace App\Services\Business;

use App\Services\Utility\Connection;
use App\Services\Utility\ILoggerService;
use App\Services\Data\ExperienceDAO;
use App\Models\ExperienceModel;

class ExperienceService{
    
    public function findByID(int $id, ILoggerService $logger){
        
        $logger->info("Entering ExperienceService.findByID()");
        
        //Gets a connection to the database
        $connection = new Connection();
        
        //Creates an instance of the data access object
        $DAO = new ExperienceDAO($connection, $logger);
        
        //Calls the appropriate dao function and stores the results
        $results = $DAO->getByID($id);
        
        //Destroys the connection to the database
        $connection = null;
        
        $logger->info("Exiting ExperienceService.findByID()");
        
        return $results;
    }
    
    public function getAll(ILoggerService $logger){
        
        $logger->info("Entering ExperienceService.getAll()");
        
        //Gets a connection to the database
        $connection = new Connection();
        
        //Creates an instance of the data access object
        $DAO = new ExperienceDAO($connection, $logger);
        
        //Calls the appropriate dao function and stores the results
        $results = $DAO->getAll();
        
        //Destroys the connection to the database
        $connection = null;
        
        $logger->info("Exiting ExperienceService.getAll()");
        
        return $results;
    }
    
    public function create(ExperienceModel $experience, ILoggerService $logger){
        
        $logger->info("Entering ExperienceService.create()");
        
        //Gets a connection to the database
        $connection = new Connection();
        
        //Creates an instance of the data access object
        $DAO = new ExperienceDAO($connection, $logger);
        
        //Calls the appropriate dao function and stores the results
        $results = $DAO->create($experience);
        
        //Destroys the connection to the database
        $connection = null;
        
        $logger->info("Exiting ExperienceService.create()");
        
        return $results;
    }
    
    public function update(ExperienceModel $experience, ILoggerService $logger){
        
        $logger->info("Entering ExperienceService.update()");
        
        //Gets a connection to the database
        $connection = new Connection();
        
        //Creates an instance of the data access object
        $DAO = new ExperienceDAO($connection, $logger);
        
        //Calls the appropriate dao function and stores the results
        $results = $DAO->update($experience);
        
        //Destroys the connection to the database
        $connection = null;
        
        $logger->info("Exiting ExperienceService.update()");
        
        return $results;
    }
    
    public function remove(int $id, ILoggerService $logger){
        
        $logger->info("Entering ExperienceService.remove()");
        
        //Gets a connection to the database
        $connection = new Connection();
        
        //Creates an instance of the data access object
        $DAO = new ExperienceDAO($connection, $logger);
        
        //Calls the appropriate dao function and stores the results
        $results = $DAO->remove($id);
        
        //Destroys the connection to the database
        $connection = null;
        
        $logger->info("Exiting ExperienceService.remove()");
        
        return $results;
    }
}