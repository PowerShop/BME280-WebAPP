<?php
require dirname(__FILE__) . '/_config.php';
require dirname(__FILE__) . '/_func.php';
require dirname(__FILE__) . '/_line.php';
require dirname(__FILE__) . '/_user.php';

// SQL
$api = (object) array(
    'sql' => new PDO('mysql:host=' . $config['host'] . '; dbname=' . $config['database'] . ';', $config['user'], $config['password']),
    'line' => new Line(),
    'user' => new User()
);

// Execute utf8
$api->sql->exec("set names utf8");
