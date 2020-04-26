<?php

namespace App\Http\Controllers;

use App\Services\Utility\ILoggerService;
use Illuminate\Http\Request;
use App\Services\Business\JobService;
use App\Models\JobModel;

class JobAdminController extends Controller
{

    // Method gets the all the job data in the database and returns it to the admin page so administrators can manage jobs
    public function index(ILoggerService $logger)
    {
        try {
            $logger->info("Entering JobAdminController.index()");

            // Creates new instance of the appropriate service
            $service = new JobService();

            // Stores the results of the respective data access object's query
            $results = $service->getAllJobs($logger);

            // Stores the results in an associative array to be passed on to the admin view
            $data = [
                'results' => $results
            ];

            $logger->info("Exiting JobAdminController.index()");

            return view('jobAdmin')->with($data);
        } catch (\Exception $e) {
            $logger->error("Exception occurred in JobAdminController.index(): " . $e->getMessage());
            $data = ['error_message' => $e->getMessage()];
            return view('error')->with($data);
        }
    }

    // Method takes form input from the previous form and attempts to update the database entry for the corresponding job
    public function editJob(Request $request, ILoggerService $logger)
    {
        $logger->info("Entering JobAdminController.editJob()");

        // Validates form input against pre-defined rules
        $this->validateEdit($request);
        
        try {

            // Creates a new job Model using the information gotten from the form input
            $job = new JobModel($request->input('id'), $request->input('title'), $request->input('company'), $request->input('state'), $request->input('city'), $request->input('description'));

            // Creates a new instance of the appropriate business service
            $service = new JobService();

            // Stores the results of the appropriate query
            $results = $service->editJob($job, $logger);

            $logger->info("Exiting JobAdminController.editJob()");

            if ($results) {
                return view('jobAdmin')->with(['results' => $service->getAllJobs($logger)]);
            }
        } catch (\Exception $e) {
            $logger->error("Exception occurred in JobAdminController.editJob(): " . $e->getMessage());
            $data = ['error_message' => $e->getMessage()];
            return view('error')->with($data);
        }
    }
    // Contains the rules for validating form input for editing jobs
    private function validateEdit(Request $request)
    {
        $rules = [
            'title' => 'Required | Between:1,20',
            'company' => 'Required | Between:1,45',
            'state' => 'Required | Between:1,20',
            'city' => 'Required | Between:1,20',
            'description' => 'Required | Between:1,45'
        ];

        $this->validate($request, $rules);
    }


    // Method takes an ID from the form that submitted the request and attempts to delete the job of the corresponding ID
    public function removeJob(Request $request, ILoggerService $logger)
    {
        try {
            $logger->info("Entering JobAdminController.removeJob()");

            // Get's the job's ID from the previous form
            $id = $request->input('id');

            // Creates an instance of the appropriate business service
            $service = new JobService();

            // Stores the result of the attempted removal of the job
            $results = $service->removeJob($id, $logger);

            $logger->info("Exiting JobAdminController.removeJob()");

            if ($results) {
                return view('jobAdmin')->with(['results' => $service->getAllJobs($logger)]);
            }
        } catch (\Exception $e) {
            $logger->error("Exception occurred in JobAdminController.removeJob(): " . $e->getMessage());
            $data = ['error_message' => $e->getMessage()];
            return view('error')->with($data);
        }
    }
}
