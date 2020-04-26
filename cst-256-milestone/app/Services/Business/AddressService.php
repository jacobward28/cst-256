<?php

namespace App\Services\Business;

use App\Services\Utility\Connection;
use App\Services\Utility\ILoggerService;
use App\Services\Data\AddressDAO;
use App\Models\AddressModel;

class AddressService{
    
    //Takes in a user's ID and returns the address associated with that ID
    public function findByUserID(int $userID, ILoggerService $logger){
        
        $logger->info("Entering AddressService.findByUserID()");
        
        $connection = new Connection();
        
        $DAO = new AddressDAO($connection, $logger);
        
        $result = $DAO->findByUserID($userID);
        
        $connection = null;
        
        $logger->info("Exiting AddressService.findByUserID()");
        
        return $result;
    }
    
    //Takes in an address model and updates the corresponding database entries information
    public function editAddress(AddressModel $address, ILoggerService $logger){
        
        $logger->info("Entering AddressService.editAddress()");
        
        $connection = new Connection();
        
        $DAO = new AddressDAO($connection, $logger);
        
        $result = $DAO->editAddress($address);
        
        $connection = null;
        
        $logger->info("Exiting AddressService.editAddress()");
        
        return $result;
    }
    
    //Takes in a user's ID and creates a new address in the database using that ID as the foreign key
    public function createAddress(int $userID, $connection, ILoggerService $logger){
        
        $logger->info("Entering AddressService.createAddress()");
        
        $DAO = new AddressDAO($connection, $logger);
        
        $result = $DAO->createAddress($userID);
        
        $connection = null;
        
        $logger->info("Exiting AddressService.createAddress() with a result of " . $result);
        
        return $result;
    }
}