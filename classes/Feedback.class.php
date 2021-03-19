<?php

// retour utilisateur

class Feedback {
    
    public $type;
    public $message;
    public $data;
    
    public function __construct($message=null, $type='info', $data=null) {
        $this->message = $message;
        $this->type = $type;
        $this->data = $data;
    }
    
    public function getMessage() {
        return !empty($this->message) ? $this->message : null;
    }
    /**
     * @since 12/2018
     */
    public function setMessage($input) {
        return $this->message = $input;
    }
    public function getType() {
        return $this->type;
    }
    /**
     * @since 12/2018
     */
    public function setType($input) {
        return $this->type = $input;
    }
    
    public function getData() {
        return $this->data;
    }
    /**
     * @since 12/2018
     */
    public function addDatum($key, $datum) {
        if (!is_array($this->data)) $this->data = array();
        $this->data[$key] = $datum;
    }
    
    public function getDatum($key) {
        return isset($this->data[$key]) ? $this->data[$key] : null;
    }
    
    public function toJson() {
        return json_encode($this);
    }
}