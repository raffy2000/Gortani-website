<?php
    session_start();
?>


<?php
    function dammi_il_calendario($mesi, $anni){
        $targa=$_GET['t'];

        $giorniDellaSettimana = array('Domenica','Lunedì','Martedì','Mercoledì','Giovedì','Venerdì','Sabato');
        $primogm = mktime(0,0,0,$mesi, 1, $anni);
        $numerog = date('t', $primogm);
        $dateComponents = getdate($primogm);
        $nomeMese = $dateComponents['month'];
        $gionodellasettimana = $dateComponents['wday'];
        $dateToday = date('Y-m-d');

        $precMese = date('m', mktime(0,0,0,$mesi-1, 1, $anni));
        $precAnno= date('Y', mktime(0,0,0,$mesi-1, 1, $anni));
        $prosMese = date('m', mktime(0,0,0,$mesi+1, 1, $anni));
        $prosAnno = date('Y', mktime(0,0,0,$mesi+1, 1, $anni));

        $calendario = "<center><h2>$nomeMese $anni</h2>";

        $calendario.= "<a href='?month=".$precMese."&year=".$precAnno."'> <button class='btn btn-primary'>Mese Precedente</button></a> <a>   </a>";
        $calendario.= "<a href='?month=".date('m')."&year=".date('Y')."'><button class='btn btn-primary' >Mese Corrente</button> <a>   </a>" ;
        $calendario.= "<a href='?month=".$prosMese."&year=$prosAnno'><button class='btn btn-primary' > Mese Successivo</button> </a></center>";
        
        $calendario.="<br><table class='table table-bordered'>";
        $calendario.="<tr>";
        
        foreach($giorniDellaSettimana as $giorni){
            $calendario.="<th class='header'>$giorni</th>";
        }
        $calendario.="</tr><tr>";
        $currentDay =1;
        if($gionodellasettimana>0){
            for($k=0;$k<$gionodellasettimana;$k++){
                $calendario.="<td class='empty'></td>";
            }
        }    
        $mesi=str_pad($mesi,2,"0",STR_PAD_LEFT);
        while($currentDay<=$numerog){
            if($gionodellasettimana ==7){
                $gionodellasettimana=0;
                $calendario.="</tr><tr>";
            }
            $currentDayRel=str_pad($currentDay,2,"0",STR_PAD_LEFT);
            $giorni="$anni-$mesi-$currentDayRel";
            $dayName=strtolower(date('I',strtotime($giorni)));
            $oggi = "$giorni==date('Y-m-d')?'today':";
            
            $calendario.="<td class='$oggi'><h3>$currentDay</h3><div id='prenota-btn'>
            <button class='btn btn-success'>PRENOTA</button>
          </div></td>";
            //href='add_car.php?t=$targa&'
            echo "
        <div class='prenota-form-container'>
          <span id='close-prenota-form' class='fas fa-times'></span>

          <form action='' method='post'>
            <h3>PRENOTA</h3>
          
            <label for='oraInizio'><b>ORA DI INIZIO</b></label>
            <input type='time' class='box' id='oraInizio' name='oraInizio'>

            <label for='oraFine'><b>ORA DI FINE </b></label>
            <input type='time' class='box' id='oraFine' name='oraFine'>

            <input type='submit' value='Prenota' class='btn'>
        
        
          
          </form>
        </div>";
            $currentDay++;
            $gionodellasettimana ++;
        }
        if($gionodellasettimana<7){
            $remainingDays=7-$gionodellasettimana;
            for($i=0;$i<$remainingDays;$i++){
              $calendario.="<td class='empty'></td>";
            }
          }

        
          
        $calendario.="</tr></table>";
        return $calendario;
    }

?>

<!doctype html>
<html lang="it">
  <head>
    <title>Calendario Auto</title>
    <!-- Required meta tags -->
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">

    
    <link rel="stylesheet" href="https://unpkg.com/swiper@7/swiper-bundle.min.css" />

    <!-- font awesome cdn link  -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">

    <!-- custom css file link  -->
    
    <link rel="stylesheet" href="../css/stanze2.css">
    <link rel="stylesheet" href="../css/stanze.css">
    <link rel="stylesheet" href="../css/sium.css">

  </head>
    <body>
        <header class="headers">

            <div id="menu-btn" class="fas fa-bars"></div>

            <a href="https://www.gortani.com/" class="logo"> <img class= "images" src="../images/Gortani_Logo - Copia.png" alt=""/> </a>

            <nav class="navbar">
                <a href="../stanze.php">stanze</a>
                <a href="../index.php">home</a>
                <a href="../automobili.php">automobili</a>

            </nav>

            <?php
                $path = "./logout.php";
                if(!isset($_SESSION['email'])){
                    echo"<div id='login-btn'>
                        <button class='btn'>Login</button>
                        <i class='far fa-user'></i>
                    </div>";
                }else{
                    echo"<div id='login-btn'><a href='$path'>
                    <button class='btn'>Esci</button></a></div>";
                }

  
            ?>

        </header>
        <section class="home" id="home">
            <div class= "container">
                
                    
                        <?php
                            $dateComponents=getdate();
                            if(isset($_GET['month'])&&isset($_GET['year'])){
                                $mesi=$_GET['month'];
                                $anni=$_GET['year'];
                            }
                            else{
                                $mesi=$dateComponents['mon'];
                                $anni=$dateComponents['year'];
                            }


                            echo dammi_il_calendario($mesi, $anni);
                        ?>
                    
                    
                
            </div>
        </section>
        <section class="footer" id="footer">

            <div class="box-container">

            
                <div class="box">
                    <h3>quick links</h3>
                    <a href="./index.php"> <i class="fas fa-arrow-right"></i> home </a>
                    <a href=""> <i class="fas fa-arrow-right"></i>Stanze  </a>
                    <a href="#regole"> <i class="fas fa-arrow-right"></i>Automobili  </a>

                </div>

                <div class="box">
                    <h3>quick links</h3>
                    <a href="#home"> <i class="fas fa-arrow-right"></i> Calendario </a>
                </div>

                <div class="box">
                    <h3>contact info</h3>
                    <a href="#"> <i class="fas fa-phone"></i> 043394174 </a>
                    <a href="#"> <i class="fas fa-envelope"></i> assistenzatecnica@gortani.com </a>
                    <a href="http://www.gortani.com/"> <i class="fab fa-google"></i>Gortani S.R.L. </a>
                    <a href="https://www.google.it/maps/place/Gortani+S.R.L./@46.3689918,13.067313,19z/data=!4m5!3m4!1s0x477a221ea9440eef:0x8e8f09d52e163169!8m2!3d46.3691238!4d13.0672857"> <i class="fas fa-map-marker-alt"></i> Via Valli di Carnia, 9 Amaro, 33020 Friuli-Venezia Giulia, IT</a>
                </div>

                <div class="box">
                    <h3>contact info</h3>
                    <a href="https://www.facebook.com/GortaniSrl"> <i class="fab fa-facebook-f"></i> facebook </a>
                    <a href="https://instagram.com/gortanisrl?igshid=YmMyMTA2M2Y="> <i class="fab fa-instagram"></i> instagram </a>
                    <a href="https://it.linkedin.com/company/gortanisrl?original_referer=https%3A%2F%2Fwww.google.com%2F"> <i class="fab fa-linkedin"></i> linkedin </a>
                    
                </div>

            </div>

            <div class="credit"> created by Alessio Hoxhallari  </div>

        </section>





















    <!-- JS Start -->
    <script type="module" src="https://unpkg.com/ionicons@5.5.2/dist/ionicons/ionicons.esm.js"></script>
    <script nomodule src="https://unpkg.com/ionicons@5.5.2/dist/ionicons/ionicons.js"></script><script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js" integrity="sha384-JjSmVgyd0p3pXB1rRibZUAYoIIy6OrQ6VrjIEaFf/nJGzIxFDsf4x0xIM+B07jRM" crossorigin="anonymous"></script>
    <!-- Optional JavaScript -->
    <!-- jQuery first, then Popper.js, then Bootstrap JS -->
    <script src="https://code.jquery.com/jquery-3.3.1.slim.min.js" integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo" crossorigin="anonymous"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js" integrity="sha384-UO2eT0CpHqdSJQ6hJty5KVphtPhzWj9WO1clHTMGa3JDZwrnQq4sF86dIHNDz0W1" crossorigin="anonymous"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js" integrity="sha384-JjSmVgyd0p3pXB1rRibZUAYoIIy6OrQ6VrjIEaFf/nJGzIxFDsf4x0xIM+B07jRM" crossorigin="anonymous"></script>
    <script src="https://unpkg.com/swiper@7/swiper-bundle.min.js"></script>
    <script src="../js/script.js"></script>
    </body>
</html>