<?php

namespace Core\Database;

/**
 * Class DAO
 * DAO générique
 */
abstract class DAO
{
    protected $pdo;
    protected $table;
    protected $class;
    protected $key;

    public function __construct($pdo)
    {
        // Warning si les enfants n'ont pas défini les propriétés
        assert(isset($this->table));
        assert(isset($this->class));
        assert(isset($this->key));

        $this->pdo = $pdo;
    }

    /**
     * Récupère un enregistrement en base à partir de son id
     * @param $id
     * @return mixed
     */
    public function getOne($id)
    {
        $stmt = $this->pdo->prepare("SELECT * FROM $this->table WHERE $this->key=?");
        $stmt->setFetchMode(PDO::FETCH_CLASS, $this->class);
        $stmt->execute([$id]);
        return $stmt->fetch();
    }

    /**
     * Récupère tous les enregistrements    
     * @return mixed
     */
    public function getAll()
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
            throw new Exception('Invalid object class!');

        $params = [];
        $binds = [];

        // Récupération des champs
        $fields = $obj->getFields();
        $id = $fields[$this->key];
        unset($fields[$this->key]);

        // Préparation des paramètres et de leur bind    
        foreach ($fields as $key => $value) {
            $params[] = "$key = ?";
            $binds[] = $value;
        }

        $params = implode($params, ',');

        $stmt = $this->pdo->prepare("UPDATE $this->table SET $params WHERE $this->key='$id'");        
        return $stmt->execute($binds);
    }

    /**
     * Supprime un enregistrement en base
     * @param int $id
     * @return bool
     */
    public function delete($id)
    {
        $stmt = $this->pdo->prepare("DELETE FROM $this->table WHERE $this->key=:id");
        return $stmt->execute([$id]);
    }
}