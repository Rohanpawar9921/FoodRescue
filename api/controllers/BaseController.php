<?php

class BaseController {
    protected $db;
    
    public function __construct() {
        $this->db = Database::getInstance(); //get instance call in the constructor
    }
    
    protected function requireLogin() {
        if (!isset($_SESSION['user_id'])) {
            throw new Exception('You must be logged in to perform this action');
        }
    }
    
    protected function getRequestData() {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            return $_POST;
        }
        return $_GET;
    }
    
    protected function validateRequired($data, $fields) {
        foreach ($fields as $field) {
            if (!isset($data[$field]) || trim($data[$field]) === '') {
                throw new Exception("Field '{$field}' is required");
            }
        }
    }
}
