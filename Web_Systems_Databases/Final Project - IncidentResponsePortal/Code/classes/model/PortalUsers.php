<?php 
class PortalUsers{
    private $db;

    public function __construct($db)
    {
       $this->db = $db; 
    }

    public function getDb(){
        return $this->db;
    }

    public function create($username, $pwd, $email, $role_id = 1){
        $query = <<<END
            INSERT INTO portal_users(username, password, email, role_id) VALUES('{$username}', '{$pwd}', '{$email}', {$role_id});
        END;
        $this->db->query($query);
    }

    public function login($username, $password){
        $query = <<<END
            SELECT * FROM portal_users WHERE username = '{$username}' AND password = '{$password}';
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
}
?>