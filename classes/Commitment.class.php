<?php
class Commitment {
    
    private $id;
    private $title;

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

    public function setId($input) {
        $this->id = $input;
    }

    public function hasId() {
        return !empty($this->id);
    }
    
    public function getTitle() {
        return isset($this->title) ? $this->title : null;
    }
}
?>
