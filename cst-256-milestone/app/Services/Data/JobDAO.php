<?php /** @noinspection SqlDialectInspection */


namespace App\Services\Data;

use App\Models\JobModel;
use App\Services\Utility\DatabaseException;
use App\Services\Utility\ILoggerService;
use PDO;
use PDOException;

class JobDAO{
    
    //Stores the connection that functions will use to access the database
    private $conn;
    private $logger;
    
    //Takes in a PDO connection and sets the conn field equal to it
    public function __construct(PDO $conn, ILoggerService $logger){
        $this->conn = $conn;
        $this->logger = $logger;
    }

    /**
     * Gets a job based off the ID passed to the function
     * @param int $id The ID of the job to be retrieved from the database
     * @return array An associative array containing all of the values from the job retrieved
     * @throws DatabaseException
     */
    public function getByID($id){
        $this->logger->info("Entering JobDAO.getByID()", []);
        
        try{
            $statement = $this->conn->prepare("SELECT * FROM JOBS WHERE IDJOBS = :id");
            $statement->bindParam(':id', $id);
            $statement->execute();
        } catch (PDOException $e){
            $this->logger->error("Exception: ", ["message" => $e->getMessage()]);
            throw new DatabaseException("Database Exception: " . $e->getMessage(), 0, $e);
        }
        
        $this->logger->info("Exit JobDAO.getByID()", []);

        //TODO:: return results in assoc array
        return ['job' => $statement->fetch(PDO::FETCH_ASSOC)];
    }

    /**
     * Gets a job based off the ID passed to the function, this function is used for the rest api
     * @param int $id The ID of the job to be retrieved from the database
     * @return array An associative array containing all of the values from the job retrieved
     * @throws DatabaseException
     */
    public function getJobByID($id){
        $this->logger->info("Entering JobDAO.getByID()", []);
        
        try{
            $statement = $this->conn->prepare("SELECT * FROM JOBS WHERE IDJOBS = :id");
            $statement->bindParam(':id', $id);
            $statement->execute();
        } catch (PDOException $e){
            $this->logger->error("Exception: ", ["message" => $e->getMessage()]);
            throw new DatabaseException("Database Exception: " . $e->getMessage(), 0, $e);
        }
        if($statement->rowCount() == 0)
        {
            $this->logger->info("Exit JobDAO.getByID() with 0");
            return null;
        }
        else
        {
            $row = $statement->fetch(PDO::FETCH_ASSOC);
            $job = new JobModel($row["IDJOBS"], $row["TITLE"], $row["COMPANY"],$row['STATE'], $row['CITY'], $row['DESCRIPTION']);
            $this->logger->info("Exit JobDAO.getByID()", []);
        }
        

        //TODO:: return results in assoc array
        return $job;
    }

    /**
     * This is a function to get all the jobs, this is for the rest api
     * @return array
     * @throws DatabaseException
     */
    public function getAllJobs(){
        $this->logger->info("Entering JobDAO.getAll()", []);
        
        try{
            $statement = $this->conn->prepare("SELECT * FROM JOBS");
            $statement->execute();
        } catch (PDOException $e){
            $this->logger->error("Exception: ", ["message" => $e->getMessage()]);
            throw new DatabaseException("Database Exception: " . $e->getMessage(), 0, $e);
        }
        
        $this->logger->info($statement->rowCount());
        if($statement->rowCount() == 0)
        {
            return array();
        }
        else
        {
            $index = 0;
            $jobs = array();
            while($row = $statement->fetch(PDO::FETCH_ASSOC))
            {
                $job = new JobModel($row["IDJOBS"], $row["TITLE"], $row["COMPANY"],$row['STATE'], $row['CITY'], $row['DESCRIPTION']);
                $jobs[$index++] = $job;
            }
        }
        $this->logger->info("Exit UserDAO.getAll()");
        
        //Returns the completed users array containing all of the user associative arrays
        return $jobs;
    }

    /**
     * @return array
     * @throws DatabaseException
     */
    public function getAll(){
        $this->logger->info("Entering JobDAO.getAll()", []);
        
        try{
            $statement = $this->conn->prepare("SELECT * FROM JOBS");
            $statement->execute();
        } catch (PDOException $e){
            $this->logger->error("Exception: ", ["message" => $e->getMessage()]);
            throw new DatabaseException("Database Exception: " . $e->getMessage(), 0, $e);
        }
        
        //Temporary array to hold all job data
        $jobs = [];
        
        //Iterates over each job gotten back from the database query
        while($job = $statement->fetch(PDO::FETCH_ASSOC)){
            //Adds the associative array representing the currently iterated job to the jobs array
            array_push($jobs, $job);
        }
        
        $this->logger->info("Exit JobDAO.getAll()", []);
        
        //Returns the completed jobs array containing all of the job associative arrays
        return $jobs;
    }


    /**
     * @param $id
     * @return array
     * @throws DatabaseException
     */
    public function findByID($id){
        $this->logger->info("Entering JobDAO.findByID()", []);
        
        try{
            $statement = $this->conn->prepare("SELECT * FROM JOBS WHERE IDJOBS = :id");
            $statement->bindParam(':id', $id);
            $statement->execute();
        } catch (PDOException $e){
            $this->logger->error("Exception: ", ['message' => $e->getMessage()]);
            throw new DatabaseException("Database Exception: " . $e->getMessage(), 0, $e);
        }
        
        $this->logger->info("Exiting JobDAO.findByID()", []);
        //Returns whether or not the query found anything and the user in the event that it did
        return ['result' => $statement->rowCount(), 'job' => $statement->fetch(PDO::FETCH_ASSOC)];
    }

    /**
     * Gets all of the jobs with titles linked to the search string
     * @param string $title The search string that will be used for the query
     * @return array An array of all the jobs that are linked to the search string
     * @throws DatabaseException
     */
    public function findByTitle($title){
        
        $this->logger->info("Entering JobDAO.findByName()", [$title]);
        
        try{
            $statement = $this->conn->prepare("SELECT * FROM JOBS WHERE TITLE LIKE :search");
            $statement->bindParam(':search', $title);
            $statement->execute();
        } catch (PDOException $e){
            $this->logger->error("Exception: ", ['message' => $e->getMessage()]);
            throw new DatabaseException("Database Exception: " . $e->getMessage(), 0, $e);
        }
        
        $jobs = [];
        
        while($job = $statement->fetch(PDO::FETCH_ASSOC)){
            array_push($jobs, $job);
        }
        
        $this->logger->info("Exiting JobDAO.findByTitle()", []);
        
        return $jobs;
    }
    
    /**
     * Gets all of the jobs with descriptions linked to the search string
     * @param string $description The search string that will be used for the query
     * @throws DatabaseException
     * @return array An array of all the jobs that are linked to the search string
     */
    public function findByDescription($description){
        
        $this->logger->info("Entering JobDAO.findByDescription()", [$description]);
        
        try{
            $statement = $this->conn->prepare("SELECT * FROM JOBS WHERE DESCRIPTION LIKE :search");
            $statement->bindParam(':search', $description);
            $statement->execute();
        } catch (PDOException $e){
            $this->logger->error("Exception: ", ['message' => $e->getMessage()]);
            throw new DatabaseException("Database Exception: " . $e->getMessage(), 0, $e);
        }
        
        $jobs = [];
        
        while($job = $statement->fetch(PDO::FETCH_ASSOC)){
            array_push($jobs, $job);
        }
        
        $this->logger->info("Exiting JobDAO.findByDescription()", []);
        
        return $jobs;
    }

    /**
     * @param JobModel $job
     * @return array
     * @throws DatabaseException
     */
    public function create(JobModel $job){
        $this->logger->info("Entering JobDAO.newJob()", []);
        
        try{
            //Gets all of the information from the jobModel passed as an argument
            $title = $job->getTitle();
            $company = $job->getCompany();
            $state = $job->getState();
            $city = $job->getCity();
            $description = $job->getDescription();
            
            //Statement to create new entry in the users table with passed information and a NULL primary key and default values for the role and status
            $statement = $this->conn->prepare("INSERT INTO `JOBS` (`IDJOBS`, `TITLE`, `COMPANY`, `STATE`, `CITY`, `DESCRIPTION`) VALUES (NULL, :title, :company, :state, :city, :description)");
            //Binds all of the usermodel information to their respective tokens
            $statement->bindParam(':title', $title);
            $statement->bindParam(':company', $company);
            $statement->bindParam(':state', $state);
            $statement->bindParam(':city', $city);
            $statement->bindParam(':description', $description);
            $statement->execute();
        } catch (PDOException $e){
            $this->logger->error("Exception: ", array("message" => $e->getMessage()));
            throw new DatabaseException("Database Exception: " . $e->getMessage(), 0, $e);
        }
        
        $this->logger->info("Exit JobDAO.newJob()", []);
        //Returns the result of the database query as well as the ID of the created user
        return ['result' => $statement->rowCount(), 'insertID' => $this->conn->lastInsertID()];
    }

    /**
     * @param JobModel $job
     * @return int
     * @throws DatabaseException
     */
    public function update(JobModel $job){
        $this->logger->info("Entering JobDAO.update()", []);
        
        try{
            //Gets all of the information from the jobModel
            $id = $job->getId();
            $title = $job->getTitle();
            $company = $job->getCompany();
            $state = $job->getState();
            $city = $job->getCity();
            $description = $job->getDescription();
           
            
            $statement = $this->conn->prepare("UPDATE `JOBS` SET `TITLE` = :title, `COMPANY` = :company, `STATE` = :state, `CITY` = :city, `DESCRIPTION` = :description WHERE `IDJOBS` = :id");
            //Binds all of the information from the jobModel to their respective query tokens
            $statement->bindParam(':title', $title);
            $statement->bindParam(':company', $company);
            $statement->bindParam(':state', $state);
            $statement->bindParam(':city', $city);
            $statement->bindParam(':description', $description);
            
            $statement->bindParam(':id', $id);
            $statement->execute();
        } catch (PDOException $e){
            $this->logger->error("Exception: ", ["message" => $e->getMessage()]);
            throw new DatabaseException("Database Exception: " . $e->getMessage(), 0, $e);
        }
        
        $this->logger->info("Exit JobDAO.update()", []);
        //Returns the result of the query
        return $statement->rowCount();
    }

    /**
     * @param $id
     * @return int
     * @throws DatabaseException
     */
    public function remove($id){
        $this->logger->info("Entering JobDAO.remove()", []);
        
        try{            
            $statement = $this->conn->prepare("DELETE FROM `JOBS` WHERE `IDJOBS` = :id");
            //Binds the ID passed as an argument to the query
            $statement->bindParam(':id', $id);
            $statement->execute();
        } catch (PDOException $e){
            $this->logger->error("Exception: ", ["message" => $e->getMessage()]);
            throw new DatabaseException("Database Exception: " . $e->getMessage(), 0, $e);
        }
        
        $this->logger->info("Exit JobDAO.remove()", []);
        //Returns the result of the query
        return $statement->rowCount();
    }
}