<?php

defined('BASEPATH') or exit('No direct script access allowed');


require APPPATH . '/libraries/REST_Controller.php';

use Restserver\Libraries\REST_Controller;

require APPPATH . '/libraries/JWT.php';
require APPPATH . '/libraries/JWTHandler.php';


class WishList extends REST_Controller
{

    function __construct()
    {
        // Construct the parent class
        parent::__construct();
        $this->load->model('WishListModel');
        $this->load->model('WishListItemsModel');
        $this->JWTHandler = new JWTHandler;
    }


    function wishList_post()
    {  
        $bearerToken = $this->input->get_request_header('Authorization');
        if ($bearerToken) {
            $token = $this->JWTHandler->ExtractTokenFromHeader($bearerToken);
            $tokenData = $this->JWTHandler->DecodeToken($token);
            if ($tokenData != NULL) {
                $userId = $tokenData['data']->userId;
                $email = $tokenData['data']->email;
                if ($this->WishListModel->verifyUser($userId, $email)) {
                    $title = $this->post('list_name');
                    $description = $this->post('list_description');
                    if (!empty($title) && !empty($description)) {
                        if (!$this->WishListModel->existWishListForUser($userId)) {
                            $wishlist = $this->WishListModel->addWishList($userId, $title, $description);
                            if ($wishlist > 0) {
                                $this->response(
                                    array(
                                        "status" => 1,
                                        "message" => "Wish List created successfully"
                                    ),
                                    REST_Controller::HTTP_OK
                                );
                            } else {
                                $this->response(
                                    array(
                                        "status" => 0,
                                        "message" => "Wihslist couldn't be created"
                                    ),
                                    REST_Controller::HTTP_INTERNAL_SERVER_ERROR
                                );
                            }
                        } else {
                            $this->response(
                                array(
                                    "status" => 0,
                                    "message" => "Wish list already created"
                                ),
                                REST_Controller::HTTP_UNAUTHORIZED
                            );
                        }
                    } else {
                        $this->response(
                            array(
                                "status" => 0,
                                "message" => "All fields are needed"
                            ),
                            REST_Controller::HTTP_BAD_REQUEST
                        );
                    }
                } else {
                    $this->response(
                        array(
                            "status" => 0,
                            "message" => "The token has expired"
                        ),
                        REST_Controller::HTTP_UNAUTHORIZED
                    );
                }
            } else {
                $this->response(
                    array(
                        "status" => 0,
                        "message" => "The token is invalid"
                    ),
                    REST_Controller::HTTP_UNAUTHORIZED
                );
            }
        } else {
            $this->response(
                array(
                    "status" => 0,
                    "message" => "The token is missing"
                ),
                REST_Controller::HTTP_UNAUTHORIZED
            );
        }
    }

    function wishList_get()
    {
        $bearerToken = $this->input->get_request_header('Authorization');
        if ($bearerToken) {
            $token = $this->JWTHandler->ExtractTokenFromHeader($bearerToken);
            $tokenData = $this->JWTHandler->DecodeToken($token);
            if ($tokenData != NULL) {
                $userId = $tokenData['data']->userId;
                $email = $tokenData['data']->email;
                if ($this->WishListModel->verifyUser($userId, $email)) {
                    $wishListData = $this->WishListModel->getWishList($userId);
                    $this->response(
                        array(
                            "status" => 1,
                            "wishListDetails" => array(
                                "title" => $wishListData->Title,
                                "description" => $wishListData->Description
                            )
                        ),
                        REST_Controller::HTTP_OK
                    );
                } else {
                    $this->response(
                        array(
                            "status" => 0,
                            "message" => "The token is invalid"
                        ),
                        REST_Controller::HTTP_UNAUTHORIZED
                    );
                }
            } else {
                $this->response(
                    array(
                        "status" => 0,
                        "message" => "The token has expired"
                    ),
                    REST_Controller::HTTP_UNAUTHORIZED
                );
            }
        } else {
            $this->response(
                array(
                    "status" => 0,
                    "message" => "The token is missing"
                ),
                REST_Controller::HTTP_UNAUTHORIZED
            );
        }
    }

    function wishList_put()
    {
        $bearerToken = $this->input->get_request_header('Authorization');
        if ($bearerToken) {
            $token = $this->JWTHandler->ExtractTokenFromHeader($bearerToken);
            $tokenData = $this->JWTHandler->DecodeToken($token);
            if ($tokenData != NULL) {
                $userId = $tokenData['data']->userId;
                $email = $tokenData['data']->email;
                if ($this->WishListModel->verifyUser($userId, $email)) {
                    $title = $this->put('title');
                    $description = $this->put('description');
                    if (!empty($title) && !empty($description)) {
                        if ($this->WishListModel->existWishListForUser($userId)) {
                            if ($this->WishListModel->updateWishList($userId, $title, $description)) {
                                $this->response(
                                    array(
                                        "status" => 1,
                                        "message" => "Wish list updated"
                                    ),
                                    REST_Controller::HTTP_OK
                                );
                            }
                        } else {
                            $this->response(
                                array(
                                    "status" => 0,
                                    "message" => "Wish list not updated"
                                ),
                                REST_Controller::HTTP_OK
                            );
                        }
                    } else {
                        $this->response(
                            array(
                                "status" => 0,
                                "message" => "All fields are needed"
                            ),
                            REST_Controller::HTTP_BAD_REQUEST
                        );
                    }
                } else {
                    $this->response(
                        array(
                            "status" => 0,
                            "message" => "The token has expired"
                        ),
                        REST_Controller::HTTP_UNAUTHORIZED
                    );
                }
            } else {
                $this->response(
                    array(
                        "status" => 0,
                        "message" => "The token is invalid"
                    ),
                    REST_Controller::HTTP_UNAUTHORIZED
                );
            }
        } else {
            $this->response(
                array(
                    "status" => 0,
                    "message" => "The token is missing"
                ),
                REST_Controller::HTTP_BAD_REQUEST
            );
        }
    }

    function wishList_delete()
    {
        $bearerToken = $this->input->get_request_header('Authorization');
        if ($bearerToken) {
            $token = $this->JWTHandler->ExtractTokenFromHeader($bearerToken);
            $tokenData = $this->JWTHandler->DecodeToken($token);
            if ($tokenData != NULL) {
                $userId = $tokenData['data']->userId;
                $email = $tokenData['data']->email;
                if ($this->WishListModel->verifyUser($userId, $email)) {
                    $listId = $this->WishListModel->getListId($userId);
                    if ($listId) {
                        $this->WishListModel->deleteWishListItems($listId);
                        $this->WishListModel->deleteWishList($listId);
                        $this->response(
                            array(
                                "status" => 1,
                                "message" => "The wishlist has been deleted successfully"
                            ),
                            REST_Controller::HTTP_OK
                        );
                    } else {
                        $this->response(
                            array(
                                "status" => 0,
                                "message" => "The wishlist doesn't exist"
                            ),
                            REST_Controller::HTTP_OK
                        );
                    }
                }
            }
        }
    }

    function item_post()
    {
        
        $bearerToken = $this->input->get_request_header('Authorization');
        if ($bearerToken) {
            $token = $this->JWTHandler->ExtractTokenFromHeader($bearerToken);
            $tokenData = $this->JWTHandler->DecodeToken($token);
            if ($tokenData != NULL) {
                $userId = $tokenData['data']->userId;
                $email = $tokenData['data']->email;
                if ($this->WishListModel->verifyUser($userId, $email)) {
                    $title = $this->post('item_name');
                    $url = $this->post('item_url');
                    $price = $this->post('item_price');
                    $quantity = $this->post('item_quantity');
                    $priorityId = $this->post('item_priority');
                    if (!empty($title) && !empty($url) && !empty($price) && !empty($priorityId) && !empty($quantity)) {
                        if ($this->WishListItemsModel->getWishListForUser($userId)) {
                            $list = $this->WishListItemsModel->getWishListForUser($userId);
                            $wishlist = $this->WishListItemsModel->addWishListItem($title, $url, $price, $quantity, $priorityId, $list);
                            if ($wishlist > 0) {
                                $this->response(
                                    array(
                                        "status" => 1,
                                        "message" => "Wish List item added successfully"
                                    ),
                                    REST_Controller::HTTP_OK
                                );
                            } else {
                                $this->response(
                                    array(
                                        "status" => 0,
                                        "message" => "Wihslist item could not be added"
                                    ),
                                    REST_Controller::HTTP_INTERNAL_SERVER_ERROR
                                );
                            }
                        } else {
                            $this->response(
                                array(
                                    "status" => 0,
                                    "message" => "Wish list does not exist for user"
                                ),
                                REST_Controller::HTTP_OK
                            );
                        }
                    } else {
                        $this->response(
                            array(
                                "status" => 0,
                                "message" => "All fields are needed"
                            ),
                            REST_Controller::HTTP_BAD_REQUEST
                        );
                    }
                } else {
                    $this->response(
                        array(
                            "status" => 0,
                            "message" => "The token has expired"
                        ),
                        REST_Controller::HTTP_UNAUTHORIZED
                    );
                }
            } else {
                $this->response(
                    array(
                        "status" => 0,
                        "message" => "The token is invalid"
                    ),
                    REST_Controller::HTTP_UNAUTHORIZED
                );
            }
        } else {
            $this->response(
                array(
                    "status" => 0,
                    "message" => "The token is missing"
                ),
                REST_Controller::HTTP_UNAUTHORIZED
            );
        }
    }

    function items_get()
    {
        $bearerToken = $this->input->get_request_header('Authorization');
        if ($bearerToken) {
            $token = $this->JWTHandler->ExtractTokenFromHeader($bearerToken);
            $tokenData = $this->JWTHandler->DecodeToken($token);
            if ($tokenData != NULL) {
                $userId = $tokenData['data']->userId;
                $email = $tokenData['data']->email;
                if ($this->WishListItemsModel->verifyUser($userId, $email)) {
                    if ($this->WishListItemsModel->getWishListForUser($userId)) {
                        $list = $this->WishListItemsModel->getWishListForUser($userId);
                        $result = $this->WishListItemsModel->getWishListItems($list);
                        $this->response(
                            $result,
                            REST_Controller::HTTP_OK
                        );
                    } else {
                        $this->response(
                            array(
                                "status" => 0,
                                "message" => "Wish list does not exist for user"
                            ),
                            REST_Controller::HTTP_BAD_REQUEST
                        );
                    }
                } else {
                    $this->response(
                        array(
                            "status" => 0,
                            "message" => "The token is invalid"
                        ),
                        REST_Controller::HTTP_UNAUTHORIZED
                    );
                }
            } else {
                $this->response(
                    array(
                        "status" => 0,
                        "message" => "The token has expired"
                    ),
                    REST_Controller::HTTP_UNAUTHORIZED
                );
            }
        } else {
            $this->response(
                array(
                    "status" => 0,
                    "message" => "The token is missing"
                ),
                REST_Controller::HTTP_UNAUTHORIZED
            );
        }
    }

    function item_get()
    {
        $bearerToken = $this->input->get_request_header('Authorization');
        if ($bearerToken) {
            $token = $this->JWTHandler->ExtractTokenFromHeader($bearerToken);
            $tokenData = $this->JWTHandler->DecodeToken($token);
            if ($tokenData != NULL) {
                $userId = $tokenData['data']->userId;
                $email = $tokenData['data']->email;
                if ($this->WishListItemsModel->verifyUser($userId, $email)) {
                    if ($this->WishListItemsModel->getWishListForUser($userId)) {
                        $last = $this->uri->total_segments();
			            $itemId = $this->uri->segment($last);
                        $list = $this->WishListItemsModel->getWishListForUser($userId);
                        $result = $this->WishListItemsModel->getWishListItem($list, $itemId);
                        $this->response(
                            array(
                                "status" => 1,
                                "itemDetails" => $result
                            ),
                            REST_Controller::HTTP_OK
                        );
                    } else {
                        $this->response(
                            array(
                                "status" => 0,
                                "message" => "Wish list does not exist for user"
                            ),
                            REST_Controller::HTTP_BAD_REQUEST
                        );
                    }
                } else {
                    $this->response(
                        array(
                            "status" => 0,
                            "message" => "The token is invalid"
                        ),
                        REST_Controller::HTTP_UNAUTHORIZED
                    );
                }
            } else {
                $this->response(
                    array(
                        "status" => 0,
                        "message" => "The token has expired"
                    ),
                    REST_Controller::HTTP_UNAUTHORIZED
                );
            }
        } else {
            $this->response(
                array(
                    "status" => 0,
                    "message" => "The token is missing"
                ),
                REST_Controller::HTTP_UNAUTHORIZED
            );
        }
    }

    function item_put()
    {
        $bearerToken = $this->input->get_request_header('Authorization');
        if ($bearerToken) {
            $token = $this->JWTHandler->ExtractTokenFromHeader($bearerToken);
            $tokenData = $this->JWTHandler->DecodeToken($token);
            if ($tokenData != NULL) {
                $userId = $tokenData['data']->userId;
                $email = $tokenData['data']->email;
                if ($this->WishListModel->verifyUser($userId, $email)) {
                    $last = $this->uri->total_segments();
			        $itemId = $this->uri->segment($last);
                    $title = $this->put('item_name');
                    $url = $this->put('item_url');
                    $price = $this->put('item_price');
                    $quantity = $this->put('item_quantity');
                    $priorityId = $this->put('item_priority');
                    if (!empty($title) && !empty($url) && !empty($price) && !empty($priorityId) && !empty($itemId) && !empty($quantity)) {
                        if ($this->WishListItemsModel->getWishListForUser($userId)) {
                            $list = $this->WishListItemsModel->getWishListForUser($userId);
                            if ($this->WishListItemsModel->updateWishListItem($title, $url, $price, $quantity, $priorityId, $list, $itemId)) {
                                $this->response(
                                    array(
                                        "status" => 1,
                                        "message" => "Wish list item updated"
                                    ),
                                    REST_Controller::HTTP_OK
                                );
                            }
                        } else {
                            $this->response(
                                array(
                                    "status" => 0,
                                    "message" => "Wish list item not updated"
                                ),
                                REST_Controller::HTTP_BAD_REQUEST
                            );
                        }
                    } else {
                        $this->response(
                            array(
                                "status" => 0,
                                "message" => "All fields are needed"
                            ),
                            REST_Controller::HTTP_BAD_REQUEST
                        );
                    }
                } else {
                    $this->response(
                        array(
                            "status" => 0,
                            "message" => "The token has expired"
                        ),
                        REST_Controller::HTTP_UNAUTHORIZED
                    );
                }
            } else {
                $this->response(
                    array(
                        "status" => 0,
                        "message" => "The token is invalid"
                    ),
                    REST_Controller::HTTP_UNAUTHORIZED
                );
            }
        } else {
            $this->response(
                array(
                    "status" => 0,
                    "message" => "The token is missing"
                ),
                REST_Controller::HTTP_BAD_REQUEST
            );
        }
    }

    function item_delete()
    {
        $bearerToken = $this->input->get_request_header('Authorization');
        if ($bearerToken) {
            $token = $this->JWTHandler->ExtractTokenFromHeader($bearerToken);
            $tokenData = $this->JWTHandler->DecodeToken($token);
            if ($tokenData != NULL) {
                $userId = $tokenData['data']->userId;
                $email = $tokenData['data']->email;
                if ($this->WishListItemsModel->verifyUser($userId, $email)) {
                    $last = $this->uri->total_segments();
			        $item_id = $this->uri->segment($last);
                    if ($item_id) {
                        $listId = $this->WishListItemsModel->getListId($userId);
                        if ($listId) {
                            $check = $this->WishListItemsModel->existItem($item_id);
                            if ($check) {
                                $this->WishListItemsModel->deleteWishListItem($item_id);
                                $this->response(
                                    array(
                                        "status" => 1,
                                        "message" => "The wishlist item has been deleted successfully"
                                    ),
                                    REST_Controller::HTTP_OK
                                );
                            } else {
                                $this->response(
                                    array(
                                        "status" => 0,
                                        "message" => "The item doesn't exist"
                                    ),
                                    REST_Controller::HTTP_BAD_REQUEST
                                );
                            }
                        } else {
                            $this->response(
                                array(
                                    "status" => 0,
                                    "message" => "The wishlist doesn't exist"
                                ),
                                REST_Controller::HTTP_BAD_REQUEST
                            );
                        }
                    } else {
                        $this->response(
                            array(
                                "status" => 0,
                                "message" => "Item id needed"
                            ),
                            REST_Controller::HTTP_BAD_REQUEST
                        );
                    }
                }
            }else {
                $this->response(
                    array(
                        "status" => 0,
                        "message" => "The token is invalid"
                    ),
                    REST_Controller::HTTP_UNAUTHORIZED
                );
            }
        } else {
            $this->response(
                array(
                    "status" => 0,
                    "message" => "The token is missing"
                ),
                REST_Controller::HTTP_BAD_REQUEST
            );
        }

    }
}
