<?php
/**
 * @since 09/2017
 */
class Manifesto {
    
    private $env;
    
    public function __construct(Environment $env) {
        $this->env = $env;
    }
    
    public function getQuotes() {
        $statement = $this->env->getPdo()->prepare('SELECT * FROM quote');
        $statement->execute();
        return $statement->fetchAll();
    }
}