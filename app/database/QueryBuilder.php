<?php

namespace App\App\Database;

use \PDO;

class QueryBuilder
{
    protected PDO $db;

    public function __construct(PDO $db)
    {
        $this->db = $db;
    }

    /**
     * @param string $query
     * @param string|null $fetchClass
     * @return array
     */
    public function query(string $query, string $fetchClass=null): array
    {
        $query = $this->db->prepare($query);
        $query->execute();

        if ($fetchClass) {
            return $query->fetchAll(PDO::FETCH_CLASS, $fetchClass);
        }

        return $query->fetchAll(PDO::FETCH_OBJ);
    }

    /**
     * @param string $table
     * @param array $parameters
     * @return void
     */
    public function insert(string $table, array $parameters): void
    {
        $sql = sprintf(
                "INSERT INTO %s (%s) VALUES (%s)",
                $table,
                implode(', ', array_keys($parameters)),
                ':' . implode(', :', array_keys($parameters))
        );
        $query = $this->db->prepare($sql);
        $query->execute($parameters);
    }

    /**
     * @param string $table
     * @param array $parameters
     * @return void
     */
    public function update(string $table, array $parameters): void
    {
        $params = array();
        $id = $parameters['id'];
        unset($parameters['id']);
        foreach ($parameters as $key => $val) {
            $params[] = "$key='$val'";
        }
        $sql = "UPDATE {$table} SET ".implode(',', $params)." WHERE id={$id}";
        $query = $this->db->prepare($sql);
        $query->execute($parameters);
    }
}
