<?php

namespace Core\Table;

/**
 * Class Table
 * Table générique
 */
class Table
{
    /**
     * Objet PDO
     */
    protected $pdo;

    /**
     * Propriétés obligatoires :
     * -> nom de la table
     * -> nom du modèle associé
     * -> nom des champs de la clé primaire
     */
    protected $table;
    protected $class;
    protected $key = [];

    /**
     * Indique si la clé primaire est auto-incrémentée
     */
    protected $increment = true;

    /**
     * Nom des colonnes de la table
     * (sans le ou les clés primaires)
     */
    protected $columns = [];

    /**
     * Clause WHERE pour la clé primaire
     */
    protected $keyClause;

    /**
     * Requêtes préparées
     */
    protected $stmtWhere = [];
    protected $stmtFind = null;
    protected $stmtDelete = null;
    protected $stmtCreate = null;
    protected $stmtUpdate = null;

    /**
     * Constructeur
     * @param \PDO $pdo
     */
    public function __construct($pdo)
    {
        /* Warning si les enfants n'ont pas défini
         les propriétés obligatoires */
        assert(isset($this->table));
        assert(isset($this->class));
        assert(isset($this->key));

        $this->pdo = $pdo;
        $this->columns = $this->getColumns();
        $this->keyClause = $this->buildKeyClause();
    }

    /**
     * Retrouve le nom des champs de la table sans les clés
     * @return array
     * @throws TableException
     */
    private function getColumns()
    {
        $stmt = $this->pdo->query("DESCRIBE $this->table");

        if ($stmt->rowCount() === 0)
            throw new TableException('Table without columns!');

        $columns = $stmt->fetchAll(\PDO::FETCH_COLUMN);
        return array_diff($columns, $this->key);
    }

    /**
     * Construit la clause WHERE pour la clé primaire
     * @return string
     */
    private function buildKeyClause()
    {
        return implode(' AND', array_map(
                function ($key) {
                    return "$key = :$key";
                }, $this->key)
        );
    }

    /**
     * Retourne la clé sous forme de tableau associatif
     * @param $key
     * @return array
     */
    private function getKey($key)
    {
        $values = (is_array($key)) ? $key : [$key];
        return array_combine($this->key, $values);
    }

    /**
     * Formate une liste de colonnes en chaîne
     * (évite les injections SQL)
     * @param $columns
     * @return string
     */
    private function formatColumns($columns)
    {
        if (count($columns) > 0) {
            $validColumns = array_intersect(
                $this->key + $this->columns, $columns
            );
            return implode(',', $validColumns);
        } else {
            return '*';
        }
    }

    /**
     * Récupère un enregistrement à partir de sa clé
     * @param array|string $key
     * @return mixed
     * @throws TableException
     */
    public function find($key)
    {
        // Préparation de la requête
        if ($this->stmtFind === null) {
            $sql = "SELECT * FROM $this->table WHERE $this->keyClause";
            $this->stmtFind = $this->pdo->prepare($sql);
        }

        // Éxécution de la requête
        $this->stmtFind->execute($this->getKey($key));

        // Récupération des résultats
        if (! $record = $this->stmtFind->fetch(\PDO::FETCH_ASSOC)) {
            throw new TableException('No record found!');
        }

        return new $this->class($record);
    }

    /**
     * Récupère plusieurs enregistrements selon un critère d'égalité
     * @param string $column
     * @param string $value
     * @param int $limit
     * @return array
     * @throws TableException
     */
    public function where($column, $value, $limit = 1000)
    {
        // Préparation de la requête
        if (!isset($this->stmtWhere[$column]))
            $this->newWhereStatement($column);

        // Éxécution de la requête
        $this->stmtWhere[$column]->bindParam(':value', $value, \PDO::PARAM_STR, 12);
        $this->stmtWhere[$column]->bindParam(':limit', $limit, \PDO::PARAM_INT);
        $this->stmtWhere[$column]->execute();

        // Récupération des résultats
        if (! $res = $this->stmtWhere[$column]->fetchAll(\PDO::FETCH_ASSOC) ) {
            throw new TableException('No record found!');
        }

        // Instanciation des objets
        return array_map(function ($fields) {
            return new $this->class($fields);
        }, $res);
    }

    /**
     * Récupère tous les enregistrements de la table
     * (possibilité de définir les champs à récupérer)
     * @return mixed
     * @throws TableException
     */
    public function all()
    {
        // Récupération des colonnes à afficher
        $columns = $this->formatColumns(func_get_args());

        // Éxécution de la requête
        $stmt = $this->pdo->query("SELECT $columns FROM $this->table");

        // Récupération des résultats
        if (! $res = $stmt->fetchAll(\PDO::FETCH_ASSOC)) {
            throw new TableException('No record found!');
        }

        // Instanciation des objets
        return array_map(function ($fields) {
            return new $this->class($fields);
        }, $res);
    }

    /**
     * Met à jour un enregistrement en base
     * @param $obj mixed
     * @return bool
     * @throws TableException
     */
    public function update($obj)
    {
        // On teste la classe de l'objet passé en paramètre
        if (!$obj instanceof $this->class)
            throw new TableException('Invalid object class!');

        // Préparation de la requête
        if ($this->stmtUpdate === null)
            $this->newUpdateStatement();

        try {
            // Éxécution de la requête
            return $this->stmtUpdate->execute($obj->getFields());
        } catch (\PDOException $e) {
            throw new TableException("Failed update!\n" . $e->getTraceAsString());
        }
    }

    /**
     * Insère un enregistrement en base
     * et retourne le modèle associé
     * @param array $fields
     * @return bool
     * @throws TableException
     */
    public function create($fields)
    {
        // Préparation de la requête
        if ($this->stmtCreate === null)
            $this->newInsertStatement();

        try {
            // Exécution de la requête
            return $this->stmtCreate->execute($fields);
        } catch (\PDOException $e) {
            throw new TableException("Failed insert!\n" . $e->getTraceAsString());
        }
    }

    /**
     * Supprime un enregistrement en base
     * @param array|string $key
     * @return bool
     * @throws TableException
     */
    public function delete($key)
    {
        // Préparation de la requête
        if ($this->stmtDelete === null) {
            $sql = "DELETE FROM $this->table WHERE $this->keyClause";
            $this->stmtDelete = $this->pdo->prepare($sql);
        }

        try {
            // Exécution de la requête
            return $this->stmtDelete->execute($this->getKey($key));
        } catch (\PDOException $e) {
            throw new TableException("Failed deletion!\n" . $e->getTraceAsString());
        }
    }

    /**
     * Préparation d'une requête WHERE
     * @param $column
     * @throws TableException
     */
    private function newWhereStatement($column)
    {
        // Pour éviter les injections on vérifie l'existence de la colonne
        if (!in_array($column, $this->columns + $this->key))
            throw new TableException('Invalid column name!');

        $sql = "SELECT * FROM $this->table WHERE $column = :value LIMIT :limit";
        $this->stmtWhere[$column] = $this->pdo->prepare($sql);
    }

    /**
     * Préparation de la clause UPDATE
     * @return string
     */
    private function newUpdateStatement()
    {
        // Préparation de la clause
        $clause = implode(', ', array_map(
                function ($column) {
                    return "$column = :$column";
                }, $this->columns)
        );

        // Création de la requête préparée
        $sql = "UPDATE $this->table SET $clause WHERE $this->keyClause";
        $this->stmtUpdate = $this->pdo->prepare($sql);
    }

    /**
     * Préparation de la clause INSERT
     * @return string
     */
    private function newInsertStatement()
    {
        // Récupération du nom des colonnes
        $columns = (! $this->increment) ?
            $this->key + $this->columns :
            $this->columns;

        $columnNames = implode(', ', $columns);

        // Création des paramètres
        $params = implode(', ', array_map(
                function ($column) {
                    return ":$column";
                }, $columns)
        );

        // Création de la requête préparée
        $sql = "INSERT INTO $this->table ($columnNames) VALUES($params)";
        $this->stmtCreate = $this->pdo->prepare($sql);
    }
}
