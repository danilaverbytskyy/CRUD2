<?php

namespace App\models;

use Aura\SqlQuery\QueryFactory;
use PDO;
use \Delight\Auth\Auth;

class Database {
    private QueryFactory $queryFactory;
    private PDO $pdo;
    private Auth $auth;

    public function __construct(QueryFactory $queryFactory, PDO $pdo, Auth $auth) {

        $this->queryFactory = $queryFactory;
        $this->pdo = $pdo;
        $this->auth = $auth;
    }

    public function all(string $table, int $id) : array {
        $select = $this->queryFactory->newSelect();
        $select->cols(["*"])
            ->from($table)
            ->where('user_id = :user_id')
            ->bindValue('user_id', $id);
        $sth = $this->pdo->prepare($select->getStatement());
        $sth->execute($select->getBindValues());
        return $sth->fetchAll(PDO::FETCH_ASSOC);
    }

    public function getOne(string $table, int $id) : array{
        $select = $this->queryFactory->newSelect();
        $select->cols(["*"])
            ->from($table)
            ->where('task_id = :task_id')
            ->bindValue('task_id', $id);
        $sth = $this->pdo->prepare($select->getStatement());
        $sth->execute($select->getBindValues());
        return $sth->fetch(PDO::FETCH_ASSOC);
    }

    public function update(string $table, int $id, array $newData) : void {
        $update = $this->queryFactory->newUpdate();
        $update->table($table)
            ->cols(array_keys($newData))
            ->where('task_id = :task_id')
            ->bindValue('task_id', $id);
        foreach ($newData as $key => $val) {
            $update->bindValues([$key => $val]);
        }
        $sth = $this->pdo->prepare($update->getStatement());
        $sth->execute($update->getBindValues());
    }

    public function delete(string $table, int $id) : void {
        $delete = $this->queryFactory->newDelete();
        $delete
            ->from($table)
            ->where('task_id = :task_id')
            ->bindValue('task_id', $id);
        $sth = $this->pdo->prepare($delete->getStatement());
        $sth->execute($delete->getBindValues());
    }

    public function store(string $table, array $data) : void {
        $cols = array_keys($data);
        $bindValues = [];
        foreach ($cols as $col) {
            $bindValues[$col] = $data[$col];
        }
        $insert = $this->queryFactory->newInsert();
        $insert
            ->into($table)
            ->cols($cols)
            ->bindValues($bindValues);
        $sth = $this->pdo->prepare($insert->getStatement());
        $sth->execute($insert->getBindValues());
    }
}