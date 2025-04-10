<?php 
// require_once '../model/PortalUsers.php';
require_once __DIR__ . '/../model/PortalUsers.php'; 
class PortalUserController{
    private $userModel;
    
    public function __construct($mysqli)
    {
        $this->userModel = new PortalUsers($mysqli);
    }

    public function register($username, $pwd, $email, $role_id = 1){
        if(!isset($username) || !isset($pwd) || !isset($email) || !isset($role_id)){
            throw new Exception("Missing parameters");
        }
        
        $result = $this->userModel->create($username, $pwd, $email, $role_id);
        
        return $result;
    }

    public function login($username, $password){
        $isLoggedIn = $this->userModel->login($username, $password);

        return $isLoggedIn;
    }
}

?>