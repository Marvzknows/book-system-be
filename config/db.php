<?php

class Config {

    private $username = 'root';
    private $password = '';
    private $host = 'localhost';
    private $db_name = 'system_be';
    public $pdo = null;

    public function conn() {
        try {
            $this->pdo = new PDO('mysql:host='.$this->host.';dbname='.$this->db_name, $this->username, $this->password);
        } catch (PDOException $e) {
            echo 'Connection failed: ' . $e->getMessage();
        }

        return $this->pdo;

    }

    // Check Auth Token
    public function checkAuthToken() {
        $header = apache_request_headers();
        if(!isset($header['Authorization'])) {
            return false;
        }

        return true;
    }
}

?>
