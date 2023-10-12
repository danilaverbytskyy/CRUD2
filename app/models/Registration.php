<?php

namespace App\models;

use Aura\SqlQuery\QueryFactory;
use Delight\Auth\Auth;
use Delight\Auth\AuthError;

class Registration {
    private QueryFactory $queryFactory;
    private Auth $auth;

    public function __construct(QueryFactory $queryFactory, Auth $auth) {
        $this->queryFactory = $queryFactory;
        $this->auth = $auth;
    }

    public function logOut() : void {
        $this->auth->logOut();
        $_SESSION['message'] = 'До новых встреч!';
    }

    /**
     * @throws AuthError
     * @throws \Exception
     */
    public function register() : void {
        try {
            $userId = $this->auth->register($_POST['email'], $_POST['password'], $_POST['name'], function ($selector, $token) {
                $this->auth->confirmEmail(urldecode($selector), urldecode($token));
            });
            $_SESSION['message'] = "Вы успешно зарегистрировались";
        } catch (\Delight\Auth\InvalidEmailException $e) {
            $_SESSION['message'] = 'Некорректный email';
            throw new \Exception();
        } catch (\Delight\Auth\InvalidPasswordException $e) {
            $_SESSION['message'] = "Некорректный пароль";
            throw new \Exception();
        } catch (\Delight\Auth\UserAlreadyExistsException $e) {
            $_SESSION['message'] = "Вы уже зарегистрированы";
            throw new \Exception();
        } catch (\Delight\Auth\TooManyRequestsException $e) {
            $_SESSION['message'] = "Слишком много запросов";
            throw new \Exception();
        }
    }

    public function enter() {
        try {
            $this->auth->login($_POST['email'], $_POST['password']);
            $_SESSION['message'] = 'Добро пожаловать, ' . $this->auth->getUsername() . '!';
        }
        catch (\Delight\Auth\InvalidEmailException $e) {
            $_SESSION['message'] = 'Некорректный email';
            throw new \Exception();
        }
        catch (\Delight\Auth\InvalidPasswordException $e) {
            $_SESSION['message'] = "Некорректный пароль";
            throw new \Exception();
        }
        catch (\Delight\Auth\EmailNotVerifiedException $e) {
            $_SESSION['message'] = "Email не подтвержден";
            throw new \Exception();
        }
        catch (\Delight\Auth\TooManyRequestsException $e) {
            $_SESSION['message'] = "Слишком много запросов";
            throw new \Exception();
        }
    }
}