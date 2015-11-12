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
     * Clauses
     */
    protected $keyClause;
    protected $updateClause;

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
        $this->updateClause = $this->buildUpdateClause();
    }

    /**
     * Retrouve les noms des champs de la table sans les clés
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
     * Construit la clause UPDATE
     * @return string
     */
    private function buildUpdateClause()
    {
        return implode(',', array_map(
                function ($column) {
                    return "$column = :$column";
                }, $this->columns)
        );
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
     * Récupère un enregistrement de la table
     * @param array|string $key
     * @return mixed
     */
    public function find($key)
    {
        // Préparation de la requête
        if ($this->stmtFind === null) {
            $sql = "SELECT * FROM $this->table WHERE $this->keyClause";
            $this->stmtFind = $this->pdo->prepare($sql);
        }

        // Formatage de la clé primaire
        $key = (is_array($key)) ? $key : [$key];
        $key = array_combine($this->key, $key);

        // Éxécution de la requête et récupération des résultats
        $this->stmtFind->execute($key);
        $this->stmtFind->setFetchMode(\PDO::FETCH_CLASS, $this->class);
        return $this->stmtFind->fetch();
    }

    /**
     * Récupère plusieurs enregistrement selon un critère d'égalité
     * @param string $column
     * @param string $value
     * @param int $limit
     * @return array
     * @throws TableException
     */
    public function where($column, $value, $limit = 1000)
    {
        // Préparation de la requête
        if (! isset($this->stmtWhere[$column])) {
            // Pour éviter les injections on vérifie l'existence de la colonne
            if (! in_array($column, array_merge($this->columns, $this->key)))
                throw new TableException('Invalid column name!');

            $sql = "SELECT * FROM $this->table WHERE $column = :value LIMIT :limit";
            $this->stmtWhere[$column] = $this->pdo->prepare($sql);
        }

        // Éxécution de la requête et récupération des résultats
        $this->stmtWhere[$column]->bindParam(':value', $value, \PDO::PARAM_STR, 12);
        $this->stmtWhere[$column]->bindParam(':limit', $limit, \PDO::PARAM_INT);
        $this->stmtWhere[$column]->execute();
        return $this->stmtWhere[$column]->fetchAll(\PDO::FETCH_CLASS, $this->class);
    }

    /**
     * Récupère tous les enregistrements de la table
     * (Possibilité de définir les champs à récupérer)
     * @return mixed
     */
    public function all()
    {
        // Si colonnes explicites
        if (func_num_args() > 0) {
            // Récupération des colonnes à afficher
            $columns = implode(',', array_intersect(
                array_merge($this->key, $this->columns), func_get_args())
            );
        } else {
            // Sinon on récupère tout
            $columns = '*';
        }

        $stmt = $this->pdo->query("SELECT $columns FROM $this->table");
        return $stmt->fetchAll(\PDO::FETCH_CLASS, $this->class);
    }

    /**
     * Met à jour un enregistrement en base
     * @param $obj mixed
     * @throws TableException
     */
    public function update($obj)
    {
        // On teste la classe de l'objet passé en paramètre
        if (!$obj instanceof $this->class)
            throw new TableException('Invalid object class!');

        // Récupération des champs de l'objet
        $fields = $obj->getFields();

        // Préparation de la requête
        if ($this->stmtUpdate === null) {
            $sql = "UPDATE $this->table SET $this->updateClause WHERE $this->keyClause";
            $this->stmtUpdate = $this->pdo->prepare($sql);
        }

        // Éxécution de la requête
        if ($this->stmtUpdate->execute($fields) < 0)
            throw new TableException();
    }

    /**
     * Insère un enregistrement en base et retourne le modèle associé
     * @param array $fields
     * @return Object
     * @throws TableException
     */
    public function create($fields)
    {
        // Suppression des clés si auto incrément
        if (! $this->increment) {
            foreach($this->key as $key) {
                unset($fields[$key]);
            }
        }

        // Préparation de la requête
        if ($this->stmtCreate === null) {
            $params = implode(',', array_fill(0, count($fields), '?'));
            $sql = "INSERT INTO $this->table VALUES($params)";
            $this->stmtCreate = $this->pdo->prepare($sql);
        }

        // Exécution de la requête
        if ($this->stmtCreate->execute($fields) < 0)
            throw new TableException('Insert fails!');

        // Récupération de la clé auto incrémentée
        if ($this->increment) {
            $fields[$this->key[0]] = $this->pdo->lastInsertId();
        }

        return new $this->class($fields);
    }

    /**
     * Supprime un enregistrement en base
     * @param array|string $key
     * @throws TableException
     */
    public function delete($key)
    {
        // Préparation de la requête
        if ($this->stmtDelete === null) {
            $sql = "DELETE FROM $this->table WHERE $this->keyClause";
            $this->stmtDelete = $this->pdo->prepare($sql);
        }

        // Formatage de la clé primaire
        $key = (is_array($key)) ? $key : [$key];
        $key = array_combine($this->key, $key);

        // Exécution de la requête
        if ($this->stmtDelete->execute($key) < 0)
            throw new TableException('Deletion fails!');
    }
}
