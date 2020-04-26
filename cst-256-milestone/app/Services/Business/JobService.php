<?php


namespace App\Services\Business;

use App\Models\JobModel;
use App\Services\Utility\Connection;
use App\Services\Utility\DatabaseException;
use App\Services\Utility\ILoggerService;
use App\Services\Data\JobDAO;

class JobService
{

    /**
     * @param JobModel $job
     * @param ILoggerService $logger
     * @return array
     * @throws DatabaseException
     */
    public function newJob(JobModel $job, ILoggerService $logger)
    {
        $logger->info("Entering JobService.newJob()", []);

        //Creates connection with the database
        $connection = new Connection();

        //Creates data access object instance
        $DAO = new JobDAO($connection, $logger);

        //Stores the results of the data access object's new job method
        $result = $DAO->create($job);

        //Closes the connection to the database
        $connection = null;

        $logger->info("Exiting JobService.newJob() with result: ", [$result['result']]);

        return $result;
    }

    /**
     * Gets a specific job based off its ID
     * @param int $id The ID of the job to be retrieved
     * @return array Associative array representing the job returned from the database
     * @throws DatabaseException
     */
    public function getJob($id, ILoggerService $logger){
        
        $logger->info("Entering JobService.getJob()", []);
        
        //Creates connection with the database
        $connection = new Connection();
        
        //Creates an instance of the appropriate DAO
        $DAO = new JobDAO($connection, $logger);
        
        //Stores the results of the dao method
        $results = $DAO->getByID($id);
        
        //Closes the connection to the database
        $connection = null;
        
        $logger->info("Exiting JobService.getJob()", []);
        
        return $results;
    }

    /**
     * Gets all of the jobs form the database
     * @return array An array containing all the jobs in the database
     * @throws DatabaseException
     */
    public function getAllJobs(ILoggerService $logger){
        
        $logger->info("Entering JobService.getAllUsers()", []);
        
        //Creates connection with the database
        $connection = new Connection();
        
        //Creates data access object instance
        $DAO = new JobDAO($connection, $logger);
        
        //Stores the results of the data access object's get all method.
        $results = $DAO->getAll();
        
        //Closes the connection to the databse
        $connection = null;
        
        $logger->info("Exiting JobService.getAllUsers()", []);
        
        //Returns the results obtained from the data access object
        return $results;
    }
    
    public function editJob(JobModel $job, ILoggerService $logger){
        
        $logger->info("Entering JobService.editJob", []);
        
        //Creates connection with the database
        $connection = new Connection();
        
        //Creates data access object instance
        $DAO = new JobDAO($connection, $logger);
        
        //Stores the results of the data access object's function call
        $results = $DAO->update($job);
        
        //Closes the connection to the database
        $connection = null;
        
        $logger->info("Exiting JobService.editJob()", []);
        
        //Returns the results obtained from the data access object
        return $results;
    }

    /**
     * Removes a job posting from the database
     * @param int $id The ID of the job to be removed from the database
     * @return boolean The result of whether or not the job was removed from the database
     * @throws DatabaseException
     */
    public function removeJob($id, ILoggerService $logger){
        
        $logger->info("Entering JobService.removeJob()", []);
        
        //Creates connection with the database
        $connection = new Connection();
        
        //Creates data access object instance
        $DAO = new JobDAO($connection, $logger);
        
        //Stores the results of the data access object's function call
        $results = $DAO->remove($id);
        
        //Closes the connection to the database
        $connection = null;
        
        $logger->info("Exiting UserService.removeUser()", []);
        
        //Returns the results obtained from the data access object
        return $results;
    }

  }