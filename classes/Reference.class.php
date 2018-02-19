<?php
class Reference {
    
    private $id;
    private $title;
    private $url;
    private $comment;
    private $author;

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

    public function hasId() {
        return !empty($this->id);
    }
    
    public function getTitle() {
        return isset($this->title) ? $this->title : null;
    }
    
    public function getUrl() {
        return isset($this->url) ? $this->url : null;
    }
    
    public function getComment() {
        return isset($this->comment) ? $this->comment : null;
    }
    
    public function getAuthor() {
        return isset($this->author) ? $this->author : null;
    }
}
?>
