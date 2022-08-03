<?php
    include("./CONNESSIONE.php");

    if(isset($_POST['email']) && isset($_POST['password'])){
        $query = "SELECT email, password FROM Dipendenti WHERE email='".$_POST['email']."'";
        echo $query;
        $risultato = mysqli_query($connessione, $query) or die("ERRORE QUERY"); 

        while($riga = mysqli_fetch_array($risultato)){
            if($riga['email']== $_POST['email'] && ($riga['password'] == $_POST['password'])){
                session_start();
                $_SESSION['email'] = $riga['email'];
                header("location: ../stanze.php");
                exit();
            }
        }
        
        header("location: ./LOGIN.php");
        exit();
    }
?>