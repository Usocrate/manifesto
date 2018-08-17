<?php
/**
 * @since 09/2017
 */
class Manifesto {
    
    private $env;
    
    public function __construct(Environment $env) {
        $this->env = $env;
    }
    
    public function getQuotes($criteria = null, $sort = null) {
        
        $sql = 'SELECT * FROM quote';
        
        switch ($sort) {
            case 'Oldest edition first':
                $sql.= ' ORDER BY lastedition ASC';
                break;
        }

        $statement = $this->env->getPdo()->prepare($sql);
        $statement->execute();
        $output = array();
        foreach ($statement->fetchAll() as $data) {
            $output[$data['id']] = new Quote($data);
        }
        return $output;
    }
    
    public function getCommitmentQuotes(Commitment $c, $criteria = null, $sort = null) {
        
        $sql = 'SELECT quote.* FROM commitment_quote INNER JOIN quote ON (commitment_quote.quote_id = quote.id) WHERE commitment_quote.commitment_id=?';
        
        switch ($sort) {
            case 'Oldest edition first':
                $sql.= ' ORDER BY quote.lastedition ASC';
                break;
            default :
                $sql.= ' ORDER BY commitment_quote.position ASC';
                break;                
        }

        $statement = $this->env->getPdo()->prepare($sql);
        $statement->execute(array($c->getId()));
        $output = array();
        foreach ($statement->fetchAll() as $data) {
            $output[$data['id']] = new Quote($data);
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
            $output[$data['id']] = new Reference($data);
        }
        return $output;
    }
    
    public function getCommitments() {
        $statement = $this->env->getPdo()->prepare('SELECT * FROM commitment');
        $statement->execute();
        $output = array();
        foreach ($statement->fetchAll() as $data) {
            $output[$data['id']] = new Commitment($data);
        }
        return $output;
    }
    
    public function getDetachedReferences() {
        $statement = $this->env->getPdo()->prepare('SELECT r.* FROM reference AS r LEFT OUTER JOIN quote_reference ON (quote_reference.reference_id = r.id) WHERE quote_reference.reference_id IS NULL');
        $statement->execute();
        $output = array();
        foreach ($statement->fetchAll() as $data) {
            $output[$data['id']] = new Reference($data);
        }
        return $output;
    }
    
    public function getReference($id) {
        $statement = $this->env->getPdo()->prepare('SELECT * FROM reference WHERE id = ?');
        $statement->execute(array($id));
        $data = $statement->fetch();
        return new Reference($data);
    }
    
    public function deleteReference($id) {
        $statement = $this->env->getPdo()->prepare('DELETE FROM reference WHERE id = ?');
        if ($statement->execute(array($id))) {
            return new Feedback('référence retirée', 'success');
        } else {
            return new Feedback('la référence n\'a pu être supprimée', 'warning');
        }
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
    
    public function attachQuoteToCommitment(Quote $q, Commitment $c) {
        try {  
            //$this->env->getPdo()->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            
            $this->env->getPdo()->beginTransaction();
    
            // on supprime les associations préexistantes
            $statement = $this->env->getPdo()->prepare('DELETE FROM commitment_quote WHERE quote_id=?');
            $statement->execute(array($q->getId()));
    
            // on associe la déclaration à un engagement
            $statement = $this->env->getPdo()->prepare('INSERT INTO commitment_quote SET commitment_id=:c_id, quote_id=:q_id');
            $statement->bindValue(':q_id', $q->getId(), PDO::PARAM_INT);
            $statement->bindValue(':c_id', $c->getId(), PDO::PARAM_INT);
            $statement->execute();
            
            $this->env->getPdo()->commit();
            
            return new Feedback('La déclaration est associée à l\'engagement '.$c->getTitle().'.', 'success');
            
        } catch (Exception $e) {
          $this->env->getPdo()->rollBack();
          trigger_error($e->getMessage());
        }
    }
    
    public function attachTweetToQuote(Tweet $t, Quote $q) {
        $statement = $this->env->getPdo()->prepare('INSERT INTO quote_tweet SET quote_id=:q_id, tweet_url=:t_url');
        $statement->bindValue(':q_id', $q->getId(), PDO::PARAM_INT);
        $statement->bindValue(':t_url', $t->getUrl(), PDO::PARAM_INT);
        return $statement->execute();
    }    

    public function getQuoteCommitment(Quote $q) {
        $statement = $this->env->getPdo()->prepare('SELECT commitment.* FROM commitment_quote INNER JOIN commitment ON (commitment_quote.commitment_id = commitment.id) WHERE commitment_quote.quote_id=?');
        $statement->execute(array($q->getId()));
        return new Commitment($statement->fetch());
    }
    
    public function getDetachedQuotes() {
        
        $sql = 'SELECT quote.* FROM quote LEFT OUTER JOIN commitment_quote ON (quote.id = commitment_quote.quote_id) WHERE commitment_quote.commitment_id IS NULL';

        $statement = $this->env->getPdo()->prepare($sql);
        $statement->execute();
        $output = array();
        foreach ($statement->fetchAll() as $data) {
            $output[$data['id']] = new Quote($data);
        }
        return $output;
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
    
    public function getQuoteTweets(Quote $q) {
        $statement = $this->env->getPdo()->prepare('SELECT tweet_url FROM quote_tweet WHERE quote_id=?');
        $statement->execute(array($q->getId()));
        $output = array();
        foreach ($statement->fetchAll() as $data) {
            $output[] = new Tweet($data['tweet_url']);
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
            return new Feedback('Référence "'.$r->getTitle().'" enregistrée', 'success');
        } else {
            return new Feedback('Référence "'.$r->getTitle().'" non enregistrée', 'warning');
        }
    }    

    public function registerQuote(Quote $q) {
        //print_r($r);
        if ($q->hasId()) {
            $statement = $this->env->getPdo()->prepare('UPDATE quote SET content=:content, comment=:comment, set_id=:set_id WHERE id=:id');
            $statement->bindValue(':id', $q->getId(), PDO::PARAM_INT);
        } else {
            $statement = $this->env->getPdo()->prepare('INSERT INTO quote SET content=:content, comment=:comment, set_id=:set_id');   
        }
        $statement->bindValue(':content', $q->getContent(), PDO::PARAM_STR);
        $statement->bindValue(':comment', $q->getComment(), PDO::PARAM_STR);
        $statement->bindValue(':set_id', $q->getSetId(), PDO::PARAM_INT);
        if ($statement->execute()) {
            if (!$q->hasId()) {
                $q->setId($this->env->getPdo()->lastInsertId());
            }
            return new Feedback('Déclaration "'.$q->getContent().'" enregistrée', 'success', array('registredQuote' => $q));
        } else {
            return 'Déclaration "'.$q->getContent().'" non enregistrée';
        }
    }
    
    public function deleteQuote($id) {
        $statement = $this->env->getPdo()->prepare('DELETE FROM quote WHERE id = ?');
        if ($statement->execute(array($id))) {
            return new Feedback('déclaration retirée', 'success');
        } else {
            return new Feedback('la déclaration n\'a pu être supprimée', 'warning');
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