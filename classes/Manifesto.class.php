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
    
    public function getReferences() {
        $statement = $this->env->getPdo()->prepare('SELECT * FROM reference');
        $statement->execute();
        return $statement->fetchAll();
    }

    public function getSubscriptions() {
        $statement = $this->env->getPdo()->prepare('SELECT * FROM subscription');
        $statement->execute();
        return $statement->fetchAll();
    }    
    
    public function registerSubscription($id) {
        $statement = $this->env->getPdo()->prepare('INSERT INTO subscription SET usocrate_id=:id, mail=:mail');
        $statement->bindValue(':id', $_POST['id'], PDO::PARAM_STR);
        $statement->bindValue(':mail', $_POST['mail'], PDO::PARAM_STR);
        if ($statement->execute()) {
            $output['success'] = true;
            $output['message'] = 'Bienvenue camarade usocrate.';
        }
        return $output;     
    }
}
?>