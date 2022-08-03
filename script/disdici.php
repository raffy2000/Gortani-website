<?php
    $type=$_GET['type'];
    $id=$_GET['id'];

    include("CONNESSIONE.php");

    $conn = new mysqli($host, $username, $pass, $db);
    // Check connection
    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }

    // sql to delete a record
    if($type=="room"){
        $sql = "DELETE FROM prenotazioni_sale WHERE idprenotazione='".$id."'";
    }else{
        $sql = "DELETE FROM prenotazioni_automobili WHERE idprenotazione='".$id."'";
    }

    if ($conn->query($sql) === TRUE) {
        echo "Record deleted successfully";
    } else {
        echo "Error deleting record: " . $conn->error;
    }

    $conn->close();

    header("location: ../profilo.php");
    exit();
?>