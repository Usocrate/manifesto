<?php
class ToolBox {
    
	/**
	 * @version 02/2022
	 */
	public static function toHtml($input) {
		return is_string($input) ? htmlentities ( $input, ENT_QUOTES | ENT_HTML5, 'UTF-8' ):'';
	}
	
	public static function formatUserPost($input) {
		if (is_array($input)) {
			array_walk($input, 'ToolBox::formatUserPost');
		} else {
			$output = strip_tags($input);
			//$output = html_entity_decode($output, ENT_HTML5);
			$output = trim($output);
			return $output;
		}
	}
}