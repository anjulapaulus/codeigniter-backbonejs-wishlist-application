<?php
class WishListModel extends CI_Model
{
    public function __construct()
    {
        parent::__construct();
        $this->load->database();
    }

    public function verifyUser($userId, $email)
    {
        $this->db->where('UserId', $userId);
        $result = $this->db->get('Users');
        if ($result->num_rows() == 1) {
            $row = $result->row();
            if ($row->Email === $email) {
                return true;
            }
            return false;
        } else {
            return false;
        }
    }

    public function existWishListForUser($userId)
    {
        $this->db->where('UserId', $userId);
        $result = $this->db->get('WishList');
        if ($result->num_rows() == 1) {
            return true;
        } else {
            return false;
        }
    }

    public function addWishList($userId, $title, $description)
    {
        date_default_timezone_set('Asia/Colombo');
        $date = date('Y-m-d, H:i:s', time());
        $this->db->insert("WishList", array("UserId" => $userId, "Title" => $title, "Description" => $description, "CreatedAt"=>$date, "UpdatedAt" => NULL));
        $insert_id = $this->db->insert_id();
        if ($insert_id) {
            return $insert_id;
        }
        return NULL;
    }

    public function updateWishList($userId, $title, $description)
    {
        date_default_timezone_set('Asia/Colombo');
        $date = date('Y-m-d, H:i:s', time());
        
        $this->db->where('UserId', $userId);
        $this->db->update('WishList', array("Title" => $title, "Description" => $description, "UpdatedAt" =>  $date));
        return true;
    }

    public function getWishList($userId){
        $this -> db -> where('UserId', $userId);
        $result = $this -> db -> get('WishList');
        if($result -> num_rows() == 1){
            $row = $result -> row();
            return $row;
        }
    }

    public function deleteWishList($listId){
        $this->db->where('ListId', $listId);
        $this->db->delete('WishList'); 
    }

    public function deleteWishListItems($listId){
        $this->db->where('ListId', $listId);
        $this->db->delete('WishListItems'); 
    }


    public function getListId($userId){
        $query = $this->db->get_where('WishList', array('UserId' => $userId));
        if ($query->num_rows() == 1) {
            $row = $query -> row();
            return $row->ListId;
        } else {
            return NULL;
        }
    }
}
