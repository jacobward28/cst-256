<?php

namespace App\Services\Data;

use App\Models\UserInfoModel;
use App\Services\Utility\Connection;
use App\Services\Utility\ILoggerService;
use Illuminate\Support\Facades\Log;
use PDO;
use App\Services\Utility\DatabaseException;

class UserInfoDAO{
    
    //Stores the connection to the database that will be used to execute the desired function
    private $connection;
    private $logger;
    
    //Takes in a PDO connection and sets the connection attribute equal to it
    public function __construct(Connection $conn, ILoggerService $logger){
        $this->connection = $conn;
        $this->logger = $logger;
    }
    
    //Takes in a user ID and returns the database row for that user
    public function findByUserID(int $id){
        $this->logger->info("Entering UserInfoDAO.findByUserID()");
        
        try{
            $statement = $this->connection->prepare("SELECT * FROM USER_INFO WHERE USERS_IDUSERS = :id");
            $statement->bindParam(':id', $id);
            $statement->execute();
        } catch (\PDOException $e){
            Log::error("Exception: ", ['message' => $e->getMessage()]);
            throw new DatabaseException("Database Exception: " . $e->getMessage(), 0, $e);
        }
        
        $this->logger->info("Exiting UserInfoDAO.findByUserID()");
        /*Returns an associative array containing the result of the database query as well as the userInfo in the form
        of an associative array*/
        return ['result' => $statement->rowCount(), 'userInfo' => $statement->fetch(PDO::FETCH_ASSOC)];
    }
    
    /*Function takes in a user id and creates a new empty userInfo entry that only contains its own primary key and the 
    user id that was passed as a foriegn key*/
    public function createNewUserInfo(int $userID){
        $this->logger->info("Entering UserInfoDAO.createNewUserInfo()");
        
        try{
            $statement = $this->connection->prepare("INSERT INTO USER_INFO (IDUSER_INFO, DESCRIPTION, PHONE, AGE, GENDER, USERS_IDUSERS) VALUES (NULL, NULL, NULL, NULL, NULL, :userid)");
            $statement->bindParam(':userid', $userID);
            $statement->execute();
        } catch (\PDOException $e){
            Log::error("Exception: ", ['message' => $e->getMessage()]);
            throw new DatabaseException("Database Exception: " . $e->getMessage(), 0, $e);
        }
        
        $this->logger->info("Exiting UserInfoDAO.createNewUserInfo()");
        //Returns the result of the query
        return $statement->rowCount();
    }
    
    /*Takes in a userInfoModel that contains all of the desired edited information and attempts to update the database entry
    with that information*/
    public function editUserInfo(UserInfoModel $userInfo){
        
        $this->logger->info("Entering UserInfoDAO.editUserInfo()");
        
        try{
            //Gets the information contained within the userInfoModel
            $description = $userInfo->getDescription();
            $age = $userInfo->getAge();
            $gender = $userInfo->getGender();
            $phone = $userInfo->getPhone();
            $userID = $userInfo->getUserID();
            
            $statement = $this->connection->prepare("UPDATE USER_INFO SET DESCRIPTION = :description, PHONE = :phone, AGE = :age, GENDER = :gender WHERE USERS_IDUSERS = :userid");
            //Binds the information from the model to the query tokens
            $statement->bindParam(':description', $description);
            $statement->bindParam(':phone', $phone);
            $statement->bindParam(':age', $age);
            $statement->bindParam(':gender', $gender);
            $statement->bindParam(':userid', $userID);
            $statement->execute();
        } catch (\PDOException $e){
            Log::error("Exception: ", ['message' => $e->getMessage()]);
            throw new DatabaseException("Database Exception: " . $e->getMessage(), 0, $e);
        }
        
        $this->logger->info("Exiting UserInfoDAO.editUserInfo()");
        //Returns the result of the query
        return $statement->rowCount();
    }
}