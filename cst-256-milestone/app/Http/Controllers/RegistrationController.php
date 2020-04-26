<?php


namespace App\Http\Controllers;

use App\Services\Utility\ILoggerService;
use Illuminate\Http\Request;
use App\Models\UserModel;
use App\Services\Business\SecurityService;

class RegistrationController extends Controller
{

    // Function recives user registration input, uses it to create a user object and then uses that object
    // to attempt to create a new database entry
    public function index(Request $request, ILoggerService $logger)
    {

        // Validates the user's input against pre-defined rules
        $this->validateForm($request);
        
        try {

            // Takes user input from register form and uses it to make a new usermodel object with an id of 0
            $user = new UserModel(0, $request->input('username'), $request->input('password'), $request->input('email'), $request->input('firstname'), $request->input('lastname'), 1, 0);

            // Creates instance of security service
            $securityService = new SecurityService();

            // Stores the result of the attempted registration
            $result = $securityService->register($user, $logger);

            // Stores the result of the attempted registration
            $data = [
                'result' => $result
            ];

            return view('registrationResult')->with($data);
        } catch (\Exception $e) {
            $logger->error("Exception occurred in RegistrationController.index(): " . $e->getMessage());
            $data = ['error_message' => $e->getMessage()];
            return view('error')->with($data);
        }
    }

    // Contains the rules for validating the user's registration information
    private function validateForm(Request $request)
    {
        $rules = [
            'username' => 'Required | Between:4,10 | Alpha | unique:mysql.USERS,USERNAME',
            'password' => 'Required | Between:4,10',
            'email' => 'Required | email',
            'firstname' => 'Required | Between:3,15 | Alpha',
            'lastname' => 'Required | Between:3,15 | Alpha'
        ];
        
        $this->validate($request, $rules);
    }
}
