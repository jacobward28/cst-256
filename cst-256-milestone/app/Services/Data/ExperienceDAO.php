<?php


namespace App\Services\Data;

use App\Services\Utility\ILoggerService;
use PDO;
use App\Services\Utility\DatabaseException;
use App\Models\ExperienceModel;

class ExperienceDAO{
    
    //Stores the database connection used by all the functions in the class
    private $conn;
    private $logger;
    
    //Sets the connection
    public function __construct(PDO $connection, ILoggerService $logger){
        $this->conn = $connection;
        $this->logger = $logger;
    }
    
    //Get's all of the experience entries associated with a certain user
    public function getByID(int $id){
        $this->logger->info("Entering ExperienceDAO.getByID()");
        
        try{
            $statement = $this->conn->prepare("SELECT * FROM EXPERIENCE WHERE USERS_IDUSERS = :id");
            $statement->bindParam(':id', $id);
            $statement->execute();
        } catch (\PDOException $e){
            $this->logger->error("Exception: ", ["message" => $e->getMessage()]);
            throw new DatabaseException("Database Exception: " . $e->getMessage(), 0, $e);
        }
        
        //Temporary array to store all the results from the query
        $results = [];
        
        //Iterates over all of the results retrieved from the database query and adds them to the temporary array  
        while($result = $statement->fetch(PDO::FETCH_ASSOC)){
            array_push($results, $result);
        }
        
        $this->logger->info("Exit ExperienceDAO.getByID()");
        
        //Returns the result of the query as well as the array with all the results
        return ['result' => $statement->rowCount(), 'experience' => $results];
    }
    
    //Gets all of the experience entries from the database
    public function getAll(){
        $this->logger->info("Entering ExperienceDAO.getAll()");
        
        try{
            $statement = $this->conn->prepare("SELECT * FROM EXPERIENCE");
            $statement->execute();
        } catch (\PDOException $e){
            $this->logger->error("Exception: ", ["message" => $e->getMessage()]);
            throw new DatabaseException("Database Exception: " . $e->getMessage(), 0, $e);
        }
        
        //Temporary array to store all of the experiences retrieved from the database
        $results = [];
        
        //Iterates over all of the results returned from the query and adds it to the array
        while($result = $statement->fetch(PDO::FETCH_ASSOC)){
            array_push($results, $result);
        }
        
        $this->logger->info("Exit ExperienceDAO.getAll()");

        //Returns the array full of results
        return $results;
    }
    
    //Takes in an experience model and attempts to make a new database entry with the information contained within the experience model
    public function create(ExperienceModel $experience){
        
        $this->logger->info("Entering ExperienceDAO.create()");
        
        //Gets all of the information from the experience model
        $title = $experience->getTitle();
        $company = $experience->getCompany();
        $current = $experience->getCurrent();
        $startyear = $experience->getStartyear();
        $endyear = $experience->getEndyear();
        $description = $experience->getDescription();
        $userID = $experience->getUserID();
        
        try{
            $statement = $this->conn->prepare("INSERT INTO EXPERIENCE (IDEXPERIENCE, TITLE, COMPANY, CURRENT, STARTYEAR, ENDYEAR, DESCRIPTION, USERS_IDUSERS) VALUES (NULL, :title, :company, :current, :startyear, :endyear, :description, :userID)");
            //Binds all of the information from the experience model to the query
            $statement->bindParam(':title', $title);
            $statement->bindParam(':company', $company);
            $statement->bindParam(':current', $current);
            $statement->bindParam(':startyear', $startyear);
            $statement->bindParam(':endyear', $endyear);
            $statement->bindParam(':description', $description);
            $statement->bindParam(':userID', $userID);
            $statement->execute();
        } catch (\PDOException $e){
            $this->logger->error("Exception: ", ['message', $e->getMessage()]);
            throw new DatabaseException("Database Exception: " . $e->getMessage(), 0, $e);
        }
        
        $this->logger->info("Exiting ExperienceDAO.create()");
        
        //Returns the result of the query
        return $statement->rowCount();
    }
    
    //Takes in an experience model and attempts to update the database entry with the information in the model
    public function update(ExperienceModel $experience){
        
        $this->logger->info("Entering ExperienceDAO.update()");
        
        //Gets all of the information from the model
        $id = $experience->getId();
        $title = $experience->getTitle();
        $company = $experience->getCompany();
        $current = $experience->getCurrent();
        $startyear = $experience->getStartyear();
        $endyear = $experience->getEndyear();
        $description = $experience->getDescription();
        
        try{
            $statement = $this->conn->prepare("UPDATE EXPERIENCE SET TITLE = :title, COMPANY = :company, CURRENT = :current, STARTYEAR = :startyear, ENDYEAR = :endyear, DESCRIPTION = :description WHERE IDEXPERIENCE = :id");
            //Binds all of the information from the model to the query
            $statement->bindParam(':id', $id);
            $statement->bindParam(':title', $title);
            $statement->bindParam(':company', $company);
            $statement->bindParam(':current', $current);
            $statement->bindParam(':startyear', $startyear);
            $statement->bindParam(':endyear', $endyear);
            $statement->bindParam(':description', $description);
            $statement->execute();
        } catch (\PDOException $e){
            $this->logger->error("Exception: ", ['message', $e->getMessage()]);
            throw new DatabaseException("Database Exception: " . $e->getMessage(), 0, $e);
        }
        
        $this->logger->info("Exiting ExperienceDAO.update()");
        
        //Returns the result of the query
        return $statement->rowCount();
    }
    
    //Takes in the id of an experience entry and attempts to remove it from the database
    public function remove(int $id){
        
        $this->logger->info("Entering ExperienceDAO.remove()");
        
        try{
            $statement = $this->conn->prepare("DELETE FROM EXPERIENCE WHERE IDEXPERIENCE = :id");
            $statement->bindParam(':id', $id);
            $statement->execute();
        } catch (\PDOException $e){
            $this->logger->error("Exception: ", ['message', $e->getMessage()]);
            throw new DatabaseException("Database Exception: ".$e->getMessage(), 0, $e);
        }
        
        $this->logger->info("Exiting ExperienceDAO.remove()");
        
        //Returns the result of the query
        return $statement->rowCount();
    }
}