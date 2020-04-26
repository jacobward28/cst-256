<?php


namespace App\Http\Controllers;

use App\Services\Utility\ILoggerService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;
use App\Models\JobModel;
use App\Services\Business\JobService;
use App\Services\Business\JobApplicantService;

class JobController extends Controller
{

    /**
     * Handles the user's viewing of a job
     * @param Request $request
     * @param ILoggerService $logger
     * @return \Illuminate\View\View|\Illuminate\Contracts\View\Factory
     */
    public function index(Request $request, ILoggerService $logger){
        try{
            $logger->info("Entering JobController.index()");
            
            $jobID = $request->input('jobID');
            
            $jobService = new JobService();
            
            $result = $jobService->getJob($jobID, $logger)['job'];
            $applied = false;
            
            if(Session::has('ID')){
                $applicantService = new JobApplicantService();
                $applicants = $applicantService->getAllApplicants($jobID, $logger);
                
                foreach($applicants as $applicant){
                    if($applicant['USERS_IDUSERS'] == Session::get('ID')){
                        $applied = true;
                    }
                }
            }
            
            $data = ['job' => $result, 'applied' => $applied];
            
            $logger->info("Exiting JobController.index()");
            
            return view('viewJob')->with($data);
        } catch (\Exception $e){
            $logger->error("Exception occurred in JobController.inswz(): " . $e->getMessage());
            $data = ['error_message' => $e->getMessage()];
            return view('error')->with($data);
        }
    }

    public function createJob(Request $request, ILoggerService $logger)
    {
        $logger->info("Entering JobController.createJob()");
        
        // Validates the user's input against pre-defined rules
        $this->validateForm($request);
        
        try {

            // Takes user input from register form and uses it to make a new jobmodel object with an id of 0
            $job = new JobModel(0, $request->input('title'), $request->input('company'), $request->input('state'), $request->input('city'), $request->input('description'));

            // Creates instance of job service
            $jobService = new JobService();

            // Stores the result of the function call
            $result = $jobService->newJob($job, $logger);
            
            $logger->info("Exiting JobController.createJob() with a result of ", $result);

            //Returns the user to the job admin page
            return view('jobAdmin')->with(['results' => $jobService->getAllJobs($logger)]);
        } catch (\Exception $e) {
            $logger->error("Exception occured in JobController.createJob(): " . $e->getMessage());
            $data = ['error_message' => $e->getMessage()];
            return view('error')->with($data);
        }
    }

    // Contains the rules for validating the job creation
    private function validateForm(Request $request)
    {
        $rules = [
            'title' => 'Required | Between:4,20 | unique:mysql.JOBS,TITLE',
            'company' => 'Required | Between:1,45',
            'state' => 'Required | Between:1,20',
            'city' => 'Required | Between:1,20',
            'description' => 'Required | Between:1,65535'
        ];
        
        $this->validate($request, $rules);
    }
    
    public function apply(Request $request, ILoggerService $logger){
        
        $logger->info("Entering JobController.apply()");
        
        try{
            
            $userID = $request->input('userID');
            $jobID = $request->input('jobID');
            
            $applicantService = new JobApplicantService();
            
            $result = $applicantService->apply($jobID, $userID, $logger);
            
            $logger->info("Exiting JobController.apply()", [$result]);
            
            $data = [];
            
            $data['message'] = $result ? "You successfully applied for the job" : "Something went wrong with your application";
            $data['messageType'] = $result ? "success" : "danger";
            
            return view('home')->with($data);
        } catch (\Exception $e){
            $logger->error("Exception occured in JobController.apply(): " . $e->getMessage());
            $data = ['error_message' => $e->getMessage()];
            return view('error')->with($data);
        }
    }
    
    public function cancelApplication(Request $request, ILoggerService $logger){
        
        $logger->info("Entering JobController.cancelApplication()");
        
        try{
            
            $userID = $request->input('userID');
            $jobID = $request->input('jobID');
            
            $applicantService = new JobApplicantService();
            
            $result = $applicantService->cancelApplication($jobID, $userID, $logger);
            
            $logger->info("Exiting JobController.cancelApplication()", [$result]);
            
            $data = [];
            
            $data['message'] = $result ? "Your application was canceled successfully" : "Something went wrong with the cancelation process";
            $data['messageType'] = $result ? "success" : "danger";
            
            return view('home')->with($data);
        } catch (\Exception $e){
            $logger->error("Exception occured in JobController.cancelApplication(): " . $e->getMessage());
            $data = ['error_message' => $e->getMessage()];
            return view('error')->with($data);
        }
    }
}


