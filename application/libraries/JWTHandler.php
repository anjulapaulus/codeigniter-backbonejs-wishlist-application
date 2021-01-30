<?php
require_once APPPATH . '/libraries/JWT.php';
require APPPATH . '/libraries/BeforeValidException.php';
require APPPATH . '/libraries/ExpiredException.php';
require APPPATH . '/libraries/SignatureInvalidException.php';

use \Firebase\JWT\JWT;

class JWTHandler
{

    private $secureKey = "baj4bjbdjbj12bvhv35n5na452jsbajdjldhbe1ts";

    public function GetToken($data)
    {
        $issuerClaim = "w1673640.users.ecs.westminster.ac.uk";
        $issuedatClaim = time(); // issued time - Given in Seconds
        $expireClaim = $issuedatClaim + 60 * 60 * 24; // expire time in seconds- 1hour
        $payload = array(
            "iss" => $issuerClaim,
            "iat" => $issuedatClaim,
            "exp" => $expireClaim,
            "data" => $data
        );
        $jwt = JWT::encode($payload, $this->secureKey);
        return $jwt;
    }

    public function DecodeToken($token)
    {
        try {
            $decoded = JWT::decode($token, $this->secureKey, array('HS256'));
            $decodedData = (array)$decoded;
            return $decodedData;
        } catch (Exception $e) {
            return NULL;
        }
    }

    public function ExtractTokenFromHeader($bearerToken)
    {
        if (!empty($bearerToken)) {
            if (preg_match('/Bearer\s(\S+)/', $bearerToken, $matches)) {
                return $matches[1];
            }
            return NULL;
        }
    }
}
