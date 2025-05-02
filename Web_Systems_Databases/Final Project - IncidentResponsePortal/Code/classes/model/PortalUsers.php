<?php

use function PHPSTORM_META\type;

class PortalUsers{
    private $db;

    public function __construct($db)
    {
       $this->db = $db; 
    }

    public function getDb(){
        return $this->db;
    }

    /**
     * @param username: username to be created
     * @param pwd: user password
     * @param email: user email
     * @param role_id: user role (admin-1, reporter or responder)
     */
    public function create($username, $pwd, $email, $role_id = 1){
        $query = <<<END
            INSERT INTO Portal_Users(username, password, email, role_id) VALUES('{$username}', '{$pwd}', '{$email}', {$role_id});
        END;
        $this->db->query($query);
    }

    /**
     * @param username: username entered in login input
     * @param password: password entered in login input
     * @return isValid: return the user_id(if valid) and if the credentials are valid or not
     */
    public function login($username, $password){
        $query = <<<END
            SELECT * FROM Portal_Users WHERE username = '{$username}' AND password = '{$password}';
        END;
        $result = $this->db->query($query);
        if($result->num_rows > 0){
            // valid, returning user_id and valid
            return [
                'isValid' => true,
                'user_id' => $result->user_id
            ];

        } else {
            return [
                'isValid' => false,
            ];
        }
    }   

    /**
     * @param username: the user logged in
     * @return int; role id which is used on other pages to see what role the user has
     */

    public function getPermission($username) {
        $stmt = $this->db->prepare("SELECT role_id FROM Portal_Users WHERE username = ?");
        $stmt->bind_param("s", $username);
        $stmt->execute();
        $result = $stmt->get_result();

        if ($result->num_rows === 0) {
            return 0;
        } else {
            $row = $result->fetch_assoc();
            return (int)$row['role_id'];
        }
        }


        /**
         * @param role_id: check the user role
         * @param username: user username, to not return itself
         * @return: all registered users
         */
        public function getAllUsers($role_id, $username) {
            if ($role_id != 1) {
                return [];
            }
        
            $stmt = $this->db->prepare("SELECT * FROM Portal_Users WHERE username != ? ORDER BY user_id");
            $stmt->bind_param("s", $username);
            $stmt->execute();
            $result = $stmt->get_result();
        
            return $result->fetch_all(MYSQLI_ASSOC);
        }
        

        /**
         * @param user_id: user to be deleted
         * @return boolean: return success(1) or not (0)
         */
        public function deleteUser($user_id){
            if($user_id == null || $user_id < 0 || !is_numeric($user_id)) return false; 

            $stmt = $this->db->prepare("DELETE FROM Portal_Users WHERE user_id = ?;");
            $stmt->bind_param("i", $user_id);
            $stmt->execute();

            if($stmt->affected_rows > 1) return true;

        }
}
?>