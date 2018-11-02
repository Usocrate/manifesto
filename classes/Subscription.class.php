<?php
class Subscription {
    
    private $id;
    private $introduction;
    private $email;
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
    
    public function getTimestamp() {
        return isset($this->timestamp) ? $this->timestamp : null;
    }
    
    public function setTimestamp($input) {
        $this->timestamp = $input;
    }    
}
?>
