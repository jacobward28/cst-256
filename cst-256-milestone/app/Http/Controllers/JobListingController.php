<?php

namespace App\Http\Controllers;

use App\Services\Utility\ILoggerService;
use App\Services\Business\JobListingService;

class JobListingController extends Controller
{

    // Method gets the all the job data in the database and returns it to the admin page so administrators can manage jobs
    public function index(ILoggerService $logger)
    {
        try {
            $logger->info("Entering JobAdminController.index()");

            // Creates new instance of the appropriate service
            $service = new JobListingService();

            // Stores the results of the respective data access object's query
            $results = $service->getAllJobs($logger);

            // Stores the results in an associative array to be passed on to the admin view
            $data = [
                'results' => $results
            ];

            $logger->info("Exiting JobAdminController.index()");

            return view('jobHome')->with($data);
        } catch (\Exception $e) {
            $logger->error("Exception occurred in JobAdminController.index(): " . $e->getMessage());
            $data = ['error_message' => $e->getMessage()];
            return view('error')->with($data);
        }
    }

   
}
