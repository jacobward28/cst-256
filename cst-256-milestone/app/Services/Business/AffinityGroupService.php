<?php

namespace App\Services\Business;

use App\Services\Utility\ILoggerService;
use PDO;
use App\Services\Utility\Connection;
use App\Services\Data\AffinityGroupDAO;
use App\Models\AffinityGroupModel;
use App\Services\Utility\DatabaseException;

class AffinityGroupService{
    
    /*
     * Gets an affinity group with a particular id
     */
    public function getByID(int $id, ILoggerService $logger){
        
        $logger->info("Entering AffinityGroupService.getByID()");
        
        //Creates a connection to the database
        $connection = new Connection();
        
        //Creates an instance of the dao
        $DAO = new AffinityGroupDAO($connection, $logger);
        
        //Stores the results of the dao method call
        $results = $DAO->getByID($id);
        
        $connection = null;
        
        $logger->info("Exiting AffinityGroupService.getByID()");
        
        return $results;
    }
    
    /*
     * Gets all of the affinity groups that a particular user owns
     */
    public function getAllOwned($userID, ILoggerService $logger){
        
        $logger->info("Entering AffinityGroupService.getAllOwned()");
        
        //Creates a connection to the database
        $connection = new Connection();
        
        //Creates an instance of the dao
        $DAO = new AffinityGroupDAO($connection, $logger);
        
        //Stores the results of the dao method call
        $results = $DAO->getOwned($userID);
        
        $connection = null;
        
        $logger->info("Exiting AffinityGroupService.getAllOwned()");
        
        return $results;
    }
    
    /*
     * Gets all of the affinity groups in the database
     */
    public function getAll(ILoggerService $logger){
        
        $logger->info("Entering AffinityGroupService.getAll()");
        
        //Creates a connection to the database
        $connection = new Connection();
        
        //Creates an instance of the dao
        $DAO = new AffinityGroupDAO($connection, $logger);
        
        //Stores the results of the dao method call
        $results = $DAO->getAll();
        
        $connection = null;
        
        $logger->info("Exiting AffinityGroupService.getAll()");
        
        return $results;
    }
    
    /*
     * Creates a new group entry in the database
     */
    public function createGroup(AffinityGroupModel $group, ILoggerService $logger){
        
        $logger->info("Entering AffinityGroupService.createGroup()");
        
        try{
        //Creates a connection to the database
        $connection = new Connection();
        //Turns off auto-commit on this instance of the connection
        $connection->setAttribute(PDO::ATTR_AUTOCOMMIT, 0);
        //Begins a transaction
        $connection->beginTransaction();
        
        //Creates an instance of the group dao
        $DAO = new AffinityGroupDAO($connection, $logger);
        
        //Gets the result of the group dao method call
        $results = $DAO->create($group);
        
        //If the dao method succeded continue the transaction
        if($results['result']){
            $connection->commit();

            } else {
                //Rollback the connection if the member service method failed
                $connection->rollBack();
            }
        
        $connection = null;
        
        } catch (\Exception $e){
            $logger->error("Database exception: ", $e->getMessage());
            $connection->rollBack();
            throw new DatabaseException("Exception: " . $e->getMessage(), $e, 0);
        }
        
        $logger->info("Exiting AffinityGroupService.createGroup()");
        
        return $results['result'];
    }
    
    /*
     * Method for editing an existing group in the database
     */
    public function editGroup(AffinityGroupModel $group, ILoggerService $logger){
        
        $logger->info("Entering AffinityGroupService.editGroup()");

        //Get a connection to the database
        $connection = new Connection();
           
        //Create an instance of the dao
        $DAO = new AffinityGroupDAO($connection, $logger);
            
        //Store the results of the dao method call
        $results = $DAO->edit($group);
        
        $connection = null;
            
        $logger->info("Exiting AffinityGroupService.editGroup()");
            
        return $results;
    }
    
    /*
     * Method for deleting an existing group in the database
     */
    public function deleteGroup(int $id, ILoggerService $logger){
        
        $logger->info("Entering AffinityGroupService.deleteGroup()");
        
        //Get a connection to the database
        $connection = new Connection();
        
        //Creates an instance of the dao
        $DAO = new AffinityGroupDAO($connection, $logger);
        
        //Store the results of the dao method call
        $results = $DAO->delete($id);
        
        $connection = null;
        
        $logger->info("Exiting AffinityGroupService.deleteGroup()");
        
        return $results;
    }
}