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
        $output = array();
        foreach ($statement->fetchAll() as $data) {
            $output[] = new Quote($data);
        }
        return $output;
    }
    
    public function getQuote($id) {
        $statement = $this->env->getPdo()->prepare('SELECT * FROM quote WHERE id = ?');
        $statement->execute(array($id));
        $data = $statement->fetch();
        return new Quote($data);
    }    
    
    public function getReferences() {
        $statement = $this->env->getPdo()->prepare('SELECT * FROM reference');
        $statement->execute();
        $output = array();
        foreach ($statement->fetchAll() as $data) {
            $output[] = new Reference($data);
        }
        return $output;
    }
    
    public function getReference($id) {
        $statement = $this->env->getPdo()->prepare('SELECT * FROM reference WHERE id = ?');
        $statement->execute(array($id));
        $data = $statement->fetch();
        return new Reference($data);
    }
    
    public function getReferenceQuotes(Reference $r) {
        $statement = $this->env->getPdo()->prepare('SELECT quote.* FROM quote_reference LEFT JOIN quote ON (quote_reference.quote_id = quote.id) WHERE quote_reference.reference_id=?');
        $statement->execute(array($r->getId()));
        $output = array();
        foreach ($statement->fetchAll() as $data) {
            $output[$data['id']] = new Quote($data);
        }
        return $output;
    }
    
    public function attachQuoteToReference(Reference $r, Quote $q) {
        $statement = $this->env->getPdo()->prepare('INSERT INTO quote_reference SET reference_id=:r_id, quote_id=:q_id');
        $statement->bindValue(':r_id', $r->getId(), PDO::PARAM_INT);
        $statement->bindValue(':q_id', $q->getId(), PDO::PARAM_INT);
        return $statement->execute();
    }
    
    public function detachQuoteFromReference(Reference $r, Quote $q) {
        $statement = $this->env->getPdo()->prepare('DELETE FROM quote_reference WHERE reference_id=:r_id AND quote_id=:q_id');
        $statement->bindValue(':r_id', $r->getId(), PDO::PARAM_INT);
        $statement->bindValue(':q_id', $q->getId(), PDO::PARAM_INT);
        return $statement->execute();
    }    
    
    public function getQuoteReferences(Quote $q) {
        $statement = $this->env->getPdo()->prepare('SELECT reference.* FROM quote_reference LEFT JOIN reference ON (quote_reference.reference_id = reference.id) WHERE quote_reference.quote_id=?');
        $statement->execute(array($q->getId()));
        $output = array();
        foreach ($statement->fetchAll() as $data) {
            $output[$data['id']] = new Reference($data);
        }
        return $output;        
    }

    public function getSubscriptions() {
        $statement = $this->env->getPdo()->prepare('SELECT * FROM subscription');
        $statement->execute();
        return $statement->fetchAll();
    }

    public function registerReference(Reference $r) {
        //print_r($r);
        if ($r->hasId()) {
            $statement = $this->env->getPdo()->prepare('UPDATE reference SET title=:title, url=:url, comment=:comment, author=:author WHERE id=:id');
            $statement->bindValue(':id', $r->getId(), PDO::PARAM_INT);
        } else {
            $statement = $this->env->getPdo()->prepare('INSERT INTO reference SET title=:title, url=:url, comment=:comment, author=:author');   
        }
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
}
?>