<?php

namespace App\controllers;

use App\models\QueryBuilder;

class HomeController {
    private QueryBuilder $builder;

    public function __construct(QueryBuilder $builder) {
        //$this->db = $db;
        $this->builder = $builder;
    }

    public static function main() {
        // Create new Plates instance
        $templates = new \League\Plates\Engine('/path/to/templates');

// Render a template
        echo $templates->render('profile', ['name' => 'Jonathan']);
    }
}