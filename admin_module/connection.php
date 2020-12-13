<?php
    define('DB_HOST','us-cdbr-east-02.cleardb.com');
    define("DB_USER","b06abb5474de88");
    define("DB_TOKEN","5b46e8a1");
    define("DB_TARGET","heroku_2d30a0192d19383");

    $conn = new mysqli(DB_HOST,DB_USER,DB_TOKEN,DB_TARGET);
    if ($conn->connect_errno) die("ERROR: Could not connect. Reason:" . $conn->connect_error);
?>