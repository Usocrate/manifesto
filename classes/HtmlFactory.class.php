<?php
/**
 * @since 12/2017
 */
class HtmlFactory {
    
    private $env;
    
    public function __construct(Environment $env) {
        $this->env = $env;
    }
    
    public function getFooterTag() {
        return '<footer><a href="'.$this->env->getProjectUrl().'"><span class="brand">'.htmlentities($this->env->getProjectName()).'</span></a> - '.htmlentities($this->env->getProjectLaunchYear()).' - '.htmlentities($this->env->getProjectPunchline()).'</footer>';
    }
}

?>