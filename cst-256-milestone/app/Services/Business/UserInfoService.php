<?php


namespace App\Services\Business;

use App\Services\Utility\Connection;
use App\Services\Utility\ILoggerService;
use App\Services\Data\UserInfoDAO;
use App\Models\UserInfoModel;

class UserInfoService{
    
    //Attempts to find the userInfo associated with the passed user ID
    public function findByUserID(int $userID, ILoggerService $logger){
        
        $logger->info("Entering UserInfoService.findByUserID()");
        
        //Creates connection to the database
        $connection = new Connection();
        
        //Creates an instance of the data access object
        $DAO = new UserInfoDAO($connection, $logger);
        
        //Stores the results of the associated data access object function
        $result = $DAO->findByUserID($userID);
        
        //Closes the connection to the database
        $connection = null;
        
        $logger->info("Exiting UserInfoService.findByUserID()");
        
        //Returns the result from the data access object
        return $result;
    }
    
    //Takes a userInfoModel object as an argument and attempts to update the corresponding database entry
    public function editUserInfo(UserInfoModel $userInfo, ILoggerService $logger){
        
        $logger->info("Entering UserInfoService.editUserID()");
        
        //Creates connection to the database
        $connection = new Connection();
        
        //Creates an instance of the data access object
        $DAO = new UserInfoDAO($connection, $logger);
        
        //Stores the results of the associated data access object function
        $result = $DAO->editUserInfo($userInfo);
        
        //Closes the connection to the database
        $connection = null;
        
        $logger->info("Exiting UserInfoService.editUserID()");
        
        //Returns the result from the data access object
        return $result;
    }
    
    //Creates a new userInfo entry in the database with a foreign key corresponding to the ID passed as an argumnet
    public function createUserInfo(int $userID, $connection, ILoggerService $logger){
        
        $logger->info("Entering UserInfoService.createUserInfo()");
        
        //Creates an instance of the data access object
        $DAO = new UserInfoDAO($connection, $logger);
        
        //Stores the results of the associated data access object function
        $result = $DAO->createNewUserInfo($userID);
        
        //Closes the connection to the database
        $connection = null;
        
        $logger->info("Exiting UserInfoService.createUserInfo()");
        
        //Returns the result from the data access object
        return $result;
    }
}