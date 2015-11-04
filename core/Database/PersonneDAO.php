<?php

namespace Core\Database;

/**
 * Class PersonneDAO
 * DAO de la table annuaire
 */
class PersonneDAO extends DAO
{
    protected $table = 'annuaire';    
    protected $class = 'Personne';
    protected $key = 'login';

    /**
     * Récupère toutes les personnes dont le nom est conforme au motif
     * @param $nom : motif du nom
     * @return mixed
     */
    public function getAllByNom($nom)
    {
        $stmt = $this->pdo->query('SELECT * FROM ' . $this->table . ' WHERE nom LIKE "' . $nom . '%" ');
        return $stmt->fetchAll(PDO::FETCH_CLASS, $this->class);
    }
}