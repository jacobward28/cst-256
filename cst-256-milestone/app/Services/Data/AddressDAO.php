<?php


namespace App\Services\Data;

use App\Models\AddressModel;
use App\Services\Utility\ILoggerService;
use PDO;
use App\Services\Utility\DatabaseException;

class AddressDAO{
    
    //Field that stores the connection all the function user to execute their queries
    private $connection;
    private $logger;
    
    //Takes in a connection as an argument and assigns it to the connection field
    public function __construct(PDO $conn, ILoggerService $logger){
        $this->connection = $conn;
        $this->logger = $logger;
    }
    
    //Takes in an ID and returns the address associated with that userID
    public function findByUserID(int $userID){
        
        $this->logger->info("Entering AddressDAO.findByUserID()");
        
        try{
            $statement = $this->connection->prepare("SELECT * FROM ADDRESS WHERE USERS_IDUSERS = :id");
            //Binds the ID passed as an argument to the query
            $statement->bindParam(':id', $userID);
            $statement->execute();
        } catch (\PDOException $e){
            $this->logger->error("Exception: ", ['message' => $e->getMessage()]);
            throw new DatabaseException("Database Exception: " . $e->getMessage(), 0, $e);
        }
        
        $this->logger->info("Exiting AddressDAO.findByUserID()");
        //Returns the result of the query along with an associative array containing the address information
        return ['result' => $statement->rowCount(), 'address' => $statement->fetch(PDO::FETCH_ASSOC)];
    }
    
    /*Takes an addressModel as an argument and attempts to update the associated database entry with the information contained
    in the addressModel*/
    public function editAddress(AddressModel $address){
        
        $this->logger->info("Entering AddressDAO.editAddress()");
        
        try{
            //Gets all the information from the addressModel
            $street = $address->getStreet();
            $city = $address->getCity();
            $state = $address->getState();
            $zip = $address->getZip();
            $userID = $address->getUserID();
            
            $statement = $this->connection->prepare("UPDATE ADDRESS SET STREET = :street, CITY = :city, STATE = :state, ZIP = :zip WHERE USERS_IDUSERS = :userid");
            //Binds the information from the addressModel to its respective query token
            $statement->bindParam(':street', $street);
            $statement->bindParam(':city', $city);
            $statement->bindParam(':state', $state);
            $statement->bindParam(':zip', $zip);
            $statement->bindParam(':userid', $userID);
            $statement->execute();
        } catch (\PDOException $e){
            $this->logger->error("Exception: ", ['message' => $e->getMessage()]);
            throw new DatabaseException("Database Exception: " . $e->getMessage(), 0, $e);
        }
        
        $this->logger->info("Exiting AddressDAO.editAddress()");
        //Returns the result of the query
        return $statement->rowCount();
    }
    
    //Takes an ID as an argument and creates a new address entry in the database with the passed ID as a foreign key
    public function createAddress(int $userID){
        
        $this->logger->info("Entering AddressDAO.createAddress()");
        
        try{
            $statement = $this->connection->prepare("INSERT INTO ADDRESS (IDADDRESS, STREET, CITY, STATE, ZIP, USERS_IDUSERS) VALUES (NULL, NULL, NULL, NULL, NULL, :userid)");
            //Binds the passed ID to the appropriate token
            $statement->bindParam(':userid', $userID);
            $statement->execute();
        } catch (\PDOException $e){
            $this->logger->error("Exception: ", ['message' => $e->getMessage()]);
            throw new DatabaseException("Database Exception: " . $e->getMessage(), 0, $e);
        }
        
        $this->logger->info("Exiting AddressDAO.createAddress()");
        //Returns teh result of the query
        return $statement->rowCount();
    }
}