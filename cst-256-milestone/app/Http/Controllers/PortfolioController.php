<?php


namespace App\Http\Controllers;

use App\Services\Utility\ILoggerService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;
use Illuminate\Validation\Rule;
use App\Services\Business\EducationService;
use App\Models\EducationModel;
use App\Services\Business\ExperienceService;
use App\Models\ExperienceModel;
use App\Services\Business\SkillService;
use App\Models\SkillModel;
use App\Services\Utility\ViewData;

class PortfolioController extends Controller
{
    public function removeEducation(Request $request, ILoggerService $logger){
        
        $logger->info("Entering UserEditController.removeEducation()");
        
        try{
            $id = $request->input('ID');
            
            //Creates instance of the appropriate service
            $service = new EducationService();
            
            //Calls associated function and stores the results of the function call
            $results = $service->remove($id, $logger);
            
            $logger->info("Exiting UserEditController.removeEducation() with a result of " . $results);
            
            //Redirects the user back to their profile page
            return view('userProfile')->with(ViewData::getProfileData($request->session()->get('ID'), $logger));
        } catch (\Exception $e){
            $logger->error("Exception occured in UserEditController.removeEducation(): " . $e->getMessage());
            $data = ['error_message' => $e->getMessage()];
            return view('error')->with($data);
        }
    }
    
    public function addEducation(Request $request, ILoggerService $logger){
        $logger->info("Entering UserEditController.addEducation()");
        
        //Validates form input against pre-defined rules
        $this->validateEducationInput($request);
        
        try{
            //Creates an education model based on the information submitted to the form
            $education = new EducationModel(-1, $request->input('school'), $request->input('degree'), $request->input('field'), $request->input('gpa'), $request->input('startyear'), $request->input('endyear'), $request->input('userID'));
            
            //Creates instance of the appropriate service
            $service = new EducationService();
            
            //Calls associated function and stores the results of the function call
            $results = $service->create($education, $logger);
            
            $logger->info("Exiting UserEditController.addEducation() with a result of " . $results);
            
            //Redirects the user back to their profile page
            return view('userProfile')->with(ViewData::getProfileData($request->session()->get('ID'), $logger));
        } catch (\Exception $e){
            $logger->error("Exception occurred in UserEditController.editEducation(): " . $e->getMessage());
            $data = ['error_message' => $e->getMessage()];
            return view('error')->with($data);
        }
    }
    
    public function editEducation(Request $request, ILoggerService $logger){
        $logger->info("Entering UserEditController.editEducation()");
        
        //Validates the form input against pre-defined rules
        $this->validateEducationInput($request);
        
        try{
            //Creates an education model based on the information submitted to the form
            $education = new EducationModel($request->input('id'), $request->input('school'), $request->input('degree'), $request->input('field'), $request->input('gpa'), $request->input('startyear'), $request->input('endyear'), -1);
            
            //Creates instance of the appropriate service
            $service = new EducationService();
            
            //Calls associated function and stores the result of the function call
            $results = $service->update($education, $logger);
            
            $logger->info("Exiting UserEditController.editEducation() with a result of " . $results);
            
            //Redirects the user back to their profile page
            return view('userProfile')->with(ViewData::getProfileData($request->session()->get('ID'), $logger));
        } catch (\Exception $e){
            $logger->error("Exception occurred in UserEditController.editEducation(): " . $e->getMessage());
            $data = ['error_message' => $e->getMessage()];
            return view('error')->with($data);
        }
    }
    
    private function validateEducationInput(Request $request){
        $rules = [
            'school' => 'Required | Between:4,50',
            'degree' => 'Required | Between:4,45',
            'field' => 'Required | Between:4,45',
            //'gpa' => 'Required | Numeric | Digits_between:2,4',
            'startyear' => 'Required | Numeric | Digits:4',
            'endyear' => 'Required | Numeric | Digits:4'
        ];
        
        $this->validate($request, $rules);
    }
    
    public function removeExperience(Request $request, ILoggerService $logger){
        
        $logger->info("Entering UserEditController.removeExperience()");
        
        try{
            $id = $request->input('ID');
            
            //Creates an instance of the appropriate service
            $service = new ExperienceService();
            
            //Calls the associated function and stores the results of the function call
            $results = $service->remove($id, $logger);
            
            $logger->info("Exiting UserEditController.removeExperience() with a result of " . $results);
            
            //Redirects the user back to their profile page
            return view('userProfile')->with(ViewData::getProfileData($request->session()->get('ID'), $logger));
        } catch (\Exception $e){
            $logger->error("Exception occured in UserEditController.removeExperience(): " . $e->getMessage());
            $data = ['error_message' => $e->getMessage()];
            return view('error')->with($data);
        }
    }
    
    public function addExperience(Request $request, ILoggerService $logger){
        
        $logger->info("Entering UserEditController.addExperience()");
        
        //Validates form input against pre-defined rules
        $this->validateExperienceInput($request);
        
        try{
            //Takes input from the form and creates a new experience model object from it
            $experience = new ExperienceModel(-1, $request->input('title'), $request->input('company'), $request->input('current'), $request->input('startyear'), $request->input('endyear'), $request->input('description'), $request->input('userID'));
            
            //Creates an instance of the appropriate service
            $service = new ExperienceService();
            
            //Calls the associated function and stores the results of the function call
            $results = $service->create($experience, $logger);
            
            $logger->info("Exiting UserEditController.addExperience() with a result of " . $results);
            
            //Redirect the user back to their profile page
            return view('userProfile')->with(ViewData::getProfileData($request->session()->get('ID'), $logger));
        } catch (\Exception $e){
            $logger->error("Exception occured in UserEditController.addExperience(): " . $e->getMessage());
            $data = ['error_message' => $e->getMessage()];
            return view('error')->with($data);
        }
    }
    
    public function editExperience (Request $request, ILoggerService $logger){
        
        $logger->info("Entering UserEditController.editExperience()");
        
        //Validates the form input against pre-defined rules
        $this->validateExperienceInput($request);
        
        try{
            //Takes input from the form and uses it to create a new experience model object
            $experience = new ExperienceModel($request->input('id'), $request->input('title'), $request->input('company'), $request->input('current'), $request->input('startyear'), $request->input('endyear'), $request->input('description'), -1);
            
            //Creates instance of the appropriate service
            $service = new ExperienceService();
            
            //Calls teh associated function and stores the results of the function call
            $results = $service->update($experience, $logger);
            
            $logger->info("Exiting UserEditController.editExperience() with a result of ", [$results]);
            
            //Redirect the user back to their profile page
            return view('userProfile')->with(ViewData::getProfileData($request->session()->get('ID'), $logger));
        } catch (\Exception $e){
            $logger->error("Exception occured in UserEditController.addExperience(): " . $e->getMessage());
            $data = ['error_message' => $e->getMessage()];
            return view('error')->with($data);
        }
    }
    
    private function validateExperienceInput(Request $request){
        $rules = [
            'title' => 'Required | Between:4,45',
            'company' => 'Required | Between:4,45',
            'current' => 'Required | Numeric | Digits:1',
            'startyear' => 'Required | Numeric | Digits:4',
            'endyear' => $request->input('endyear') != null ? 'Numeric | Digits:4' : '',
            'description' => $request->input('description') != null ? 'Between:1,65535' : ''
        ];
        
        $this->validate($request, $rules);
    }
    
    public function addSkill(Request $request, ILoggerService $logger){
        
        $logger->info("Entering UserEditController.addSkill()");
        
        //Validates the form input against pre-defined rules
        $this->validateSkillInput($request);
        
        try{
            //Takes form input and uses it to create a new skill model object
            $skill = new SkillModel(-1, $request->input('skill'), $request->input('description'), $request->input('userID'));
            
            //Creates an instance of the appropriate service
            $service = new SkillService();
            
            //Calls the associated function and stores the results of the function call
            $results = $service->create($skill, $logger);
            
            $logger->info("Exiting UserEditController.addSkill() with a result of ", [$results]);
            
            //Redirects the user back to their profile page
            return view('userProfile')->with(ViewData::getProfileData($request->session()->get('ID'), $logger));
        } catch (\Exception $e){
            $logger->error("Exception occured in UserEditController.addSkill(): " . $e->getMessage());
            $data = ['error_message' => $e->getMessage()];
            return view('error')->with($data);
        }
    }
    
    private function validateSkillInput(Request $request){
        $rules = [
            'skill' => ['Required', 'Between:2,45', Rule::unique('SKILLS', 'SKILL')->where(function ($query){
            return $query->where('USERS_IDUSERS', Session::get('ID'));
            })],
            'description' => 'Required | Between:4,65535'
        ];
        
        $this->validate($request, $rules);
    }
    
    public function removeSkill(Request $request, ILoggerService $logger){
        
        $logger->info("Entering UserEditController.removeSkill()");
        
        try{
            $id = $request->input('ID');
            
            //Creates an instance of the appropriate service
            $service = new SkillService();
            
            //Calls the associated function and stores the results of the function call
            $results = $service->remove($id, $logger);
            
            $logger->info("Exiting UserEditController.removeSkill() with a result of ", [$results]);
            
            //Redirects the user back to their profile page
            return view('userProfile')->with(ViewData::getProfileData($request->session()->get('ID'), $logger));
        } catch (\Exception $e){
            $logger->error("Exception occured in UserEditController.removeSkill(): " . $e->getMessage());
            $data = ['error_message' => $e->getMessage()];
            return view('error')->with($data);
        }
    }
}
