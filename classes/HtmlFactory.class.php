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
        $tags['brand'] = '<a href="'.$this->env->getProjectUrl().'"><span class="brand">'.htmlspecialchars($this->env->getProjectName()).'</span></a>';
        $tags['launchYear'] = htmlspecialchars($this->env->getProjectLaunchYear());
        $tags['punchline'] = htmlspecialchars($this->env->getProjectPunchline());
        if (isset($_SESSION['extended'])) {
            $tags['admin'] = '<a href="'.$this->env->getProjectUrl().'/admin">Admin</a>';
        }
        return '<footer>'.implode(' - ', $tags).'</footer>';
    }
    
    
    public function getAlertsTag($alerts) {
    	$html = '';
    	if (count($alerts)>0) {
			foreach($alerts as $type=>$messages) {
				$classes = array('alert');
				switch ($type) {
					case 'success' :
						$classes[] = 'alert-success';
						break;
					case 'warning' :
						$classes[] = 'alert-warning';
						break;
					default :
						$classes[] = 'alert-info';
				}
				$html.= '<div class="'.implode(' ',$classes).'">';
				foreach ($messages as $m) {
					$html.=  htmlspecialchars($m).'<br>';
				}
				$html.= '</div>';
			}
		}
		return $html;
    }    
}

?>