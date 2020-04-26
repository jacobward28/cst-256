<?php

namespace App\Services\Data;

use App\Services\Utility\ILoggerService;
use PDO;
use App\Services\Utility\DatabaseException;

class AffinityMemberDAO{
    
    //Connection user for all queries
    private $conn;
    private $logger;
    
    /*
     * Non-default constructor that sets the connection field
     */
    public function __construct(PDO $connection, ILoggerService $logger){
        $this->conn = $connection;
        $this->logger = $logger;
    }
    
    /*
     * Method gets the id of all the groups a user is a member of 
     */
    public function getAllGroups(int $id){
        
        $this->logger->info("Entering AffinityMemberDAO.getAllGroups()");
        
        try{
            $statement = $this->conn->prepare("SELECT AFFINITYGROUPS_IDAFFINITYGROUPS FROM AFFINITYGROUPMEMBER WHERE USERS_IDUSERS = :id");
            $statement->bindParam(':id', $id);
            $statement->execute();
        } catch (\PDOException $e){
            $this->logger->error("Exception: ", ['message' => $e->getMessage()]);
            throw new DatabaseException("Database Exception: " . $e->getMessage(), 0, $e);
        }
        
        $groups = [];
        
        //Adds all results to the groups array
        while($group = $statement->fetch(PDO::FETCH_ASSOC)){
            array_push($groups, $group);
        }
        
        $this->logger->info("Exiting AffinityMemberDAO.getAllGroups()");
        
        return $groups;
    }
    
    /*
     * Method gets the id of all the members of a particular group
     */
    public function getAllMembers(int $id){
        
        $this->logger->info("Entering AffinityMemberDAO.getAllMembers()");
        
        try{
            $statement = $this->conn->prepare("SELECT USERS_IDUSERS FROM AFFINITYGROUPMEMBER WHERE AFFINITYGROUPS_IDAFFINITYGROUPS = :id");
            $statement->bindParam(':id', $id);
            $statement->execute();
        } catch (\PDOException $e){
            $this->logger->error("Exception: ", ['message' => $e->getMessage()]);
            throw new DatabaseException("Database Exception: " . $e->getMessage(), 0, $e);
        }
        
        $members = [];
        
        //Adds all of the results from the query to the members array ot be returned to the service
        while($member = $statement->fetch(PDO::FETCH_ASSOC)){
            array_push($members, $member);
        }
        
        $this->logger->info("Exiting AffinityMemberDAO.getAllMembers()");
        
        return $members;
    }
    
    /*
     * Creates a new entry meaning that a user has joined an affinity group
     */
    public function create(int $groupID, int $userID){
        
        $this->logger->info("Entering AffinityMemberDAO.create()");
        
        try{
            $statement = $this->conn->prepare("INSERT INTO AFFINITYGROUPMEMBER (AFFINITYGROUPS_IDAFFINITYGROUPS, USERS_IDUSERS) VALUES (:groupID, :userID)");
            $statement->bindParam(':groupID', $groupID);
            $statement->bindParam(':userID', $userID);
            $statement->execute();
        } catch (\PDOException $e){
            $this->logger->error("Exception: ", ['message' => $e->getMessage()]);
            throw new DatabaseException("Database Exception: " . $e->getMessage(), 0, $e);
        }
        
        $this->logger->info("Exiting AffinityMemberDAO.create()");
        
        return $statement->rowCount();
    }
    
    /*
     * Removes an entry from the table meaning that a particular user has left a particular affinity group
     */
    public function delete(int $groupID, int $userID){
        
        $this->logger->info("Entering AffinityMemberDAO.delete()");
        
        try{
            $statement = $this->conn->prepare("DELETE FROM AFFINITYGROUPMEMBER WHERE USERS_IDUSERS = :userID AND AFFINITYGROUPS_IDAFFINITYGROUPS = :groupID");
            $statement->bindParam(':userID', $userID);
            $statement->bindParam(':groupID', $groupID);
            $statement->execute();
        } catch (\PDOException $e){
            $this->logger->error("Exception: ", ['message' => $e->getMessage()]);
            throw new DatabaseException("Database Exception: " . $e->getMessage(), 0, $e);
        }
        
        $this->logger->info("Exiting AffinityMemberDAO.delete()");
        
        return $statement->rowCount();
    }
}