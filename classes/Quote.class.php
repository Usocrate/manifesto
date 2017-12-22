<?php
class Quote {
    
    private $content;
    private $comment;
    private $set_id;
    
    public function __construct($data=null) {
        if (isset($data) && is_array($data)) {
            foreach ($data as $k=>$v) {
                $this->{$k} = $v;
            }
        }
        //var_dump($this);
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
    
}
?>
