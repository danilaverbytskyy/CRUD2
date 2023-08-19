<?php

namespace App\models;

use App\Exceptions\AlreadyLoggedInException;
use App\Exceptions\InvalidSymbolsException;

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

    public function login(string $table, array $data) : bool {
        $data = $this->secureInput($data);
        if ($this->isIncludeInvalidSymbols($data)) {
            throw new InvalidSymbolsException();
        }
        $data = $this->queryBuilder->convertToDatabaseFormat($data);
        return $this->queryBuilder->isInTable($table, $data);
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

    private function secureInput(array $data): array {
        foreach ($data as $element) {
            $element = htmlspecialchars(trim($element));
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