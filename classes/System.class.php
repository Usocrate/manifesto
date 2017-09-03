<?php
/**
 * @since 09/2017
 */
class System {
    
    private $config_file_path;
    
    public $db_host;
    public $db_name;
    public $db_user;
    public $db_password;
    
    private $project_url;
    private $project_name;
    private $project_description;
    private $project_publisher;
    private $project_creator;
    
    public $host_purpose;
    
    private $ga_key; // Google Analytics
    
    public function __construct($path) {
        $this->config_file_path = $path;
        $this->parseConfigFile();
        /*
        iconv_set_encoding ( 'internal_encoding', 'UTF-8' );
        iconv_set_encoding ( 'input_encoding', 'UTF-8' );
        iconv_set_encoding ( 'output_encoding', 'UTF-8' );
        */
        ini_set('default_charset', 'UTF-8');
    }
    
    public function reportException($context = null, Exception $e) {
        $message = empty($context) ? $e->getMessage() : $context . ' : ' . $e->getMessage();
        switch ($this->host_purpose) {
            case 'production':
                error_log($message);
                break;
            default:
                trigger_error($message);
        }
    }    

    public function configFileExists() {
        return file_exists($this->config_file_path);
    }

    public function parseConfigFile() {
        try {
            if (is_readable($this->config_file_path)) {
                $data = json_decode(file_get_contents($this->config_file_path), true);
                foreach ($data as $key => $value) {
                    switch ($key) {
                        case 'db_host':
                            $this->db_host = $value;
                            break;
                        case 'db_name':
                            $this->db_name = $value;
                            break;
                        case 'db_user':
                            $this->db_user = $value;
                            break;
                        case 'db_password':
                            $this->db_password = $value;
                            break;
                        case 'project_url':
                            $this->project_url = $value;
                            break;
                        case 'project_name':
                            $this->project_name = $value;
                            break;
                        case 'project_description':
                            $this->project_description = $value;
                            break;
                        case 'project_publisher':
                            $this->project_publisher = $value;
                            break;
                        case 'project_creator':
                            $this->project_creator = $value;
                            break;
                        case 'host_purpose':
                            $this->host_purpose = $value;
                            break;
                    }
                }
            } else {
                throw new Exception('Le fichier de configuration doit être accessible en lecture.');
            }
        } catch (Exception $e) {
            $this->reportException(__METHOD__, $e);
            return false;
        }
    }
    
    public function getPdo() {
        try {
            if (! isset($this->pdo)) {
                $this->pdo = new PDO('mysql:host=' . $this->db_host . ';dbname=' . $this->db_name, $this->db_user, $this->db_password, array(
                    PDO::ATTR_PERSISTENT => true
                ));
                $this->pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
                $this->pdo->exec('SET NAMES utf8');
            }
            return $this->pdo;
        } catch (PDOException $e) {
            $this->reportException(__METHOD__, $e);
            return false;
        }
    }

    public function getProjectName() {
        return $this->project_name;
    }
    
    public function getProjectDescription() {
        return $this->project_description;
    }
    
    public function getGoogleAnalyticsKey() {
        return $this->ga_key;
    }
    
    public function hasGoogleAnalyticsKey() {
        return ! empty($this->ga_key);
    }    
}
?>