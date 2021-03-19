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
    /**
     * @since 12/2018
     */
    public function setTitle($input) {
        $this->title = $input;
    }
    
    public function getUrl() {
        return isset($this->url) ? $this->url : null;
    }

    /**
     * @since 12/2018
     */
    public function setUrl($input) {
        $this->url = $input;
    }
    
    public function getComment() {
        return isset($this->comment) ? $this->comment : null;
    }
    
    public function getAuthor() {
        return isset($this->author) ? $this->author : null;
    }
    
    /**
     * @since 12/2018
     */
    public function getTitleFromUrl($url = null) {
        $dom = new DOMDocument();
        
        error_reporting(E_ERROR); // impossible de garantir que la syntaxe du document cible soit parfaite, on passe les warning
        
        if (isset($url)) {
            $this->setUrl($url);
        }
        if ($dom->loadHTMLFile($this->url)) {
            $tags = $dom->getElementsByTagName('title');
            $t = $tags->item(0);
            if ($t instanceof DOMNode) {
                switch ($dom->encoding) {
                    case 'utf-8' :
                        $this->setTitle(html_entity_decode($t->nodeValue));
                        break;
                    default :
                        $this->setTitle( iconv($dom->encoding, 'utf-8', html_entity_decode($t->nodeValue)) );
                }
            }
            return $this->title;
        }
        return false;
    }
}
?>
