<?php

namespace App\Http\Controllers;

use App\Services\Utility\ILoggerService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;
use Illuminate\Validation\Rule;
use App\Services\Utility\ViewData;
use App\Models\AffinityGroupModel;
use App\Services\Business\AffinityGroupService;

class AffinityGroupController extends Controller
{
    
    /*
     * Returns the group view with the affinity group data for the user trying to view the page
     */
    public function index(Request $request, ILoggerService $logger){
        
        $logger->info("Entering AffinityGroupController.index()");
        
        try{
            //Gets the user's id from the request
            $userID = $request->input('ID');
            
            $logger->info("Exiting AffinityGroupController.index()");
            
            //Returns the groups view with the data for the user retrieved from the view data method
            return view('groups')->with(ViewData::getAffinityData($userID, $logger));
        } catch (\Exception $e){
            $logger->error("Exception occured in AffinityGroupController.index(): " . $e->getMessage());
            $data = ['error_message' => $e->getMessage()];
            return view('error')->with($data);
        }
    }
    
    /*
     * Handles a request for a user to make a new method
     */
    public function newGroup(Request $request, ILoggerService $logger){
        
        $logger->info("Entering AffinityGroupController.newGroup()");
        
        //Validates user input
        $this->validateGroupInput($request);
        
        try{
            //Creates a affinity group model using the user's input
            $group = new AffinityGroupModel(-1, $request->input('name'), $request->input('description'), $request->input('focus'), $request->input('ID'));
            
            //Creates an instance of a service
            $service = new AffinityGroupService();
            
            //Stores the results of the service method call
            $results = $service->createGroup($group, $logger);
            
            $logger->info("Exiting AffinityGroupController.newGroup() with a result of " . $results);
            
            //Returns the groups view the proper viewdata for the user
            return view('groups')->with(ViewData::getAffinityData($group->getUserID(), $logger));
        } catch (\Exception $e){
            $logger->error("Exception occured in AffinityGroupController.newGroup(): " . $e->getMessage());
            $data = ['error_message' => $e->getMessage()];
            return view('error')->with($data);
        }
    }
    
    /*
     * Handles a user request to edit an affinity group
     */
    public function editGroup(Request $request, ILoggerService $logger){

        $logger->info("Entering AffinityGroupController.editGroup()");

        //Validates the user's input against pre-defined rules
        try {
            $this->validateGroupEditInput($request);
        } catch (\Exception $e){
            return view('groups')->with(ViewData::getAffinityData($request->session()->get('ID'), $logger))->withErrors($e->getMessage());
        }

        try{
            //Creates an affinity group model using the information from the request
            $group = new AffinityGroupModel($request->input('ID'), $request->input('name'), $request->input('description'), $request->input('focus'), 0);
            
            //Creates of the appropriate service
            $service = new AffinityGroupService();
            
            //Stores the results of the service method call
            $results = $service->editGroup($group, $logger);
            
            $logger->info("Exiting AffinityGroupController.editGroup() with a result of " . $results);
            
            //Returns the affinity groups view with the viewdata for the user
            return view('groups')->with(ViewData::getAffinityData($request->session()->get('ID'), $logger));
        } catch (\Exception $e){
            $logger->error("Exception occured in AffinityGroupController.newGroup(): " . $e->getMessage());
            $data = ['error_message' => $e->getMessage()];
            return view('error')->with($data);
        }
    }
    
    private function validateGroupInput(Request $request){
        $rules = [
            'name' => ['Required', 'Between:3,45', Rule::unique('AFFINITYGROUPS', 'NAME')->where(function ($query){
            return $query->where('USERS_IDUSERS', Session::get('ID'));
            })],
            'description' => 'Required | Between:1,65535',
            'focus' => 'Required'
        ];
        
        $this->validate($request, $rules);
    }
    
    private function validateGroupEditInput(Request $request){
        $rules = [
            'name' => 'Required | Between:3,45',
            'description' => 'Required | Between:1,65535',
            'focus' => 'Required'
        ];
        
        $this->validate($request, $rules);
    }
    
    /*
     * Handles a user request to delete an afinity group
     */
    public function deleteGroup(Request $request, ILoggerService $logger){
        
        $logger->info("Entering AffinityGroupController.deleteGroup()");
        
        try{
            //Get the group id from the request
            $id = $request->input('groupID');
            
            //Create an instance of the affinity group service
            $service = new AffinityGroupService();
            
            //Stores the results of the service method call
            $results = $service->deleteGroup($id, $logger);
            
            $logger->info("Exiting AffinityGroupController.deleteGroup() with a result of " . $results);
            
            //Returns the affinity group view with the viewdata for the user
            return view('groups')->with(ViewData::getAffinityData($request->session()->get('ID'), $logger));
        } catch (\Exception $e){
            $logger->error("Exception occured in AffinityGroupController.newGroup(): " . $e->getMessage());
            $data = ['error_message' => $e->getMessage()];
            return view('error')->with($data);
        }
    }
}
