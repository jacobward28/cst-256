<?php


namespace App\Services\Data;

use App\Models\UserModel;
use App\Services\Utility\DatabaseException;
use App\Services\Utility\ILoggerService;
use PDO;

class UserDAO{
    
    //Stores the connection that functions will use to access the database
    private $conn;
    private $logger;
    
    //Takes in a PDO connection and sets the conn field equal to it
    public function __construct(PDO $conn, ILoggerService $logger){
        $this->conn = $conn;
        $this->logger = $logger;
    }
    //Returns an array of all the users in the database in the form of associative arrays
    public function getAll(){
        $this->logger->info("Entering UserDAO.getAll()");
        
        try{
            $statement = $this->conn->prepare("SELECT * FROM USERS WHERE ROLE != 1");
            $statement->execute();
        } catch (\PDOException $e){
            $this->logger->error("Exception: ", ["message" => $e->getMessage()]);
            throw new DatabaseException("Database Exception: " . $e->getMessage(), 0, $e);
        }
        
        //Temporary array to hold all user data
        $users = [];
        
        //Iterates over each user gotten back from the database query
        while($user = $statement->fetch(PDO::FETCH_ASSOC)){
            //Adds the associative array representing the currently iterated user to the users array
            array_push($users, $user);
        }
        
        $this->logger->info("Exit UserDAO.getAll()");
        
        //Returns the completed users array containing all of the user associative arrays
        return $users;
    }
    
    //Takes in a userID and returns an associative array containing that user's infromation from the database
    public function findByID(int $id){
        $this->logger->info("Entering UserDAO.findByID()");
        
        try{
            $statement = $this->conn->prepare("SELECT * FROM USERS WHERE IDUSERS = :id");
            $statement->bindParam(':id', $id);
            $statement->execute();
        } catch (\PDOException $e){
            $this->logger->error("Exception: ", ['message' => $e->getMessage()]);
            throw new DatabaseException("Database Exception: " . $e->getMessage(), 0, $e);
        }
        
        
        $this->logger->info("Exiting UserDAo.findByID()");
        //Returns whether or not the query found anything and the user in the event that it did
        return ['result' => $statement->rowCount(), 'user' => $statement->fetch(PDO::FETCH_ASSOC)];
    }
    /**
     * Returns an array of all the users in the database in the form of associative arrays
     * This method is used by the api
     */
    public function getAllUsers(){
        $this->logger->info("Entering UserDAO.getAll()");
        
        try{
            $statement = $this->conn->prepare("SELECT * FROM USERS WHERE ROLE != 1");
            $statement->execute();
        } catch (\PDOException $e){
            $this->logger->error("Exception: ", ["message" => $e->getMessage()]);
            throw new DatabaseException("Database Exception: " . $e->getMessage(), 0, $e);
        }
        $this->logger->info($statement->rowCount());
        if($statement->rowCount() == 0)
        {
            return array();
        }
        else
        {
            $index = 0;
            $users = array();
            while($row = $statement->fetch(PDO::FETCH_ASSOC))
            {
                $user = new UserModel($row['IDUSERS'], $row['USERNAME'],$row['EMAIL'] ,$row['PASSWORD'],
                 $row['FIRSTNAME'], $row['LASTNAME'], $row['STATUS'], $row['ROLE']);
                $users[$index++] = $user;
            }
        }
        $this->logger->info("Exit UserDAO.getAll()");
        
        //Returns the completed users array containing all of the user associative arrays
        return $users;
    }
    /**
     * Takes in a userID and returns an associative array containing that user's infromation from the database
     * This method is used by the api
     */
    public function findUserByID(int $id){
        $this->logger->info("Entering UserDAO.findByID()");
        
        try{
            $statement = $this->conn->prepare("SELECT * FROM USERS WHERE IDUSERS = :id");
            $statement->bindParam(':id', $id);
            $statement->execute();
        } catch (\PDOException $e){
            $this->logger->error("Exception: ", ['message' => $e->getMessage()]);
            throw new DatabaseException("Database Exception: " . $e->getMessage(), 0, $e);
        }
        if($statement->rowCount() == 0)
        {
            $this->logger->info("Exit UserDAO.findByUserID() with 0");
            return null;
        }
        else
        {
            $row = $statement->fetch(PDO::FETCH_ASSOC);
           
            $user = new UserModel($row["IDUSERS"], $row["USERNAME"], $row["PASSWORD"],$row['EMAIL'] ,$row['FIRSTNAME'],
             $row['LASTNAME'], $row['STATUS'], $row['ROLE']);
            $this->logger->info("Exit SecurityDAO.findByUser() with false");
            
            return $user;
        }
    }
    
    /*Takes a Login model as an argument and checks the database for an entry with both the appropriate username and password
    this method is to be used for the purpose of authenticating a user during login or for any other security check*/
    public function findByLogin(UserModel $user){
        $this->logger->info("Entering UserDAO.findByLogin()");
        $this->logger->info("Entering UserDAO.findByLogin()");
        
        try{
            //Gets username and password from the login model
            $username = $user->getUsername();
            $password = $user->getPassword();
            
            $statement = $this->conn->prepare("SELECT * FROM USERS WHERE BINARY USERNAME = :username AND PASSWORD = :password");
            //Binds the username and password to the respective query tokens
            $statement->bindParam(':username', $username);
            $statement->bindParam(':password', $password);
            $statement->execute();
        } catch (\PDOException $e){
            $this->logger->error("Exception: ", array("message" => $e->getMessage()));
            throw new DatabaseException("Database Exception: " . $e->getMessage(), 0, $e);
        }
        
        $this->logger->info("Exit UserDAO.authenticate()");
        //Returns the result of the query and an associative array representing the user
        return ['result' => $statement->rowCount(), 'user' => $statement->fetch(PDO::FETCH_ASSOC)];
    }
    
    //Takes in a usermodel and uses it to create a new user in the database
    public function create(UserModel $user){
        $this->logger->info("Entering UserDAO.register()");
        
        try{
            //Gets all of the information from the usermodel passed as an argument
            $username = $user->getUsername();
            $password = $user->getPassword();
            $email = $user->getEmail();
            $firstname = $user->getFirstName();
            $lastname = $user->getLastName();
            
            //Statement to create new entry in the users table with passed information and a NULL primary key and default values for the role and status
            $statement = $this->conn->prepare("INSERT INTO `USERS` (`IDUSERS`, `USERNAME`, `PASSWORD`, `EMAIL`, `FIRSTNAME`, `LASTNAME`, `STATUS`, `ROLE`) VALUES (NULL, :username, :password, :email, :firstname, :lastname, '1', '0')");
            //Binds all of the usermodel information to their respective tokens
            $statement->bindParam(':username', $username);
            $statement->bindParam(':password', $password);
            $statement->bindParam(':email', $email);
            $statement->bindParam(':firstname', $firstname);
            $statement->bindParam(':lastname', $lastname);
            $statement->execute();
        } catch (\PDOException $e){
            $this->logger->error("Exception: ", array("message" => $e->getMessage()));
            throw new DatabaseException("Database Exception: " . $e->getMessage(), 0, $e);
        }
        
        $this->logger->info("Exit UserDAO.register()");
        //Returns the result of the database query as well as the ID of the created user
        return ['result' => $statement->rowCount(), 'insertID' => $this->conn->lastInsertID()];
    }
    
    //Takes a usermodel as an argument and updates the user's database entry with the information passed
    public function update(UserModel $user){
        $this->logger->info("Entering UserDAO.update()");
        
        try{
            //Gets all of the information from the usermodel
            $id = $user->getId();
            $username = $user->getUsername();
            $password = $user->getPassword();
            $email = $user->getEmail();
            $firstname = $user->getFirstName();
            $lastname = $user->getLastName();
            $status = $user->getStatus();
            $role = $user->getRole();
            
            $statement = $this->conn->prepare("UPDATE `USERS` SET `USERNAME` = :username, `PASSWORD` = :password, `EMAIL` = :email, `FIRSTNAME` = :firstname, `LASTNAME` = :lastname, `STATUS` = :status, `ROLE` = :role WHERE `IDUSERS` = :id");
            //Binds all of the information from the usermodel to their respective query tokens
            $statement->bindParam(':username', $username);
            $statement->bindParam(':password', $password);
            $statement->bindParam(':email', $email);
            $statement->bindParam(':firstname', $firstname);
            $statement->bindParam(':lastname', $lastname);
            $statement->bindParam(':status', $status);
            $statement->bindParam(':role', $role);
            $statement->bindParam(':id', $id);
            $statement->execute();
        } catch (\PDOException $e){
            $this->logger->error("Exception: ", ["message" => $e->getMessage()]);
            throw new DatabaseException("Database Exception: " . $e->getMessage(), 0, $e);
        }
        
        $this->logger->info("Exit UserDAO.update()");
        //Returns the result of the query
        return $statement->rowCount();
    }
    
    //Takes in an ID as an argument and attempts to delete the user
    public function remove($id){
        $this->logger->info("Entering UserDAO.remove()");
        
        try{            
            $statement = $this->conn->prepare("DELETE FROM `USERS` WHERE `IDUSERS` = :id");
            //Binds the ID passed as an argument to the query
            $statement->bindParam(':id', $id);
            $statement->execute();
        } catch (\PDOException $e){
            $this->logger->error("Exception: ", ["message" => $e->getMessage()]);
            throw new DatabaseException("Database Exception: " . $e->getMessage(), 0, $e);
        }
        
        $this->logger->info("Exit UserDAO.remove()");
        //Returns the result of the query
        return $statement->rowCount();
    }
}