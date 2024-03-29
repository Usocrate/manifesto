<?php
/**
 * @since 09/2017
 */
class Environment {
	private $config_file_path;
	public $db_host;
	public $db_name;
	public $db_user;
	public $db_password;
	public $dir_path;
	private $project_url;
	private $project_name;
	private $project_punchline;
	private $project_description;
	private $project_publisher;
	private $project_creator;
	private $project_launch_year;
	public $host_purpose;
	private $ga_key; // Google Analytics
	
	public function __construct($path) {
		$this->config_file_path = $path;
		$this->parseConfigFile ();

		ini_set ( 'default_charset', 'UTF-8' );

		spl_autoload_register ( array (
				$this,
				'loadClass'
		) );
	}
	public function loadClass($class_name) {
		if (is_file ( $this->dir_path . DIRECTORY_SEPARATOR . 'classes' . DIRECTORY_SEPARATOR . $class_name . '.class.php' )) {
			include_once $this->dir_path . DIRECTORY_SEPARATOR . 'classes' . DIRECTORY_SEPARATOR . $class_name . '.class.php';
			return true;
		} elseif ($this->dir_path . DIRECTORY_SEPARATOR . 'classes' . DIRECTORY_SEPARATOR . $class_name . '.interface.php') {
			include_once $this->dir_path . DIRECTORY_SEPARATOR . 'classes' . DIRECTORY_SEPARATOR . $class_name . '.interface.php';
			return true;
		} else {
			error_log ( $class_name . ' not found.' );
			return false;
		}
	}
	public function reportException($context = null, Exception $e) {
		$message = empty ( $context ) ? $e->getMessage () : $context . ' : ' . $e->getMessage ();
		switch ($this->host_purpose) {
			case 'production' :
				error_log ( $message );
				break;
			default :
				trigger_error ( $message );
		}
	}
	public function configFileExists() {
		return file_exists ( $this->config_file_path );
	}
	public function parseConfigFile() {
		try {
			if (is_readable ( $this->config_file_path )) {
				$data = json_decode ( file_get_contents ( $this->config_file_path ) );
				foreach ( $data as $key => $value ) {
					switch ($key) {
						case 'dir_path' :
							$this->dir_path = $value;
							break;
						case 'db_host' :
							$this->db_host = $value;
							break;
						case 'db_name' :
							$this->db_name = $value;
							break;
						case 'db_user' :
							$this->db_user = $value;
							break;
						case 'db_password' :
							$this->db_password = $value;
							break;
						case 'project_url' :
							$this->project_url = $value;
							break;
						case 'project_name' :
							$this->project_name = $value;
							break;
						case 'project_punchline' :
							$this->project_punchline = $value;
							break;
						case 'project_description' :
							$this->project_description = $value;
							break;
						case 'project_publisher' :
							$this->project_publisher = $value;
							break;
						case 'project_creator' :
							$this->project_creator = $value;
							break;
						case 'project_launch_year' :
							$this->project_launch_year = $value;
							break;
						case 'host_purpose' :
							$this->host_purpose = $value;
							break;
						case 'ga_key' :
							$this->ga_key = $value;
							break;
					}
				}
			} else {
				throw new Exception ( 'Le fichier de configuration doit être accessible en lecture.' );
			}
		} catch ( Exception $e ) {
			$this->reportException ( __METHOD__, $e );
			return false;
		}
	}
	public function getPdo() {
		try {
			if (! isset ( $this->pdo )) {
				$this->pdo = new PDO ( 'mysql:host=' . $this->db_host . ';dbname=' . $this->db_name, $this->db_user, $this->db_password, array (
						PDO::ATTR_PERSISTENT => true
				) );
				$this->pdo->setAttribute ( PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION );
				$this->pdo->setAttribute ( PDO::ATTR_DEFAULT_FETCH_MODE, PDO::FETCH_ASSOC );
				$this->pdo->exec ( 'SET NAMES utf8' );
			}
			return $this->pdo;
		} catch ( PDOException $e ) {
			$this->reportException ( __METHOD__, $e );
			return false;
		}
	}
	public function getHtmlHeadTagsForFavicon() {
		$output = array ();
		$output [] = '<link rel="icon" type="image/png" sizes="32x32" href="' . $this->getSkinUrl () . '/images/favicon-32x32.png">';
		$output [] = '<link rel="icon" type="image/png" sizes="16x16" href="' . $this->getSkinUrl () . '/images/favicon-16x16.png">';
		$output [] = '<link rel="manifest" href="' . $this->getSkinUrl () . '/manifest.json">';
		$output [] = '<meta name="application-name" content="' . ToolBox::toHtml ( $this->getProjectName () ) . '">';
		$output [] = '<meta name="theme-color" content="#079bb8">';
		return $output;
	}
	public function writeHtmlHeadTagsForFavicon() {
		foreach ( $this->getHtmlHeadTagsForFavicon () as $tag ) {
			echo $tag;
		}
	}
	public function getProjectName() {
		return $this->project_name;
	}
	public function getProjectPunchline() {
		return $this->project_punchline;
	}
	public function getProjectDescription() {
		return $this->project_description;
	}
	public function getProjectUrl() {
		return $this->project_url;
	}
	public function getSkinUrl() {
		return $this->project_url . '/skin';
	}
	public function getProjectLaunchYear() {
		return $this->project_launch_year;
	}
	public function getGoogleAnalyticsKey() {
		return $this->ga_key;
	}
	public function hasGoogleAnalyticsKey() {
		return ! empty ( $this->ga_key );
	}
}
?>