<?php
class Tweet {
    
    private $url;
    private $oEmbedHtml;
    
    public function __construct($url=null) {
        if (isset($url)) {
            $this->url = $url;
        }
    }
    
    public function getUrl() {
        return $this->url;
    }
    
    public function getOEmbedHtml() {
        if (!isset($this->oEmbedHtml)) {
            // récupération des données OEmbed auprès de Twitter
            $endpoint_url = 'https://publish.twitter.com/oembed?url='.urlencode($this->url).'&omit_script=1';
            $data = file_get_contents($endpoint_url);
            $object = json_decode($data);
            if (isset($object->html)) {
                $this->oEmbedHtml = $object->html;
            };            
        }
        return isset($this->oEmbedHtml) ? $this->oEmbedHtml : null;
    }
}