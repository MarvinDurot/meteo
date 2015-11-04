<?php

namespace Core\Table;

/**
 * Class Table
 * Table générique
 */
abstract class Table {

    protected $pdo;
    protected $table;
    protected $class;
    
    // Nom des champs composant la clé primaire de la table
    protected $keys = [];
    protected $keyWhereClause;


    public function __construct($pdo) 
    {
        // Warning si les enfants n'ont pas défini les propriétés obligatoires
        assert(isset($this->table));
        assert(isset($this->class));
        assert(isset($this->keys));

        $this->pdo = $pdo;
        $this->keyWhereClause = $this->buildKeyWhereClause();
    }
    
    public function getColumnNames()
    {
        $stmt = $this->pdo->query("DESCRIBE $this->table");
        return $stmt->fetchAll(PDO::FETCH_COLUMN);
    }
    
    /**
     * Construction de la clause WHERE pour la clé primaire (pour find, delete et update)
     * @return string
     */
    protected function buildKeyClause()
    {       
        return implode(' AND', array_map(function($key){ return "$key = ?"; }, $this->keys));        
    }

    /**
     * Récupère un enregistrement en base à partir de sa clé
     * @param array $key
     * @return mixed
     */
    abstract function find($key) {}

    /**
     * Récupère tous les enregistrements
     * @return mixed
     */
    public function all() 
    {
        $stmt = $this->pdo->query("SELECT * FROM $this->table");
        return $stmt->fetchAll(PDO::FETCH_CLASS, $this->class);
    }    

    /**
     * Sauvegarde un enregistrement en base
     * @param $obj
     * @return bool
     * @throws Exception
     */
    public function save($obj)
    {
        // On teste la classe de l'objet passé en param
        if (!$obj instanceof $this->class)
            throw new TableException('Invalid object class!');
            
        
    }
    
    abstract function insert($obj);
    abstract function update($obj);

    /**
     * Supprime un enregistrement en base
     * @param int $id
     * @return bool
     */
    public function delete($key) 
    {
        $stmt = $this->pdo->prepare("DELETE FROM $this->table WHERE $this->keyWhereClause");
        return $stmt->execute($key);
    }

}
