<?php

namespace App\Http\Controllers;

use App\Models\DTO;
use App\Services\Utility\ILoggerService;
use App\Services\Utility\ViewData;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use App\Services\Business\UserService;

class UserProfileRestController extends Controller
{
    /**
     * Display all the users
     *
     * @return Response
     */
    public function index(ILoggerService $logger)
    {
       try
       {
            $logger->info("Entering UserProfileRestController.index()");
            $service = new UserService();
            $users = $service->getAllUsers($logger);

            $dto = new DTO(0, "OK", $users);
           
            $logger->info("Exiting UserProfileRestController.index()");
            return json_encode($dto);
       }
       catch(Exception $e1)
        {
            // Return an eror back to the user in the DTO
            $dto = new DTO(- 2, $e1->getMessage(), "");
            return json_encode($dto);
        }
    }

    
    
    /**
     * Display a user by id
     *
     * @param  int  $id
     * @return Response
     */
    public function show($id, ILoggerService $logger)
    {
        try
        {
            $logger->info("Entering UserProfileRestController.show()", []);
            $service = new UserService();
            $result = $service->findByID($id, $logger);
           
            //Create DTO
            if($result == null)
            {
                $logger->info("User is null", []);
                $dto = new DTO(01, "User not found", "");
            }
            else 
            {
                
                $logger->info("User is not null", []);
                $dto = new DTO(0, "OK", $result);
            }
            $json = json_encode($dto);
            $logger->info("Exiting UserProfileRestController.show()", []);
            return $json;
            

        } 
        catch (Exception $e)
        {
            $logger->error("Exception: ", array("message" => $e->getMessage()));
            // Return an eror back to the user in the DTO
            $dto = new DTO(- 2, $e1->getMessage(), "");
            return json_encode($dto);
        }
    }
}
