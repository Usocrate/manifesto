<?php

// retour utilisateur

class Feedback {
    
    private $type;
    private $message;
    private $data;
    
    public function __construct($message, $type='info', $data=null) {
        $this->message = $message;
        $this->type = $type;
        $this->data = $data;
    }
    
    public function getMessage() {
        return !empty($this->message) ? $this->message : null;
    }
    
    public function getType() {
        return $this->type;
    }
    
    public function getData() {
        return $this->data;
    }
    
    public function addData($key, $datum) {
        if (!is_array($this->data)) $this->data = array();
    }
    
    public function getDatum($key) {
        return isset($this->data[$key]) ? $this->data[$key] : null;
    }
}