<?php

use App\models\QueryBuilder;

$queryBuilder = new QueryBuilder();

try {
    $queryBuilder->login();
    $_SESSION['user'] = $_POST;
}
catch (Exception $exception) {

}