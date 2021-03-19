<?php
class Subscription {
    
    private $id;
    private $introduction;
    private $email;
    private $status;
    private $timestamp;
    
    public function __construct($data=null) {
        if (isset($data) && is_array($data)) {
            foreach ($data as $k=>$v) {
                $this->{$k} = $v;
            }
        }
        //var_dump($this);
    }
    
    public function hasId() {
        return !empty($this->id);
    }

    public function getId() {
        return isset($this->id) ? $this->id : null;
    }
    
    public function setId($input) {
        $this->id = $input;
    }

    public function getIntroduction() {
        return isset($this->introduction) ? $this->introduction : null;
    }
    
    public function setIntroduction($input) {
        $this->introduction = $input;
    }
    
    public function getEmail() {
        return isset($this->email) ? $this->email : null;
    }
    
    public function setEmail($input) {
        $this->email = $input;
    }
    
    public function getStatus() {
        return isset($this->status) ? $this->status : null;
    }
    
    public static function getStatusOptions() {
        return array('candidature à examiner'=>'to check', 'candidature validée'=>'validated', 'candidature rejetée'=>'rejected');
    }
    
    public function setStatus($input) {
        $this->status = $input;
    }
    
    public function isValidated() {
        return isset($this->status) && strcmp($this->status,'validated')==0;
    }

    public function isRejected() {
        return isset($this->status) && strcmp($this->status,'rejected')==0;
    }    
    
    public function getTimestamp() {
        return isset($this->timestamp) ? $this->timestamp : null;
    }
    
    public function setTimestamp($input) {
        $this->timestamp = $input;
    }    
}
?>
