<?php

defined('BASEPATH') or exit('No direct script access allowed');


require APPPATH . '/libraries/REST_Controller.php';

use Restserver\Libraries\REST_Controller;

require APPPATH . '/libraries/JWT.php';
require APPPATH . '/libraries/JWTHandler.php';

class User extends REST_Controller
{

    function __construct()
    {
        // Construct the parent class
        parent::__construct();
        $this->load->model('UserModel');
        $this->load->model('WishListModel');
        $this->JWTHandler = new JWTHandler;
    }

    // End point to user login


    function login_post()
    {
        // localhost:8888/Wisher/index.php/api/user/login

        $email = $this->post('email', TRUE);
        $password = $this->post('password', TRUE);
        if (!empty($email) && !empty($password)) {
            //Login model function
            $userDetails = $this->UserModel->getUser($email, $password);
            if ($userDetails) {
                $wishListDetails = $this->WishListModel->getWishList($userDetails->UserId);

                $data['userId'] = $userDetails->UserId;
                $data['email'] = $userDetails->Email;

                $jwtToken = $this->JWTHandler->GetToken($data);

                if ($wishListDetails) {
                    $this->response(
                        array(
                            "status" => true,
                            "message" => "Successfully validated user",
                            "id" => $userDetails->UserId,
                            "name" => $userDetails->Username,
                            "email" => $userDetails->Email,
                            "wish_list_name" => $wishListDetails->Title,
                            "wish_list_description" => $wishListDetails->Description,
                            "acccess_token" => $jwtToken
                        ),
                        REST_Controller::HTTP_OK
                    );
                } else {
                    $this->response(
                        array(
                            "status" => true,
                            "message" => "Successfully validated user",
                            "id" => $userDetails->UserId,
                            "name" => $userDetails->Username,
                            "email" => $userDetails->Email,
                            "wish_list_name" => "",
                            "wish_list_description" => "",
                            "acccess_token" => $jwtToken
                        ),
                        REST_Controller::HTTP_OK
                    );
                }
            } else {
                $this->response(
                    array(
                        "status" => 0,
                        "message" => "The credentials provided are invalid"
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
    }

    function register_post()
    {
        $name = $this->post('name', TRUE);
        $email = $this->post('email', TRUE);
        $password = $this->post('password', TRUE);

        $hashedPassword = password_hash($password, PASSWORD_DEFAULT);

        if (!empty($name) && !empty($email) &&  !empty($password)) {
            //Register model function
            if (!$this->UserModel->existUser($email)) {
                $user = $this->UserModel->addUser($name, $email, $hashedPassword);
                if ($user > 0) {
                    $this->response(
                        array(
                            "status" => 1,
                            "message" => "User registered successfully"
                        ),
                        REST_Controller::HTTP_OK
                    );
                } else {
                    $this->response(
                        array(
                            "status" => 0,
                            "message" => "User couldn't be registered"
                        ),
                        REST_Controller::HTTP_INTERNAL_SERVER_ERROR
                    );
                }
            } else {
                $this->response(
                    array(
                        "status" => 0,
                        "message" => "User already exists"
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
    }
    function index_get()
    {
        $last = $this->uri->total_segments();
        $user_id = $this->uri->segment($last);
        $userData = $this->UserModel->getUserData($user_id);
        if (($userData != null) && !empty($userData)) {
            $wishListDetails = $this->WishListModel->getWishList($user_id);

            if ($wishListDetails) {
                $this->response(
                    array(
                        "status" => true,
                        "message" => "Successfully validated user",
                        "id" => $userData->UserId,
                        "name" => $userData->Username,
                        "email" => $userData->Email,
                        "wish_list_name" => $wishListDetails->Title,
                        "wish_list_description" => $wishListDetails->Description
                    ),
                    REST_Controller::HTTP_OK
                );
            } else {
                $this->response(
                    array(
                        "status" => 0,
                        "message" => "No wish list"
                    ),
                    REST_Controller::HTTP_BAD_REQUEST
                );
            }
        }else{
            $this->response(
                array(
                    "status" => 0,
                    "message" => "No User"
                ),
                REST_Controller::HTTP_BAD_REQUEST
            );
        }
    }
}
