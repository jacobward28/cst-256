<?php

namespace App\Services\Business;

use App\Services\Utility\Connection;
use App\Services\Utility\ILoggerService;
use App\Services\Data\JobApplicantDAO;

class JobApplicantService {

    /**
     * Gets all of the jobs that a user has applied to
     * @param int $userID The ID of the user to get the applied jobs from
     * @return array An array containing all of the jobs a user has applied to
     * @throws \App\Services\Utility\DatabaseException
     */
    public function getAllJobs($userID, ILoggerService $logger){
        
        $logger->info("Entering JobApplicantService.getAllJobs()", [$userID]);
        
        //Creates a connection to the database
        $connection = new Connection();
        
        //Creates an instance of the DAO 
        $DAO = new JobApplicantDAO($connection, $logger);
        
        //Stores results from the DAO function call
        $results = $DAO->getAllJobs($userID);
        
        //Closes connection to the database
        $connection = null;
        
        $logger->info("Exiting JobApplicantService.getAllJobs()");
        
        return $results;
    }
    
    public function getAllApplicants($jobID, ILoggerService $logger){
        
        $logger->info("Entering JobApplicantService.getAllApplicants()", [$jobID]);
        
        //Creates a connection to the database
        $connection = new Connection();
        
        //Creates an instance of the DAO
        $DAO = new JobApplicantDAO($connection, $logger);
        
        //Stores the results from the DAO function call
        $results = $DAO->getAllApplicants($jobID);
        
        //Closes the connection to the database
        $connection = null;
        
        $logger->info("Exiting JobApplicantService.getAllApplicants()");
        
        return $results;
    }

    /**
     * Allows the user to apply to a job
     * @param int $jobID The ID of the job the user is applying to
     * @param int $userID The ID of the user that is applying for a job
     * @return boolean The result of the user's attempt to apply to the job
     * @throws \App\Services\Utility\DatabaseException
     */
    public function apply($jobID, $userID, ILoggerService $logger){
        
        $logger->info("Entering JobApplicantService.apply()", ['jobID' => $jobID, 'userID' => $userID]);
        
        //Creates a connection to the database
        $connection = new Connection();
        
        //Creates an instance of the DAO
        $DAO = new JobApplicantDAO($connection, $logger);
        
        //Stores the results of the DAO function call
        $results = $DAO->create($jobID, $userID);
        
        //Closes the connection to the database
        $connection = null;
        
        $logger->info("Exiting JobApplicantService.apply()", [$results]);
        
        return $results;
    }

    /**
     * Allows the user to delete the application they've submitted to a job
     * @param int $jobID The ID of the job the user applied to
     * @param int $userID The ID of the user whose application should be removed
     * @return boolean The result of the attempted removal
     * @throws \App\Services\Utility\DatabaseException
     */
    public function cancelApplication($jobID, $userID, ILoggerService $logger){
        
        $logger->info("Entering JobApplicantService.cancelApplication()", ['jobID' => $jobID, 'userID' => $userID]);
        
        //Creates a connection to the database
        $connection = new Connection();
        
        //Creates an instance of the DAO
        $DAO = new JobApplicantDAO($connection, $logger);
        
        //Stores the results of the DAO function call
        $results = $DAO->delete($jobID, $userID);
        
        //Closes the connection to the database
        $connection = null;
        
        $logger->info("Exiting JobApplicantService.cancelApplication()", [$results]);
        
        return $results;
    }
}