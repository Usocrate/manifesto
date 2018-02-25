<?php
class ToolBox {
    
	public static function toHtml($input) {
		return htmlentities($input, ENT_HTML5);
	}
	
	public static function formatUserPost($input) {
		if (is_array($input)) {
			array_walk($input, 'ToolBox::formatUserPost');
		} else {
			$data = strip_tags($input);
			$data = html_entity_decode($input, ENT_HTML5);
			$data = trim($input);
		}
	}
}