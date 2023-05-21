<?php

    const routes = [
        '/' => [
            'REQUEST_METHOD' => 'GET',
            'namespace' => 'Views',
            'class' => 'Forms', 
            'method' => 'index'
        ],

        '/storeItem' => [
            'REQUEST_METHOD' => 'POST',
            'namespace' => 'Controllers',
            'class' => 'ItemController', 
            'method' => 'store'
        ],

        '/showItem' => [
            'REQUEST_METHOD' => 'POST',
            'namespace' => 'Controllers',
            'class' => 'ItemController', 
            'method' => 'show'
        ],

        '/updateItem' => [
            'REQUEST_METHOD' => 'POST',
            'namespace' => 'Controllers',
            'class' => 'ItemController', 
            'method' => 'update'
        ],

        '/deleteItem' => [
            'REQUEST_METHOD' => 'POST',
            'namespace' => 'Controllers',
            'class' => 'ItemController', 
            'method' => 'delete'
        ],

        '/migrateAndSeed' => [
            'REQUEST_METHOD' => 'POST',
            'namespace' => 'DB',
            'class' => 'MigrateAndSeedClass', 
            'method' => 'migrateAndSeed'
        ],

        '/runTests' => [
            'REQUEST_METHOD' => 'GET',
            'namespace' => 'Tests',
            'class' => 'Tests', 
            'method' => 'runTests'
        ],
    
    ];