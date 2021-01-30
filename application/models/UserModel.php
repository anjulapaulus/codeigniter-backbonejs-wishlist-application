<?php
class UserModel extends CI_Model
{
    public function __construct()
    {
        parent::__construct();
        $this->load->database();
    }

    public function getUser($email, $pass)
    {

        $this -> db -> where('Email', $email);
        $result = $this -> db -> get('Users');
        if($result -> num_rows() == 1){
            $row = $result -> row();
            $hashed_pass = $row -> Password;
            if(password_verify($pass, $hashed_pass)){
                return $result->row();
            }
            return NULL;
        }
    }

    public function addUser($username, $email, $password)
    {
        $this->db->insert("Users", array("Username" =>$username, "Email" => $email, "Password"=>$password));
        $insert_id = $this->db->insert_id();
        if ($insert_id) {
            return $insert_id;
        }
        return NULL;
    }

    public function existUser($email){
        $this -> db -> where('Email',$email);
        $result = $this -> db -> get('Users');
        if($result -> num_rows() == 1){
            return true;
        }else{
            return false;
        }
    }

    public function getOwnerName($userId){
        $this -> db -> where('UserId', $userId);
        $result = $this -> db -> get('Users');
        if($result -> num_rows() == 1){
            $row = $result -> row();
            return $row->Username;
        }
    }
    public function getUserData($user_id){
        $this->db->select('UserId,Username,Email');
		$this->db->where("UserId", $user_id);
		$result = $this -> db -> get('Users');
		if($result -> num_rows() == 1){
            return $result -> row();
        }
	}

}
