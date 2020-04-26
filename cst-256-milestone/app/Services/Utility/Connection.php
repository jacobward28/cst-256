<?php


namespace App\Services\Utility;

use Illuminate\Support\Facades\Log;
use PDO;
use Exception;

class Connection extends \PDO{
    
    //Calls super constructor with database information stored within the configuration file
    function __construct(){
        try{
            //Gets all the necessary connection information from the configuration file
            $servername = '127.0.0.1:54734';
            $username = 'azure';
            $password = '6#vWHD_$';
            $dbname = 'cst-256-milestone';
            
            //Calls PDO constructor with the config file information
            parent::__construct("mysql:host=$servername;dbname=$dbname", $username, $password);
            parent::setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        } catch (Exception $e){
            Log::error("Exception: ", array("message" => $e->getMessage()));
        }
    }
}