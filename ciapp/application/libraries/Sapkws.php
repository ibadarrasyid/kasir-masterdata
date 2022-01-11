<?php

/**
 * Description of Sapkws
 * Handle SAPK Web Service
 * @author Velly Tursinei
 */
class Sapkws {

    var $url = 'https://wstraining.bkn.go.id/bkn-resources-server/';
    var $user = '8201wstraining';
    var $pass = 'vfrtg56789';
    var $token = array();
    var $tokenFile = APPPATH . 'libraries/token.json';
    var $gms = null;

    public function __construct() {
        $this->CI = & get_instance();
        $this->gms = new Gmsfunc();
        if (file_exists($this->tokenFile)) {
            $json = file_get_contents($this->tokenFile);
            $this->token = json_decode($json, TRUE);
        } else {
            echo "Token file not found";
            exit();
        }
    }

    private function getToken() {
        $this->CI->load->helper('file');
        $urlToken = 'https://wstraining.bkn.go.id/oauth/token';
        $header = array(
            "Content-Type: application/x-www-form-urlencoded",
            "Authorization: basic " . base64_encode($this->user . $this->pass),
            "origin: http://localhost:20000"
        );
        $data = array(
            'client_id' => $this->user,
            'grant_type' => 'client_credentials'
        );
        $return = $this->gms->useCurl($urlToken, true, $data, $header);
        write_file($this->tokenFile, $return);
    }

    public function getSapk($urlPath){
        $header = array(
            "Content-Type: application/x-www-form-urlencoded",
            "Authorization: ".$this->token['token_type'] ." ". $this->token['access_token'],
            "origin: http://localhost:20000"
        );
        $return = $this->gms->useCurl($this->url.$urlPath, false, array(), $header);
        return $return;
    }
    
}