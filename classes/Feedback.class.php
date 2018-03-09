<?php

// retour utilisateur

class Feedback {
    
    private $type;
    private $message;
    
    public function __construct($message, $type='info') {
        $this->message = $message;
        $this->type = $type;
    }
    
    public function getMessage() {
        return !empty($this->message) ? $this->message : null;
    }
    
    public function getType() {
        return $this->type;
    }
}