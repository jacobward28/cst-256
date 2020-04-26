<?php


namespace App\Services\Business;

use App\Services\Utility\ILoggerService;
use App\Services\Utility\Connection;
use App\Services\Data\JobListingDAO;

class JobListingService {

    /**
     * Gets all of the jobs that a user has applied to
     * @param int $userID The ID of the user to get the applied jobs from
     * @return array An array containing all of the jobs a user has applied to
     * @throws \App\Services\Utility\DatabaseException
     */
    public function getAllJobs(ILoggerService $logger){
        
        $logger->info("Entering JobApplicantService.getAllJobs()");
        
        //Creates a connection to the database
        $connection = new Connection();
        
        //Creates an instance of the DAO 
        $DAO = new JobListingDAO($connection, $logger);
        
        //Stores results from the DAO function call
        $results = $DAO->getAllJobs();
        
        //Closes connection to the database
        $connection = null;
        
        $logger->info("Exiting JobApplicantService.getAllJobs()");
        
        return $results;
    }
}