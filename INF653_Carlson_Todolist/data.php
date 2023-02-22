<?php
    // we will use the todolist database to connect, and just use the root
    $dsn = 'mysql:host=localhost;dbname=todolist'; 
    $username = 'root';

    //try catch block for catching any errors with connecting to the database
    try {
        $db = new PDO($dsn, $username);     
    } catch (PDOException $e) {
        $error_mess = 'Database Error: ';
        $error_mess .= $e->getMessage();
        echo $error_mess;
        exit();
    }
?>