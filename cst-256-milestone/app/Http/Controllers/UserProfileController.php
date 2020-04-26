<?php


namespace App\Http\Controllers;

use App\Services\Utility\ILoggerService;
use Illuminate\Http\Request;
use App\Services\Utility\ViewData;

class UserProfileController extends Controller
{

    // Takes the request that contains the ID for the user's profile that it's suposed to display
    public function index(Request $request, ILoggerService $logger)
    {
        try {
            $logger->info("Entering UserProfileController.index()");

            // Gets the user ID from the previous form
            $userID = $request->input('ID');

            $logger->info("Exiting UserProfileController.index()");
        
            return view('userProfile')->with(ViewData::getProfileData($userID, $logger));
        } catch (\Exception $e){
            $logger->error("Exception occurred in UserProfileController.index(): " . $e->getMessage());
            $data = ['error_message' => $e->getMessage()];
            return view('error')->with($data);
        }
    }
}
