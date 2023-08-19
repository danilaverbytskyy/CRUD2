<?php

namespace App\models;

use App\Exceptions\NotFoundByIdException;
use App\Exceptions\NotFoundDataException;
use PDO;

class QueryBuilder {
    private PDO $pdo;

    public function __construct() {
        $this->pdo = new PDO("mysql:host=localhost; dbname=CRUD", "root", "");
    }

    public function storeOne(string $table, array $data): void {
        $keys = array_keys($data);
        $stringOfKeys = implode(', ', $keys);
        $placeholders = ':' . implode(', :', $keys);
        $sql = "INSERT INTO $table($stringOfKeys) VALUES($placeholders)";
        $statement = $this->pdo->prepare($sql);
        $statement->execute($data);
    }

    public function deleteById(string $table, int $id): void {
        $table_id = substr($table, 0, strlen($table) - 1);
        $table_id .= '_id';
        $sql = "DELETE FROM $table WHERE $table_id=:id";
        $statement = $this->pdo->prepare($sql);
        $statement->execute([
            'id' => $id
        ]);
    }

    /**
     * @throws NotFoundDataException
     */
    function getAll(string $table) {
        $sql = "SELECT * FROM $table";
        $statement = $this->pdo->prepare($sql);
        $statement->execute();
        $results = $statement->fetchAll(PDO::FETCH_ASSOC);
        if($results === false) {
            throw new NotFoundDataException();
        }
        return $results;
    }

    /**
     * @throws NotFoundByIdException
     */
    public function getOneById(string $table, int $id): array {
        $table_id = substr($table, 0, strlen($table) - 1);
        $table_id .= '_id';
        $sql = "SELECT * FROM $table WHERE $table_id=:id";
        $statement = $this->pdo->prepare($sql);
        $statement->execute([
            'id' => $id
        ]);
        $result = $statement->fetch();
        if ($result === null) {
            throw new NotFoundByIdException();
        }
        return $result;
    }

    /**
     * @throws NotFoundDataException
     */
    public function getOne(string $table, array $data): array {
        $keys = array_keys($data);
        $condition = "";
        foreach ($keys as $key) {
            $condition .= "$key=:$key AND ";
        }
        $condition = rtrim($condition, " AND");
        $sql = "SELECT * FROM $table WHERE $condition";
        $statement = $this->pdo->prepare($sql);
        $statement->execute($data);
        $result = $statement->fetch();
        if ($result === false) {
            throw new NotFoundDataException();
        }
        return $result;
    }

    public function isInTable(string $table, array $data): bool {
        $data = $this->convertToDatabaseFormat($data);
        try {
            $this->getOne($table, $data);
        } catch (NotFoundDataException $e) {
            return false;
        }
        return true;
    }

    public function convertToDatabaseFormat(array $data): array {
        foreach ($data as $key => $value) {
            if ($key === 'password') {
                continue;
            }
            $value = mb_strtoupper($value);
        }
        return $data;
    }
}