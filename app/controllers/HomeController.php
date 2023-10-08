<?php

namespace App\controllers;

use App\Exceptions\NotFoundDataException;
use App\models\Auth;
use App\models\QueryBuilder;
use Aura\SqlQuery\QueryFactory;
use PDO;
use League\Plates\Engine;

class HomeController {
    private QueryFactory $queryFactory;
    private Engine $view;
    private PDO $pdo;

    public function __construct(Engine $view, QueryFactory $queryFactory, PDO $pdo) {
        $this->view = $view; // new Engine('../app/views')
        $this->queryFactory = $queryFactory;
        $this->pdo = $pdo;
    }

    public function main() {
        $select = $this->queryFactory->newSelect();
        $select->cols(["*"])
            ->from('tasks'); //все поля

        // prepare the statement
        $sth = $this->pdo->prepare($select->getStatement());

        // bind the values and execute
        $sth->execute($select->getBindValues());

        // get the results back as an associative array
        $myTasks = $sth->fetchAll(PDO::FETCH_ASSOC);

        // Render a template
        echo $this->view->render('tasks', ['tasks' => $myTasks]);
    }

    public function show($task_id) {
        $select = $this->queryFactory->newSelect();
        $select->cols(["*"])
            ->from('tasks')
            ->where('task_id = :task_id')
            ->bindValue('task_id', $task_id); //use the new parameter here

        // prepare the statement
        $sth = $this->pdo->prepare($select->getStatement());

        // bind the values and execute
        $sth->execute($select->getBindValues());

        // get the results back as an associative array
        $myTask = $sth->fetch(PDO::FETCH_ASSOC);

        // Render a template
        echo $this->view->render('show', ['task' => $myTask]);
    }
}