<?php

namespace App\models;

use App\Exceptions\AlreadyLoggedInException;
use App\Exceptions\InvalidSymbolsException;
use App\Exceptions\NotFoundDataException;
use App\Exceptions\WrongPasswordException;

class Auth {
    private QueryBuilder $queryBuilder;

    public function __construct(QueryBuilder $queryBuilder) {
        $this->queryBuilder = $queryBuilder;
    }
    public function redirect(string $path) : void {
        header('Location: ' . $path);
    }

    /**
     * @throws InvalidSymbolsException
     * @throws AlreadyLoggedInException
     */
    public function register(string $table, array $data): void {
        $data = $this->secureInput($data);
        if ($this->isIncludeInvalidSymbols($data)) {
            throw new InvalidSymbolsException();
        }
        $data = $this->queryBuilder->convertToDatabaseFormat($data);
        $userInformation = [
            'name' => $data['name'],
            'email' => $data['email']
        ];
        if ($this->queryBuilder->isInTable($table, $userInformation)) {
            throw new AlreadyLoggedInException();
        }
        $this->queryBuilder->storeOne($table, $data);
    }

    /**
     * @throws InvalidSymbolsException
     * @throws NotFoundDataException
     * @throws WrongPasswordException
     */
    public function login(string $table, array $data) : void {
        $data = $this->secureInput($data);
        if ($this->isIncludeInvalidSymbols($data)) {
            throw new InvalidSymbolsException();
        }
        $data = $this->queryBuilder->convertToDatabaseFormat($data);
        if ($this->queryBuilder->isInTable($table, $data) === false) {
            $userInformation = [
                'email' => $data['email'],
            ];
            if($this->queryBuilder->isInTable($table, $userInformation)) {
                throw new WrongPasswordException();
            }
            throw new NotFoundDataException();
        }
    }

    public function logout() : void {
        if(isset($_SESSION['user'])) {
            unset($_SESSION['user']);
        }
    }

    public function getFullName($data) : array {
        if(isset($data['name']) && isset($data['surname'])) {
            return [
                'name' => $data['name'],
                'surname' => $data['surname']
            ];
        }
        throw new \Exception("cannot get full name");
    }

    public function secureInput(array $data): array {
        foreach ($data as $element) {
            $element = htmlspecialchars(trim($element));
        }
        if(isset($data['password'])) {
            $data['password'] = sha1($data['password']);
        }
        return $data;
    }

    private function isIncludeInvalidSymbols(array $data): bool {
        $invalidSymbols = "?#<>%^/@ ";
        foreach ($data as $element) {
            if (strpbrk($element, $invalidSymbols) !== false) {
                return true;
            }
        }
        return false;
    }
}
?>