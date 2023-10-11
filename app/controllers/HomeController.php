<?php

namespace App\controllers;

use App\models\Database;
use Aura\SqlQuery\QueryFactory;
use Delight\Auth\Auth;
use PDO;
use League\Plates\Engine;

class HomeController {
    private Engine $view;
    private Auth $auth;
    private Database $database;

    public function __construct(Engine $view, Database $database, Auth $auth) {
        $this->view = $view;
        $this->auth = $auth;
        $this->database = $database;
    }

    public function main() : void {
        $myTasks = $this->database->all("tasks", $this->auth->getUserId());
        echo $this->view->render('tasks', ['tasks' => $myTasks]);
    }

    public function show($task_id) : void {
        $myTask = $this->database->getOne('tasks', $task_id);
        echo $this->view->render('show', ['task' => $myTask]);
    }

    public function edit($task_id) : void {
        $previousTask = $this->database->getOne('tasks', $task_id);
        echo $this->view->render('edit', ['previousTask' => $previousTask]);
    }

    public function update($task_id) : void {
        $this->database->update('tasks', $task_id, $_POST);
        $this->show($task_id);
    }

    public function delete($task_id) : void {
        $this->database->delete('tasks', $task_id);
        $this->main();
    }

    public function logOut() : void {
        $this->auth->logOut();
        $_SESSION['message'] = 'До новых встреч!';
        $this->signUp();
    }

    public function signUp() : void {
        echo $this->view->render('signup', []);
    }

    public function logIn() : void {
        echo $this->view->render('login', []);
    }

    public function addTask() : void {
        echo $this->view->render('addTask', []);
    }

    public function storeTask() : void {
        $data = $_POST;
        $data['user_id'] = $this->auth->getUserId();
        $this->database->store('tasks', $data);
        $this->main();
    }

    public function register() : void {
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

    public function enter() : void {
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