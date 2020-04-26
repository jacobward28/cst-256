<?php


namespace App\Services\Data;

use App\Models\SkillModel;
use App\Services\Utility\ILoggerService;
use PDO;
use App\Services\Utility\DatabaseException;

class SkillDAO{
    
    //Field to store the PDO connection to the database
    private $connection;
    private $logger;
    
    //Sets the connection field
    public function __construct(\PDO $connection, ILoggerService $logger){
        $this->connection = $connection;
        $this->logger = $logger;
    }
    
    //Gets all of the skills connected to a certain user
    public function findByID(int $id){
        
        $this->logger->info("Entering SkillDAO.findByID()");
        
        try{
            $statement = $this->connection->prepare("SELECT * FROM SKILLS WHERE USERS_IDUSERS = :userID");
            $statement->bindParam('userID', $id);
            $statement->execute();
            
            $results = [];
            
            //Adds all of the results from the database query to the results array
            while($result = $statement->fetch(PDO::FETCH_ASSOC)){
                array_push($results, $result);
            }
            
        } catch(\PDOException $e){
            $this->logger->error("Exception: ", ['message' => $e->getMessage()]);
            throw new DatabaseException("Database Exception: " . $e->getMessage(), 0, $e);
        }
        
        $this->logger->info("Exiting SkillDAO.findByID()");
        
        return ['result' => $statement->rowCount(), 'skills' => $results];
    }
    
    //Takes a skill model as an argument and creates a new skill entry in the database
    public function create(SkillModel $skill){
        
        $this->logger->info("Entering SkillDAO.create()");
        
        try{
            //Gets the information needed from the skill object
            $skillName = $skill->getSkill();
            $description = $skill->getDescription();
            $userID = $skill->getUserID();
            
            $statement = $this->connection->prepare("INSERT INTO SKILLS (IDSKILLS, SKILL, DESCRIPTION, USERS_IDUSERS) VALUES (NULL, :skill, :description, :userID)");
            $statement->bindParam(':skill', $skillName);
            $statement->bindParam(':description', $description);
            $statement->bindParam(':userID', $userID);
            $statement->execute();
        } catch(\PDOException $e){
            $this->logger->error("Exception: ", ['message' => $e->getMessage()]);
            throw new DatabaseException("Database Exception: " . $e->getMessage(), 0, $e);
        }
        
        $this->logger->info("Exiting SkillDAO.create()");
        
        return $statement->rowCount();
    }
    
    //Takes in the ID of the skill and then removes the associated skill from the database
    public function remove($id){
        
        $this->logger->info("Entering SkillDAO.remove()");
        
        try{
            
            $statement = $this->connection->prepare("DELETE FROM SKILLS WHERE IDSKILLS = :id");
            $statement->bindParam(':id', $id);
            $statement->execute();
        } catch (\PDOException $e){
            $this->logger->error("Exception: ", ['message' => $e->getMessage()]);
            throw new DatabaseException("Database Exception: " . $e->getMessage(), 0, $e);
        }
        
        $this->logger->info("Exiting SkillDAO.remove()");
        
        return $statement->rowCount();
    }
}