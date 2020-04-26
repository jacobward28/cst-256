<?php

namespace App\Services\Data;

use App\Services\Utility\ILoggerService;
use PDO;
use App\Services\Utility\DatabaseException;
use App\Models\AffinityGroupModel;

class AffinityGroupDAO{
    
    //Stores the connection that all methods will user for executing their queries 
    private $conn;
    private $logger;
    
    /*
     * Non-default constructor that sets the connection field that all methods will use to execute their queries
     */
    public function __construct(PDO $connection, ILoggerService $logger){
        $this->conn = $connection;
        $this->logger = $logger;
    }
    
    /*
     * Method for creating a new affinity group
     */
    public function create(AffinityGroupModel $group){
        
        $this->logger->info("Entering AffinityGroupDAO.create()");
        
        //Gets information from the affinity group model
        $name = $group->getName();
        $description = $group->getDescription();
        $focus = $group->getFocus();
        $userID = $group->getUserID();
        
        try{
            $statement = $this->conn->prepare("INSERT INTO AFFINITYGROUPS (IDAFFINITYGROUPS, NAME, DESCRIPTION, FOCUS, USERS_IDUSERS) VALUES (NULL, :name, :description, :focus, :userID)");
            //Binds the information from the model to the sql statement
            $statement->bindParam(':name', $name);
            $statement->bindParam(':description', $description);
            $statement->bindParam('focus', $focus);
            $statement->bindParam('userID', $userID);
            $statement->execute();
        } catch (\PDOException $e){
            $this->logger->error("Exception: ", ['message' => $e->getMessage()]);
            throw new DatabaseException("Database Exception: " . $e->getMessage(), 0, $e);
        }
        
        $this->logger->info("Exiting AffinityGroupDAO.create()");
        
        //Returns the result of the query as well as the insert id
        return ['result' => $statement->rowCount(), 'insertID' => $this->conn->lastInsertID()];
    }
    
    /*
     * Method gets an affinity group from it's id
     */
    public function getByID(int $id){
        
        $this->logger->info("Entering AffinityGroupDAO.getByID()");
        
        try{
            $statement = $this->conn->prepare("SELECT * FROM AFFINITYGROUPS WHERE IDAFFINITYGROUPS = :id");
            //Binds the id to the sql query
            $statement->bindParam(':id', $id);
            $statement->execute();
        } catch (\PDOException $e){
            $this->logger->error("Exception: ", ['message' => $e->getMessage()]);
            throw new DatabaseException("Database Exception: " . $e->getMessage(), 0, $e);
        }
        
        $this->logger->info("Exiting AffinityGroupDAO.getByID()");

        return ['group' =>$statement->fetch(PDO::FETCH_ASSOC)];
    }
    
    /*
     * Gets all the affinity groups from the database and returns them in an array
     */
    public function getAll(){
        
        $this->logger->info("Entering AffinityGroupDAO.getAll()");
        
        try{
            $statement = $this->conn->prepare("SELECT * FROM AFFINITYGROUPS");
            $statement->execute();
        } catch (\PDOException $e){
            $this->logger->error("Exception: ", ['message' => $e->getMessage()]);
            throw new DatabaseException("Database Exception: " . $e->getMessage(), 0, $e);
        }
        
        $groups = [];
        
        //Adds all of the groups retrieved from the database to an array for return
        while($group = $statement->fetch(PDO::FETCH_ASSOC)){
            array_push($groups, $group);
        }
        
        $this->logger->info("Exiting AffinityGroupDAO.getAll()");
        
        return $groups;
    }
    
    /*
     * Gets all of the affinity groups that a user owns
     */
    public function getOwned($userID){
        
        $this->logger->info("Entering AffinityGroupDAO.getOwned()");
        
        try{
            $statement = $this->conn->prepare("SELECT * FROM AFFINITYGROUPS WHERE USERS_IDUSERS = :userID");
            //Binds the user's ID to the sql statement
            $statement->bindParam(':userID', $userID);
            $statement->execute();
        } catch (\PDOException $e){
            $this->logger->error("Exception: ", ['message' => $e->getMessage()]);
            throw new DatabaseException("Database Exception: " . $e->getMessage(), 0, $e);
        }
        
        $groups = [];
        
        //Adds all of the owned affinity groups to an array for return
        while($group = $statement->fetch(PDO::FETCH_ASSOC)){
            array_push($groups, $group);
        }
        
        $this->logger->info("Exiting AffinityGroupDAO.getOwned()");
        
        return $groups;
    }
    
    /*
     * Edits an existing affinity group
     */
    public function edit(AffinityGroupModel $group){
        
        $this->logger->info("Entering AffinityGroupDAO.edit()");
        
        try{
            //Gets all of the necessary information from the model
            $id = $group->getId();
            $name = $group->getName();
            $description = $group->getDescription();
            $focus = $group->getFocus();
            
            $statement = $this->conn->prepare("UPDATE AFFINITYGROUPS SET NAME = :name, DESCRIPTION = :description, FOCUS = :focus WHERE IDAFFINITYGROUPS = :id");
            //Binds the information from the model to the sql statement
            $statement->bindParam(':name', $name);
            $statement->bindParam(':description', $description);
            $statement->bindParam(':focus', $focus);
            $statement->bindParam(':id', $id);
            $statement->execute();
        } catch (\PDOException $e){
            $this->logger->error("Exception: ", ['message' => $e->getMessage()]);
            throw new DatabaseException("Database Exception: " . $e->getMessage(), 0, $e);
        }
        
        $this->logger->info("Exiting AffinityGroupDAO.edit()");
        
        return $statement->rowCount();
    }
    
    /*
     * Deletes an affinity group from the database
     */
    public function delete(int $id){
        
        $this->logger->info("Entering AffinityGroupDAO.delete()");
        
        try{
            $statement = $this->conn->prepare("DELETE FROM AFFINITYGROUPS WHERE IDAFFINITYGROUPS = :id");
            //Binds the affinity group's id to the sql statement
            $statement->bindParam(':id', $id);
            $statement->execute();
        } catch (\PDOException $e){
            $this->logger->error("Exception: ", ['message' => $e->getMessage()]);
            throw new DatabaseException("Database Exception: " . $e->getMessage(), 0, $e);
        }
        
        $this->logger->info("Exiting AffinityGroupDAO.delete()");
        
        return $statement->rowCount();
    }
}