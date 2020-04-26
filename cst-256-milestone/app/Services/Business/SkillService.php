<?php


namespace App\Services\Business;

use App\Models\SkillModel;
use App\Services\Utility\Connection;
use App\Services\Utility\ILoggerService;
use App\Services\Data\SkillDAO;

class SkillService{
    
    //Takes in a user id and finds all the skills associated with the user
    public function findByID(int $userID, ILoggerService $logger){
        
        $logger->info("Entering SkillService.findByID()");
        
        //Gets a connection to the database
        $connection = new Connection();
        
        //Creates an instance of the data access object
        $DAO = new SkillDAO($connection, $logger);
        
        //Calls the appropriate dao method and stores the results
        $results = $DAO->findByID($userID);
        
        //Destroys the connection to the database
        $connection = null;
        
        $logger->info("Exiting SkillService.findByID()");
        
        return $results;
    }
    
    //Takes in a skill model and attempts to create an entry in the database with the information contained in the model
    public function create(SkillModel $skill, ILoggerService $logger){
        
        $logger->info("Entering SkillService.create()");
        
        //Gets a connection to the database
        $connection = new Connection();
        
        //Creates an instance of the data access object
        $DAO = new SkillDAO($connection, $logger);
        
        //Calls the appropriate dao method and stores the results
        $results = $DAO->create($skill);
        
        //Destroys the connection to the database
        $connection = null;
        
        $logger->info("Exiting SkillService.create()");
        
        return $results;
    }
    
    //Takes in a skill id and attempts to remove the associated database entry
    public function remove(int $id, ILoggerService $logger){
        
        $logger->info("Entering SkillService.remove()");
        
        //Gets a connection to the database
        $connection = new Connection();
        
        //Creates an instance of the data access object
        $DAO = new SkillDAO($connection, $logger);
        
        //Calls the appropriate dao method and stores the results
        $results = $DAO->remove($id);
        
        //Destroys the connection to the database
        $connection = null;
        
        $logger->info("Exiting SkillService.remove()");
        
        return $results;
    }
}