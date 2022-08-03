<?php session_start(); ?>

<!DOCTYPE html>
<html lang="it">
<head>
    <title>Home</title>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    
    <link rel="stylesheet" href="https://unpkg.com/swiper@7/swiper-bundle.min.css" />

    <!-- font awesome cdn link  -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">

    <!-- custom css file link  -->
    <link rel="stylesheet" href="./css/style.css">
    <link rel="stylesheet" href="./css/index.css">


</head>
<body>
    
<header class="header">

    <div id="menu-btn" class="fas fa-bars"></div>

    <a href="https://www.gortani.com/" class="logo"> <img class= "images" src="./images/Gortani_Logo - Copia.png" alt=""/> </a>

    <nav class="navbar">
        <a href="./stanze.php">stanze</a>
        <a href="./index.php">home</a>
        <a href="./automobili.php">automobili</a>
        <?php
            if(!isset($_SESSION['email'])){
                header("Location: index.php");
            }
        ?>

    </nav>

    <?php
    $path = "./script/logout.php";
    if(!isset($_SESSION['email'])){
      echo"<div id='login-btn'>
        <button class='btn'>Login</button>
        <i class='far fa-user'></i>
      </div>";
    }else{
        echo"<div id='login-btn'><a href='$path'>
        <button class='btn'>Esci</button>
    </a></div>";
      }

  
  ?>

</header> 


<div class="login-form-container">

    <span id="close-login-form" class="fas fa-times"></span>

    <form action="./script/login.php" method="post">
        <h3>ACCEDI</h3>
        <input type="email" placeholder="email" class="box" name="email">
        <input type="password" placeholder="password" class="box" name="password">
        
        <input type="submit" value="login" class="btn">
        
       
        
    </form>
</div>

<section class="home" id="home">
    <h3>Benvenuto <br><p style="font-size: 30px;"><?php print($_SESSION['email']); ?></p><h3>
    <div class="main">
        <?php
            include("./script/CONNESSIONE.php");

            $conn = new mysqli($host, $username, $pass, $db);
            // Check connection
            if ($conn->connect_error) {
                die("Connection failed: " . $conn->connect_error);
            }
            $email=$_SESSION['email'];
            $sql = "SELECT idDipendenti FROM dipendenti WHERE email='".$email."'";
            $result = $conn->query($sql);
            
            if ($result->num_rows > 0) {
                // output data of each row
                while($row = $result->fetch_assoc()) {
                    $idProfile=$row["idDipendenti"];
                }
            }
            $conn->close();
        ?>
        <div class="event">
            <div class="room">
                <h3 style="font-size: 30px;">Prenotazioni stanze</h3>
                <?php
                    $conn = new mysqli($host, $username, $pass, $db);
                    // Check connection
                    if ($conn->connect_error) {
                      die("Connection failed: " . $conn->connect_error);
                    }
                    
                    $sql = "SELECT * FROM prenotazioni_sale WHERE prenotazione_dipendenti='".$idProfile."'";
                    $result = $conn->query($sql);
                    
                    if ($result->num_rows > 0) {
                      // output data of each row
                      while($row = $result->fetch_assoc()) {
                        echo "<div class='card'>
                            <div class='card-header'>
                                <p style='font-size: 15px;'>".$row["nome"]."</p>
                            </div>
                            <div class='card-container'>
                                <p style='font-size: 15px;'>Data: ".$row["data"]."</p>
                                <p style='font-size: 15px;'>Ora inizio: ".$row["oraInizio"]."</p>
                                <p style='font-size: 15px;'>Ora fine: ".$row["oraFine"]."</p>
                            </div>";
                            if($row["data"]>date("Y-m-d")){
                                echo "<p style='font-size: 15px;'><button style='border-radius: 25px;' href='./script/
                                disdici.php?type=room&id=".$row["idprenotazione"]."
                                '>Disdici</button></p> ";
                            }
                            echo "</div>";/* non va il button ma lo script dovrebbe andare nel chill */
                      }
                    } else {
                      echo "<h3 style='font-size: 20px;'>Nessuna prenotazione</h3>";
                    }
                    $conn->close();
                ?>
            </div>
            <div class="car">
                <h3 style="font-size: 30px;">Prenotazioni automobili</h3>
                <?php
                    $conn = new mysqli($host, $username, $pass, $db);
                    // Check connection
                    if ($conn->connect_error) {
                      die("Connection failed: " . $conn->connect_error);
                    }
                    
                    $sql = "SELECT * FROM prenotazioni_automobili WHERE prenotazione_dipendente='".$idProfile."'";
                    $result = $conn->query($sql);
                    
                    if ($result->num_rows > 0) {
                      // output data of each row
                      while($row = $result->fetch_assoc()) {
                        echo "<div class='card'>
                            <div class='card-header'>
                                <p style='font-size: 15px;'>".$row["nome"]."</p>
                            </div>
                            <div class='card-container'>
                                <p style='font-size: 15px;'>Data: ".$row["data"]."</p>
                                <p style='font-size: 15px;'>Ora inizio: ".$row["oraInizio"]."</p>
                                <p style='font-size: 15px;'>Ora fine: ".$row["oraFine"]."</p>
                            </div>";
                            if($row["data"]>date("Y-m-d")){
                                echo "<p style='font-size: 15px;'><button style='border-radius: 25px;' href='./script/
                                disdici.php?type=car&id=".$row["idprenotazione"]."
                                '>Disdici</button></p> ";
                            }
                            echo "</div>";/* non va il button ma lo script dovrebbe andare nel chill */
                      }
                    } else {
                      echo "<h3 style='font-size: 20px;'>Nessuna prenotazione</h3>";
                    }
                    $conn->close();
                ?>
            </div>
        </div>
    </div>

</section>
    <!-- Main WebSite -->
    
      

    <!-- Footer -->
    <section class="footer" id="footer">
    <div class="box-container">

        
        <div class="box">
            <h3>Link Veloci</h3>
            <a href="#home"> <i class="fas fa-arrow-right"></i> home </a>
            <a href="./stanze.php"> <i class="fas fa-arrow-right"></i>Stanze  </a>
            <a href="./automobili.php"> <i class="fas fa-arrow-right"></i>Automobili  </a>
            <?php
                if(isset($_SESSION['email'])){
                    echo "<a href='./profilo.php'> <i class='fas fa-arrow-right'></i>Profilo  </a>";
                }
            ?>
        </div>

        

        <div class="box">
            <h3>Contatti</h3>
            <a href="tel:043394174"> <i class="fas fa-phone"></i> 043394174 </a>
            <a href="mailto:assistenzatecnica@gortani.com"> <i class="fas fa-envelope"></i> assistenzatecnica@gortani.com </a>
            <a href="http://www.gortani.com/"> <i class="fab fa-google"></i>Gortani S.R.L. </a>
            <a href="https://www.google.it/maps/place/Gortani+S.R.L./@46.3689918,13.067313,19z/data=!4m5!3m4!1s0x477a221ea9440eef:0x8e8f09d52e163169!8m2!3d46.3691238!4d13.0672857"> <i class="fas fa-map-marker-alt"></i> Via Valli di Carnia, 9

        Amaro, 33020 Friuli-Venezia Giulia, IT</a>
        </div>

        <div class="box">
            <h3>Social</h3>
            <a href="https://www.facebook.com/GortaniSrl"> <i class="fab fa-facebook-f"></i> facebook </a>
            <a href="https://instagram.com/gortanisrl?igshid=YmMyMTA2M2Y="> <i class="fab fa-instagram"></i> instagram </a>
            <a href="https://it.linkedin.com/company/gortanisrl?original_referer=https%3A%2F%2Fwww.google.com%2F"> <i class="fab fa-linkedin"></i> linkedin </a>
            
        </div>

    </div>

    <div class="credit"> created by Alessio Hoxhallari  </div>

</section>

    <script src="https://unpkg.com/swiper@7/swiper-bundle.min.js"></script>

    <script src="js/script.js"></script>

    <script type="module" src="https://unpkg.com/ionicons@5.5.2/dist/ionicons/ionicons.esm.js"></script>
    <script nomodule src="https://unpkg.com/ionicons@5.5.2/dist/ionicons/ionicons.js"></script>

  </body>
</html>
