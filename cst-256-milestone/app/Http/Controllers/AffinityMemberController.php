<?php

namespace App\Http\Controllers;

use App\Services\Utility\ILoggerService;
use Illuminate\Http\Request;
use App\Services\Business\AffinityMemberService;
use App\Services\Utility\ViewData;

class AffinityMemberController extends Controller
{
    /*
     * Method for handling a user request to join a group
     */
    public function joinGroup(Request $request, ILoggerService $logger){
        
        $logger->info("Entering AffinityMemberController.joinGroup()");
        
        try{
            //Gets the IDs from the request
            $userID = $request->input('userID');
            $groupID = $request->input('groupID');
            
            //Creates an instance of the service
            $service = new AffinityMemberService();
            
            //Stores the result of the service method call
            $results = $service->joinGroup($userID, $groupID, $logger);
            
            $logger->info("Exiting AffinityMemberController.joinGroup() with a result of " . $results);
            
            //Retuns the affinity group view along with the data returned from the view data method
            return view('groups')->with(ViewData::getAffinityData($userID, $logger));
        } catch (\Exception $e){
            $logger->error("Exception occured in AffinityMemberController.joinGroup(): " . $e->getMessage());
            $data = ['error_message' => $e->getMessage()];
            return view('error')->with($data);
        }
    }
    
    /*
     * Method for handling a user request to leave a group
     */
    public function leaveGroup(Request $request, ILoggerService $logger){
        
        $logger->info("Entering AffinityMemberController.leaveGroup()");
        
        try{
            //Gets the IDs from the request
            $userID = $request->input('userID');
            $groupID = $request->input('groupID');
            
            //Creates an instance of the service
            $service = new AffinityMemberService();
            
            //Stores the result of the service method call
            $results = $service->leaveGroup($userID, $groupID, $logger);
            
            $logger->info("Exiting AffinityMemberController.leaveGroup() with a result of " . $results);
            
            //Returns the affinity group view along with the data returned from the view data method
            return view('groups')->with(ViewData::getAffinityData($userID, $logger));
        } catch(\Exception $e){
            $logger->error("Exception occured in AffinityMemberController.leaveGroup(): " . $e->getMessage());
            $data = ['error_message' => $e->getMessage()];
            return view('error')->with($data);
        }
    }
}
