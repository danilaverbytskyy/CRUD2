<?php

namespace App\controllers;

use App\models\Database;
use App\models\Registration;
use Delight\Auth\Auth;
use League\Plates\Engine;

class HomeController {
    private Engine $view;
    private Database $database;
    private Registration $registration;
    private Auth $auth;

    public function __construct(Engine $view, Database $database, Registration $registration, Auth $auth) {
        $this->view = $view;
        $this->database = $database;
        $this->registration = $registration;
        $this->auth = $auth;
    }

    public function main(): void {
        $myTasks = $this->database->all("tasks", $this->auth->getUserId());
        echo $this->view->render('tasks', ['tasks' => $myTasks]);
    }

    public function show($task_id): void {
        $myTask = $this->database->getOne('tasks', $task_id);
        echo $this->view->render('show', ['task' => $myTask]);
    }

    public function edit($task_id): void {
        $previousTask = $this->database->getOne('tasks', $task_id);
        echo $this->view->render('edit', ['previousTask' => $previousTask]);
    }

    public function update($task_id): void {
        $this->database->update('tasks', $task_id, $_POST);
        $this->show($task_id);
    }

    public function delete($task_id): void {
        $this->database->delete('tasks', $task_id);
        $this->main();
    }

    public function logOut(): void {
        $this->registration->logOut();
        $this->signUp();
    }

    public function signUp(): void {
        echo $this->view->render('signup', []);
    }

    public function logIn(): void {
        echo $this->view->render('login', []);
    }

    public function addTask(): void {
        echo $this->view->render('addTask', []);
    }

    public function storeTask(): void {
        $data = $_POST;
        $data['user_id'] = $this->auth->getUserId();
        $this->database->store('tasks', $data);
        $this->main();
    }

    public function register(): void {
        try {
            $this->registration->register();
            $this->logIn();
        } catch (\Exception $exception) {
            $this->signUp();
        }
    }

    public function enter(): void {
        try {
            $this->registration->enter();
            $this->main();
        } catch (\Exception $exception) {
            $this->logIn();
        }
    }
}

?>