<?php
class Quote {
    
    private $content;
    private $comment;
    private $set_id;
    private $lastedition;
    
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
    
    public function getContent() {
        return isset($this->content) ? $this->content : null;
    }
    
    public function getComment() {
        return isset($this->comment) ? $this->comment : null;
    }
    
    public function getSetId() {
        return isset($this->set_id) ? $this->set_id : null;
    }
    
    public function getLastEdition() {
        return isset($this->lastedition) ? $this->lastedition : null;
    }
}
?>
