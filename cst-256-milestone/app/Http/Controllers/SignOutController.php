<?php


namespace App\Http\Controllers;

use App\Services\Utility\ILoggerService;
use Illuminate\Support\Facades\Session;

class SignOutController extends Controller
{

    // Doesn't take any information from a previous form or anything simply logs actions flushes the session and returns to home
    public function index(ILoggerService $logger)
    {
        try {
            $logger->info("Entering SignOutController.index()");
            // Flushing session variables will effectively log the user out of the website
            Session::flush();

            $logger->info("Exiting SignOutController.index()");

            return view('home');
        } catch (\Exception $e){
            
        }
    }
}
