<?php

    define('DB_SEVER', 'localhost');
    define('DB_USERNAME', 'root');
    define('DB_PASSWORD', '');
    define('DB_NAME', 'kaushik');

    $conn = mysqli_connect(DB_SEVER, DB_USERNAME, DB_PASSWORD, DB_NAME);

    if($conn === false){
        die("Error: Could not connect." . mysqli_connect_error());
    }

?>