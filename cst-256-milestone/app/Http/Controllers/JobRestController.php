<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Exception;
use App\Services\Utility\ILoggerService;
use App\Services\Utility\MyLogger;
use App\Services\Business\JobService;
use App\Models\DTO;

class JobRestController extends Controller
{
    /**
     * Get all the Jobs
     *
     * @return \Illuminate\Http\Response
     */
    public function index(ILoggerService $logger)
    {
        //
        try
        {
            $logger->info("Entering JobRestController.index()");
            //Call Service to get all users
            $service = new JobService();
            $jobs = $service->getAllJobs($logger);
            // Create a DTO
            $dto = new DTO(0, "OK", $jobs);

            // Serialize the DTO to JSON
            $json = json_encode($dto);

            // Return JSON back to caller
            return $json;
            
            $logger->info("Exiting JobRestController.index()");
        }
        catch(Exception $e1)
        {
            $logger->error("Exception: ", array("message" => $e1->getMessage()));
            
            $dto = new DTO(-9, $e1->getMessage(), "");
            return json_encode($dto);
        }
        
        
    }

    

    /**
     * Get the Job By Id
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id, ILoggerService $logger)
    {
        //
        try{
            $logger->info("Entering JobRestController.show()");
            $service = new JobService();
            $job = $service->getJob($id, $logger);
            
            //Create DTO
            if($job == null)
            {
                $dto = new DTO(01,"Job Not Found", "");
            }
            else
            {
                $dto = new DTO(0, "OK", $job);
            }
            
            //Seriallze the DTO to Json
            $json = json_encode($dto);
            
            //Return json
            return $json;
            $logger->info("Exiting JobRestController.show()");
        }
        catch(Exception $e1)
        {
            $logger->error("Exception: ", array("message" => $e1->getMessage()));
            
            $dto = new DTO(-9, $e1->getMessage(), "");
            return json_encode($dto);
        }
    }

   
}
