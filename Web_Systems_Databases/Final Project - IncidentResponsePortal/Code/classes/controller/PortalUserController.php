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
        $_SESSION["user_id"] = $isLoggedIn["user_id"];
        return $isLoggedIn;
    }

    public function getPermission($username){
        
        $permissions = $this->userModel->getPermission($username);
        return $permissions;
    }

    public function getAllUsers($role_id, $username){
        $users = $this->userModel->getAllUsers($role_id, $username);

        return $users;
    }

    public function deleteUser($user_id){
        if($user_id == null || $user_id < 0 || !is_numeric($user_id)) return false; 
        
        $success = $this->userModel->deleteUser($user_id);

        if($success) return true;
    }
}

?>