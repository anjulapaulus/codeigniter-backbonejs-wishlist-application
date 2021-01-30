<?php
class WishListItemsModel extends CI_Model
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

    public function getWishListForUser($userId)
    {
        $this->db->where('UserId', $userId);
        $result = $this->db->get('WishList');
        if ($result->num_rows() == 1) {
            $row = $result -> row();
            return $row->ListId;
        } else {
            return NULL;
        }
    }

    public function addWishListItem($title, $url, $price, $quantity, $priority, $listId)
    {
        date_default_timezone_set('Asia/Colombo');
        $date = date('Y-m-d, H:i:s', time());
        $this->db->insert("WishListItems", array("Title" => $title, "URL" => $url, "Price" => $price, "Quantity" => $quantity, "PriorityId" => $priority, "ListId" => $listId, "CreatedAt"=>$date, "UpdatedAt" => NULL));
        $insert_id = $this->db->insert_id();
        if ($insert_id) {
            return $insert_id;
        }
        return NULL;
    }

    public function updateWishListItem($title, $url, $price, $quantity, $priority, $listId, $itemId)
    {
        date_default_timezone_set('Asia/Colombo');
        $date = date('Y-m-d, H:i:s', time());
        
        $this->db->where('ItemId', $itemId);
        $this->db->update('WishListItems', array("Title" => $title, "URL" => $url, "Price" => $price, "Quantity" => $quantity,"PriorityId" => $priority, "ListId" => $listId, "UpdatedAt" => $date));
        return true;
    }

    public function getWishListItems($listId){
        $this -> db -> where('ListId', $listId);
        $this->db->order_by("PriorityId", "asc");
        $result = $this -> db -> get('WishListItems');

        $response = Array();
		foreach($result->result() as $row){
			$arr = array(
				"item_id" => $row->ItemId,
				"item_name" => $row->Title,
				"item_url" => $row->URL,
				"item_price" => $row->Price,
				"item_quantity" => $row->Quantity,
				"item_priority" => $row->PriorityId
			);
			array_push($response,$arr);
		}
		return $response;
    }

    public function getWishListItem($listId,$itemId){
        $this -> db -> where('ListId', $listId);
        $this -> db -> where('ItemId', $itemId);
        $result = $this -> db -> get('WishListItems');

        if ($result->num_rows() == 1) {
            return array(
                "item_id" => $result->ItemId,
                "item_name" => $result->Title,
                "item_url" => $result->URL,
                "item_price" => $result->Price,
                "item_quantity" => $result->Quantity,
                "item_priority" => $result->PriorityId);
        } else {
            return NULL;
        }
    }


    public function deleteWishListItem($itemId){
        $this->db->where('ItemId', $itemId);
        $this->db->delete('WishListItems'); 
    }

    public function existItem($itemId){
        $this->db->where('ItemId', $itemId);
        $result = $this->db->get('WishListItems');
        if ($result->num_rows() == 1) {
            return true;
        } else {
            return false;
        }
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