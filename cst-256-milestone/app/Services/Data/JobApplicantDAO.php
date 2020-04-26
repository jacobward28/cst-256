<?php

namespace App\Services\Data;

use App\Services\Utility\ILoggerService;
use App\Services\Utility\DatabaseException;
use PDO;

class JobApplicantDAO{
    
    //Field that stores the database connection used by all the functions in the class
    private $conn;
    private $logger;
    
    //Non-default constructor that takes a PDO connection as an argument
    public function __construct(PDO $connection, ILoggerService $logger){
        $this->conn = $connection;
        $this->logger = $logger;
    }
    
    /**
     * Gets all of the jobs a user has applied to from the database
     * @param int $userID The user ID of user whose applied jobs the function should get
     * @throws DatabaseException
     * @return array An array of IDs of all the jobs that the user has applied to
     */
    public function getAllJobs(int $userID){
        
        $this->logger->info("Entering JobApplicantDAO.getAllJobs()", [$userID]);
        
        try{
            $statement = $this->conn->prepare("SELECT * FROM JOBAPPLICANTS WHERE USERS_IDUSERS = :id");
            $statement->bindParam(':id', $userID);
            $statement->execute();
        } catch (\PDOException $e){
            $this->logger->error("Exception: ", ['message' => $e->getMessage()]);
            throw new DatabaseException("Database Exception: " . $e->getMessage(), 0, $e);
        }
        
        //Array to store all the jobs returned from the database
        $jobs = [];
        
        //Iterates over all results returned and adds them to the jobs array
        while($job = $statement->fetch(PDO::FETCH_ASSOC)){
            array_push($jobs, $job);
        }
        
        $this->logger->info("Exiting JobApplicantDAO.getAllJobs()");
        
        return $jobs;
    }
    
    
    /**
     * Gets all of the users that have applied to a specific job
     * @param int $jobID The ID of the job to get all the applicants of
     * @throws DatabaseException
     * @return array An array containing the user IDs of all the applicants to the job
     */
    public function getAllApplicants(int $jobID){
        
        $this->logger->info("Entering JobApplicantDAO.getAllApplicants()", [$jobID]);
        
        try{
            $statement = $this->conn->prepare("SELECT * FROM JOBAPPLICANTS WHERE JOBS_IDJOBS = :id");
            $statement->bindParam(':id', $jobID);
            $statement->execute();
        } catch (\PDOException $e){
            $this->logger->error("Exception: ", ['message' => $e->getMessage()]);
            throw new DatabaseException("Database Exception: " . $e->getMessage(), 0, $e);
        }
        
        //An array for holding all of the users returned from the database query
        $users = [];
        
        //Iterates over all of the results returned from the query and adds them to the array
        while($user = $statement->fetch(PDO::FETCH_ASSOC)){
            array_push($users, $user);
        }
        
        $this->logger->info("Exiting JobApplicantDAO.getAllApplicants()");
        
        return $users;
    }
    
    /**
     * Allows for a user to apply to a specific job
     * @param int $jobID ID of the job the user is applying for
     * @param int $userID ID of the user applying for the job
     * @return boolean This boolean denotes whether or not the user successfully applied for the job
     * @throws DatabaseException
     */
    public function create(int $jobID, int $userID){
        
        $this->logger->info("Entering JobApplicantDAO.create()");
        
        try{
            $statement = $this->conn->prepare("INSERT INTO JOBAPPLICANTS (JOBS_IDJOBS, USERS_IDUSERS) VALUES (:jobID, :userID)");
            //Binds the user and job IDs to the statement
            $statement->bindParam(':jobID', $jobID);
            $statement->bindParam(':userID', $userID);
            $statement->execute();
        } catch (\PDOException $e){
            $this->logger->error("Exception: ", ['message' => $e->getMessage()]);
            throw new DatabaseException("Database Exception: " . $e->getMessage(), 0, $e);
        }
        
        $this->logger->info("Exiting JobApplicantDAO.create()");
        
        return $statement->rowCount();
    }
    
    /**
     * Allows for a user to cancel their application to a job
     * @param int $jobID ID of the job that the user wants to cancel their application to
     * @param int $userID ID of the user that wants to cancel their job application
     * @throws DatabaseException
     * @return boolean This boolean denotes whether or not the user successfully canceled their job application
     */
    public function delete(int $jobID, int $userID){
        
        $this->logger->info("Entering JobApplicantDAO.delete()");
        
        try{
            $statement = $this->conn->prepare("DELETE FROM JOBAPPLICANTS WHERE JOBS_IDJOBS = :jobID AND USERS_IDUSERS = :userID");
            //Binds the user ID and the job ID to the statement
            $statement->bindParam(':jobID', $jobID);
            $statement->bindParam(':userID', $userID);
            $statement->execute();
        } catch (\PDOException $e){
            $this->logger->error("Exception: ", ['message' => $e->getMessage()]);
            throw new DatabaseException("Database Exception: " . $e->getMessage(), 0, $e);
        }
        
        $this->logger->info("Exiting JobApplicantDAO.delete()");
        
        return $statement->rowCount();
    }
}
