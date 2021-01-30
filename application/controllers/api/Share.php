<?php

defined('BASEPATH') or exit('No direct script access allowed');


require APPPATH . '/libraries/REST_Controller.php';

use Restserver\Libraries\REST_Controller;


class Share extends REST_Controller
{

    function __construct()
    {
        // Construct the parent class
        parent::__construct();
        $this->load->model('UserModel');
        $this->load->model('WishListModel');
        $this->load->model('WishListItemsModel');
    }
    function wishList_get(){
        $userId = $this->get('id');
        if ($userId) {
            $owner = $this->UserModel->getOwnerName($userId);
            $wishList = $this->WishListModel->getWishList($userId);
            $listId = $this->WishListModel->getListId($userId);
            $items = $this->WishListItemsModel->getWishListItems($listId);
            $this->response(
                array(
                    "status" => 1,
                    "owner" => $owner,
                    "wishList" => $wishList,
                    "items" => $items
                ),
                REST_Controller::HTTP_OK
            );
            
        } else {
            $this->response(
                array(
                    "status" => 0,
                    "message" => "User id needed"
                ),
                REST_Controller::HTTP_BAD_REQUEST
            );
        }
    }
}
