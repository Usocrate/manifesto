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
        $tags = array();
        $tags['brand'] = '<a href="'.$this->env->getProjectUrl().'"><span class="brand">'.htmlentities($this->env->getProjectName()).'</span></a>';
        $tags['launchYear'] = htmlentities($this->env->getProjectLaunchYear());
        $tags['punchline'] = htmlentities($this->env->getProjectPunchline());
        if (isset($_SESSION['extended'])) {
            $tags['admin'] = '<a href="'.$this->env->getProjectUrl().'/admin">Admin</a>';
        }
        return '<footer>'.implode(' - ', $tags).'</footer>';
    }
}

?>