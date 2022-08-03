<?php
  session_start();
?>





<?php
  function dammi_il_calendario($mesi, $anni, $prenotazione){
  include("./script/connessione.php");
  $query="SELECT data FROM prenotazioni_Sale";

  $risultato=mysqli_query($connessione, $query);
  $stmt=$connessione->prepare('select * from Sale');
  $prenotazioni="";
  $first_prenotazione=0;
  $i=0;
  if($stmt->execute()){
    $result=$stmt->get_result();
    if($result->num_rows>0){
      while($row = $result->fetch_assoc()){
        if($i==0){
          $first_prenotazione=$row['idSala'];
        }
        $prenotazioni.="<option value=".$row['idSala']."'>".$row['nome']."</option>";
        $i++;
      }
      $stmt->close();
    }
  }

  if($prenotazione!=0){
    $first_prenotazione = $prenotazione;
  }
    
    

  $stmt=$connessione->prepare('select * from prenotazioni_sale WHERE MONTH(data)=? AND YEAR(data)=? AND prenotazioni_sale.prenotazione_sale=?');
  $stmt->bind_param('ssi',$mesi,$anni,$first_prenotazione);
  $Sale=array();
  if($stmt->execute()){
    $result=$stmt->get_result();
    if($result->num_rows>0){
      while($row = $result->fetch_assoc()){
        $Sale[]=$row['data'];
      }
      $stmt->close();
    }
  }             
    
    
                             






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
    
  $calendario.="
    <form id='room_select_form'>
      <div class='row'>
        <div class='col-md-6 col-md-offset-3 form-group'>
          <br>
          <select class='form-control'  id='room_select' name='prenotazione'><option>SELEZIONA STANZA</option>
          ".$prenotazioni."
          </select>
          
          <input type='hidden' name='month' value='".$mesi."'>
          <input type='hidden' name='year' value='".$anni."'>
        </div>
      </div>
    </form>
  <table class='table table-bordered'>";
    
    
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
      
    if(isset($_SESSION['email'])){
      if(in_array($giorni, $Sale)){
        $calendario.="<td class='$oggi'><h3>$currentDay</h3><button class='btn btn-danger'>PRENOTATA</td>";
          
      }else{
        $calendario.="
        <td class='$oggi'>
          <h3>$currentDay</h3>
          <div id='prenota-btn'>
            <button class='btn btn-success'>PRENOTA</button>
          </div>
        </td>";
        echo "
        <div class='prenota-form-container'>
          <span id='close-prenota-form' class='fas fa-times'></span>

          <form action='/script/add_room.php' method='post'>
            <h3>PRENOTA</h3>
            <input type='text' id='nome' name='nome' placeholder='Nome Evento'>
          

            <label for='oraInizio'><b>ORA DI INIZIO</b></label>
            <input type='time' class='box' id='oraInizio' name='oraInizio'>

            <label for='oraFine'><b>ORA DI FINE </b></label>
            <input type='time' class='box' id='oraFine' name='oraFine'>

            <div class='checkbox-card'>
              <label for=''>Desideri Oggetti specifici nella stanza??</label>
              <div class='checkbox'>
                <label>
                  <input type='checkbox' class='checkme'>Si
                </label>
              </div>
              <div class='passport-box'>
                <input type='text' id='oggetti' placeholder='Quali?' class='form-control'>
              </div>
            </div>

            <input type='submit' value='Prenota' class='btn'>
        
        
          
          </form>
        </div>";
          

      }
    }else{
      $calendario.="<td class='$oggi'><h3>$currentDay</h3><button class='btn btn-warning'>DEVI ACCEDERE</button></td>";
    }
    
    $currentDay++;
    $gionodellasettimana ++;

  }
  if($prenotazione =="1'"){
    echo '<h2><br>';
    echo "<center><h1>SALA PICCOLA</h1><br></center>";
  }else if($prenotazione =="2'"){
    echo '<h2><br>';
    echo "<center><h1>SALA GRANDE</h1><br></center>";
  }else if($prenotazione =="3'"){          
    echo '<h2><br>';
    echo "<center><h1>SALA PLATINUM</h1><br></center>";
  }else if($prenotazione =="4'"){
    echo '<h2><br>';
    echo "<center><h1>SALA RIUNIONE 1</h1><br></center>";
  }else if($prenotazione =="5'"){          
    echo '<h2><br>';
    echo "<center><h1>SALA RIUNIONE 2</h1><br></center>";
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

















<!DOCTYPE html>
<html lang="it">
  <head>
    <title>Stanze</title>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">

    <link rel="stylesheet" href="https://unpkg.com/swiper@7/swiper-bundle.min.css" />

    <!-- font awesome cdn link  -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">

    <!-- custom css file link  -->
    <link rel="stylesheet" href="css/stanze2.css">
    <link rel="stylesheet" href="css/stanze.css">
    <link rel="stylesheet" href="css/sium.css">
    <!-- Bootstrap CSS -->


</head>
<body>
    
<header class="headers">
  <div id="menu-btn" class="fas fa-bars"></div>

  <a href="https://www.gortani.com/" class="logo"> <img class= "images" src="./images/Gortani_Logo - Copia.png" alt=""/> </a>

  <nav class="navbar">

      <a href="./stanze.php">stanze</a>
      <a href="./index.php">home</a>
      <a href="./automobili.php">automobili</a>
      <?php
        if(isset($_SESSION['email'])){
          echo"<a href='profilo.php'>profilo</a>";
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
  
  <div class="login-form-container">

      <span id="close-login-form" class="fas fa-times"></span>
      
      <form action="./script/login_stanze.php" method="post">
          <h3>ACCEDI</h3>
          <input type="email" placeholder="email" class="box" name="email">
          <input type="password" placeholder="password" class="box" name="password">
          
          <input type="submit" value="Login" class="btn">
          
        
          
      </form>
  </div>

</header> 

<section class="home" id="home">

<div class= "container">
  <div class="row">
    <div class="col-md-12">
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

        if(isset($_GET['prenotazione'])){
            $prenotazione=$_GET['prenotazione'];
        }
        else{
          echo '<h2><br>';
            echo '<center><h1>SALA PICCOLA<h1><br><center>';
            $prenotazione=0;
        }

        echo dammi_il_calendario($mesi, $anni, $prenotazione);
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
            <h3>quick links</h3>
            <a href="./index.php"> <i class="fas fa-arrow-right"></i> home </a>
            <a href=""> <i class="fas fa-arrow-right"></i>Stanze  </a>
            <a href="#regole"> <i class="fas fa-arrow-right"></i>Automobili  </a>
            <?php
                if(isset($_SESSION['email'])){
                    echo "<a href='./profilo.php'> <i class='fas fa-arrow-right'></i>Profilo  </a>";
                }
            ?>
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
            <a href="https://www.google.it/maps/place/Gortani+S.R.L./@46.3689918,13.067313,19z/data=!4m5!3m4!1s0x477a221ea9440eef:0x8e8f09d52e163169!8m2!3d46.3691238!4d13.0672857"> <i class="fas fa-map-marker-alt"></i> Via Valli di Carnia, 9

Amaro, 33020 Friuli-Venezia Giulia, IT</a>
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

    <script src="js/script.js"></script>
    <script>
        $("#room_select").change(function(){
        $("#room_select_form").submit();
      });

      $sis=("#room_select option[value='<?php echo $prenotazione; ?>']").attr('selected', 'selected');
      console.log($sis);
    </script>
    <script src="js/jquery-latest.min.js"></script>
<script>
	$(function(){
		$(".checkme").click(function(event) {
			var x = $(this).is(':checked');
			if (x == true) {
				$(this).parents(".checkbox-card").find('.passport-box').show();
				$(this).parents(".checkbox-card").find('.apply-box').hide();
			}
			else{
				$(this).parents(".checkbox-card").find('.passport-box').hide();
				$(this).parents(".checkbox-card").find('.apply-box').show();
			}
		});
	})
</script>
  </body>
</html>
