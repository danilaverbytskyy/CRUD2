<?php

namespace App\controllers;

use Aura\SqlQuery\QueryFactory;
use Delight\Auth\Auth;
use Delight\Auth\AuthError;
use PDO;
use League\Plates\Engine;

class HomeController {
    private QueryFactory $queryFactory;
    private Engine $view;
    private PDO $pdo;
    private Auth $auth;

    public function __construct(Engine $view, QueryFactory $queryFactory, PDO $pdo, Auth $auth) {
        $this->view = $view; // new Engine('../app/views')
        $this->queryFactory = $queryFactory;
        $this->pdo = $pdo;
        $this->auth = $auth;
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

    public function edit($task_id) {
        $select = $this->queryFactory->newSelect();
        $select->cols(["*"])
            ->from('tasks')
            ->where('task_id = :task_id')
            ->bindValue('task_id', $task_id);
        $sth = $this->pdo->prepare($select->getStatement());
        $sth->execute($select->getBindValues());
        $previousTask = $sth->fetch(PDO::FETCH_ASSOC);
        echo $this->view->render('edit', ['previousTask' => $previousTask]);
    }

    public function update($task_id) {
        $data = $_POST;
        $update = $this->queryFactory->newUpdate();
        $update->table('tasks')
            ->cols(array_keys($data))
            ->where('task_id = :task_id')
            ->bindValue('task_id', $task_id);
        foreach ($data as $key => $val) {
            $update->bindValues([$key => $val]);
        }
        $sth = $this->pdo->prepare($update->getStatement());
        $sth->execute($update->getBindValues());
        $this->show($task_id);
    }

    public function delete($task_id) {
        $delete = $this->queryFactory->newDelete();
        $delete
            ->from('tasks')
            ->where('task_id = :task_id')
            ->bindValue('task_id', $task_id);
        $sth = $this->pdo->prepare($delete->getStatement());
        $sth->execute($delete->getBindValues());
        $this->main();
    }

    public function logOut() {
        try {
            $this->auth->logOut();
        } catch (AuthError $e) {
        }
        $_SESSION['message'] = 'До новых встреч!';
        $this->signUp();
    }

    public function signUp() {
        echo $this->view->render('signup', []);
    }

    public function logIn() {
        echo $this->view->render('login', []);
    }

    public function addTask() {
        echo $this->view->render('addTask', []);
    }

    public function storeTask() {
        $insert = $this->queryFactory->newInsert();
        $insert
            ->into('tasks') // INTO this table
            ->cols([ // bind values as "(col) VALUES (:col)"
                'user_id',
                'title',
                'content'
            ])
            ->bindValues([ // bind these values
                'user_id' => $this->auth->getUserId(),
                'title' => $_POST['title'],
                'content' => $_POST['content']
            ]);

        // prepare the statement
        $sth = $this->pdo->prepare($insert->getStatement());

        // bind the values and execute
        $sth->execute($insert->getBindValues());

        $this->main();
    }

    public function register() {
        try {
            $userId = $this->auth->register($_POST['email'], $_POST['password'], $_POST['name'], function ($selector, $token) {
                $this->auth->confirmEmail(urldecode($selector), urldecode($token));
            });
            $_SESSION['message'] = "Вы успешно зарегистрировались";
            $this->logIn();
        } catch (\Delight\Auth\InvalidEmailException $e) {
            $_SESSION['message'] = 'Некорректный email';
            $this->signUp();
        } catch (\Delight\Auth\InvalidPasswordException $e) {
            $_SESSION['message'] = "Некорректный пароль";
            $this->signUp();
        } catch (\Delight\Auth\UserAlreadyExistsException $e) {
            $_SESSION['message'] = "Вы уже зарегистрированы";
            $this->signUp();
        } catch (\Delight\Auth\TooManyRequestsException $e) {
            $_SESSION['message'] = "Слишком много запросов";
            $this->signUp();
        }
    }

    public function enter() {
        try {
            $this->auth->login($_POST['email'], $_POST['password']);
            $_SESSION['user'] = [
                'user_id' => $this->auth->getUserId(),
                'email' => $this->auth->getEmail(),
            ];
            $_SESSION['message'] = 'Welcome, ' . $this->auth->getUsername() . '!';
            $this->main();
        }
        catch (\Delight\Auth\InvalidEmailException $e) {
            $_SESSION['message'] = 'Некорректный email';
            $this->logIn();
        }
        catch (\Delight\Auth\InvalidPasswordException $e) {
            $_SESSION['message'] = 'Неверный пароль';
            $this->logIn();
        }
        catch (\Delight\Auth\EmailNotVerifiedException $e) {
            $_SESSION['message'] = 'Email не подтвержден';
            $this->logIn();
        }
        catch (\Delight\Auth\TooManyRequestsException $e) {
            $_SESSION['message'] = 'Слишком много запросов';
            $this->logIn();
        }
    }
}
?>