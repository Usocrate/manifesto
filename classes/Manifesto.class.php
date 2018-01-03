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

    public function registerReference(Reference $r) {
        //print_r($r);
        $statement = $this->env->getPdo()->prepare('INSERT INTO reference SET title=:title, url=:url, comment=:comment, author=:author');
        $statement->bindValue(':title', $r->getTitle(), PDO::PARAM_STR);
        $statement->bindValue(':url', $r->getUrl(), PDO::PARAM_STR);
        $statement->bindValue(':comment', $r->getComment(), PDO::PARAM_STR);
        $statement->bindValue(':author', $r->getAuthor(), PDO::PARAM_STR);
        if ($statement->execute()) {
            return 'Référence "'.$r->getTitle().'" enregistrée';
        } else {
            return 'Référence "'.$r->getTitle().'" non enregistrée';
        }
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
    
    public function getQuote($id) {
        $statement = $this->env->getPdo()->prepare('SELECT * FROM quote WHERE id = ?');
        $statement->execute(array($id));
        $data = $statement->fetch();
        return new Quote($data);
    }
}
?>