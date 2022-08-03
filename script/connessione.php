<?php
    $host = "127.0.0.1";
    $username = "root";
    $pass = "";
    $db = "DbGortani";

    $connessione = mysqli_connect($host, $username, $pass, $db) or die("Errore connessione" . mysqli_error($connessione));
?>
