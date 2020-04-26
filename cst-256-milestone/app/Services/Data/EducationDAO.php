<?php


namespace App\Services\Data;

use App\Services\Utility\ILoggerService;
use PDO;
use App\Services\Utility\DatabaseException;
use App\Models\EducationModel;

class EducationDAO{
    
    //Stores the database connection used by all of the functions in this class
    private $conn;
    private $logger;
    
    //Takes in a connection object and assigns it to the connection field
    public function __construct(\PDO $connection, ILoggerService $logger){
        $this->conn = $connection;
        $this->logger = $logger;
    }
    
    //Gets all of the education records associated with the user id passed as an argument
    public function getByID(int $id){
        $this->logger->info("Entering EducationDAO.getByID()");
        
        try{
            $statement = $this->conn->prepare("SELECT * FROM EDUCATION WHERE USERS_IDUSERS = :id");
            $statement->bindParam(':id', $id);
            $statement->execute();
        } catch (\PDOException $e){
            $this->logger->error("Exception: ", ["message" => $e->getMessage()]);
            throw new DatabaseException("Database Exception: " . $e->getMessage(), 0, $e);
        }
        
        $educations = [];
        
        //Iterates over all the results of the query and adds them to a temporary array
        while($education = $statement->fetch(PDO::FETCH_ASSOC)){
            array_push($educations, $education);
        }
        
        $this->logger->info("Exit EducationDAO.getByID()");
        
        //Returns the result of the query as well as all the database entries gotten from the query
        return ['result' => $statement->rowCount(), 'education' => $educations];
    }
    
    //Gets all of the education records from the database
    public function getAll(){
        $this->logger->info("Entering EducationDAO.getAll()");
        
        try{
            $statement = $this->conn->prepare("SELECT * FROM EDUCATION");
            $statement->execute();
        } catch (\PDOException $e){
            $this->logger->error("Exception: ", ["message" => $e->getMessage()]);
            throw new DatabaseException("Database Exception: " . $e->getMessage(), 0, $e);
        }
        
        $educations = [];
        
        //Iterates over all of the results obtained from the query and adds them to an array
        while($education = $statement->fetch(PDO::FETCH_ASSOC)){
            array_push($educations, $education);
        }
        
        $this->logger->info("Exit EducationDAO.getAll()");
        
        //Returns the array of education records gotten back from the database query
        return $educations;
    }
    
    //Takes in an education model and attempts to create a new database entry with the information contained
    public function create(EducationModel $education){
        
        $this->logger->info("Entering EducationDAO.create()");
        
        //Gets all of the information from the education model
        $school = $education->getSchool();
        $degree = $education->getDegree();
        $field = $education->getField();
        $gpa = $education->getGpa();
        $startyear = $education->getStartyear();
        $endyear = $education->getEndyear();
        $userID = $education->getUserID();
        
        try{
            $statement = $this->conn->prepare("INSERT INTO EDUCATION (IDEDUCATION, SCHOOL, DEGREE, FIELD, GPA, STARTYEAR, ENDYEAR, USERS_IDUSERS) VALUE (NULL, :school, :degree, :field, :gpa, :startyear, :endyear, :userID)");
            //Binds information from the education model to the database query
            $statement->bindParam(':school', $school);
            $statement->bindParam(':degree', $degree);
            $statement->bindParam(':field', $field);
            $statement->bindParam(':gpa', $gpa);
            $statement->bindParam(':startyear', $startyear);
            $statement->bindParam(':endyear', $endyear);
            $statement->bindParam(':userID', $userID);
            $statement->execute();
        } catch (\PDOException $e){
            $this->logger->error("Exception: ", ['message', $e->getMessage()]);
            throw new DatabaseException("Database Exception: " . $e->getMessage(), 0, $e);
        }
        
        $this->logger->info("Exiting EducationDAO.create()");
        
        //Returns the results of the database query
        return $statement->rowCount();
    }
    
    //Takes in an education model and attempts to update the associated database entry with the information contained in the model
    public function update(EducationModel $education){
        
        $this->logger->info("Entering EducationDAO.update()");
        
        //Gets the information from the education model
        $id = $education->getId();
        $school = $education->getSchool();
        $degree = $education->getDegree();
        $field = $education->getField();
        $gpa = $education->getGpa();
        $startyear = $education->getStartyear();
        $endyear = $education->getEndyear();
        
        try{
            $statement = $this->conn->prepare("UPDATE EDUCATION SET SCHOOL = :school, DEGREE = :degree, FIELD = :field, GPA = :gpa, STARTYEAR = :startyear, ENDYEAR = :endyear WHERE IDEDUCATION = :id");
            //Binds the information from the model to the database query
            $statement->bindParam(':id', $id);
            $statement->bindParam(':school', $school);
            $statement->bindParam(':degree', $degree);
            $statement->bindParam(':field', $field);
            $statement->bindParam(':gpa', $gpa);
            $statement->bindParam(':startyear', $startyear);
            $statement->bindParam(':endyear', $endyear);
            $statement->execute();
        } catch (\PDOException $e){
            $this->logger->error("Exception: ", ['message', $e->getMessage()]);
            throw new DatabaseException("Database Exception: " . $e->getMessage(), 0, $e);
        }
        
        $this->logger->info("Exiting EducationDAO.update()");
        
        //Returns the result of the query
        return $statement->rowCount();
    }
    
    //Takes in an education id and attempts to remove the associated database entry
    public function remove(int $id){
        
        $this->logger->info("Entering EducationDAO.remove()");
        
        try{
            $statement = $this->conn->prepare("DELETE FROM EDUCATION WHERE IDEDUCATION = :id");
            $statement->bindParam(':id', $id);
            $statement->execute();
        } catch (\PDOException $e){
            $this->logger->error("Exception: ", ['message', $e->getMessage()]);
            throw new DatabaseException("Database Exception: ".$e->getMessage(), 0, $e);
        }
        
        $this->logger->info("Exiting EducationDAO.remove()");
        
        //Returns the results of the database query
        return $statement->rowCount();
    }
}