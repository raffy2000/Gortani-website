<?php
    session_start();
?>

<!DOCTYPE html>
<html lang="it">
    <head>
        <title>Automobili</title>
        <meta charset="UTF-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1.0"> 
        <link rel="stylesheet" href="https://unpkg.com/swiper@7/swiper-bundle.min.css" />
        <!-- font awesome cdn link  -->
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">
        <!-- custom css file link  -->
        <link rel="stylesheet" href="css/style.css">
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
                    if(isset($_SESSION['email'])){
                        echo"<a href='profilo.php'>profilo</a>";
                    }
                ?>
            </nav>
            <?php
                $path = "./script/logout.php";
                
                if(!isset($_SESSION['email'])){
                    echo "<div id='login-btn'>
                        <button class='btn'>Login</button>
                        <i class='far fa-user'></i>
                    </div>";
                }
                else{
                    echo "<div id='login-btn'>
                        <a href='$path'>
                            <button class='btn'>Esci</button>
                        </a>
                    </div>";
                }
            ?>
        </header> 
        <div class="login-form-container">
            <span id="close-login-form" class="fas fa-times"></span>

            <form action="./script/login_auto.php" method="post">
                <h3>ACCEDI</h3>
                <input type="email" placeholder="email" class="box" name="email">
                <input type="password" placeholder="password" class="box" name="password">
                <input type="submit" value="login" class="btn">
            </form>
        </div>
        <section class="home" id="home">
            <h3 data-speed="-2" class="home-parallax">Prenota</h3>
            <img data-speed="5" class="home-parallax" src="images/home-img.png" alt="">
            <a data-speed="7" href="#vehicles" class="btn home-parallax">Macchine</a>
        </section>
        <section class="icons-container" id="regole">
            <h1></h1>
            <h1></h1>
            <h1 class="heading"> Regole  </h1>
            <h1></h1>
            <h1></h1>
            <div class="icons">
                <i class="fa-solid fa-square-parking"></i>
                <div class="content">
                    <h3>Parcheggio</h3>
                    <p>Parcheggiarla nel posto designato</p>
                </div>
            </div>
            <div class="icons">
                <i class="fa-solid fa-shower"></i>
                <div class="content">
                    <h3>Pulizia</h3>
                    <p>La macchina deve rimanere pulità</p>
                </div>
            </div>
            <div class="icons">
                <i class="fa-solid fa-road"></i>
                <div class="content">
            <h3>Codice della strada</h3>
            <p>E' tassativo il rispetto delle regole della strada</p>
        </div>
    </div>

    <div class="icons">
    <i class="fa-solid fa-handcuffs"></i>
        <div class="content">
            <h3>Multe</h3>
            <p>Eventuali multe sono a carico dell'utilizzatore</p>
        </div>
    </div>

    <div class="icons">
    <i class="fa-solid fa-ban-smoking"></i>
        <div class="content">
            <h3>Fumo</h3>
            <p>Vietato Fumare all'interno del veicolo</p>
        </div>
    </div>

    <div class="icons">
    <i class="fas fa-headset"></i>
        <div class="content">
            <h3>Documenti</h3>
            <p>Compilare il modulo in segreteria</p>
        </div>
    </div>

    <div class="icons">
    <i class="fas fa-gas-pump"></i>
        <div class="content">
            <h3>Rifornimento</h3>
            <p>Consigliabile fare gasolio all'interno dell'edificio</p>
        </div>
    </div>

    <div class="icons">
    <i class="fas fa-gas-pump"></i>
        <div class="content">
            <h3>Gasolio</h3>
            <p>E' dovere riempire il serbatoio più della metà a fine utilizzo </p>
        </div>
    </div>

    <div class="icons">
    <i class="fas fa-car-crash"></i>
        <div class="content">
            <h3>Incidenti</h3>
            <p>Eventuali Incidenti / danni conducibili all'utilizzatore saranno a carico di esso</p>
        </div>
    </div>

</section>

<section class="vehicles" id="vehicles">

    <h1 class="heading"> macchine <span>disponibili</span> </h1>

    <div class="swiper vehicles-slider">

        <div class="swiper-wrapper">

            <div class="swiper-slide box">
                <img src="images/vehicle-1.png" alt="">
                <div class="content">
                    <h3>FIAT 500L</h3>
                    <div class="price"> <span>targa : </span> FG709MR </div>
                    <p>
                        Usata
                        <span class="fas fa-circle"></span> Rossa
                        <span class="fas fa-circle"></span> cambio manuale
                        <span class="fas fa-circle"></span> Gasolio
                        <span class="fas fa-circle"></span> Posto n°6
                    </p>
                    <?php
                    if(isset($_SESSION['email'])){
                        echo "<a href='./script/calendario_auto.php?t=FG709MR' class='btn'>Prenota</a>";

                    }else{
                        echo "<button class='btn btn-warning'>DEVI ACCEDERE</button>";
                    }
                    ?>
                </div>
            </div>

            <div class="swiper-slide box">
                <img src="images/vehicle-2.png" alt="">
                <div class="content">
                    <h3>CYTROEN C3 Picasso</h3>
                    <div class="price"> <span>targa : </span> FK770JC </div>
                    <p>
                        Usata
                        <span class="fas fa-circle"></span> Grigia
                        <span class="fas fa-circle"></span> cambio manuale
                        <span class="fas fa-circle"></span> gasolio
                        <span class="fas fa-circle"></span> Posto n°3
                        
                    </p>
                    <?php
                    if(isset($_SESSION['email'])){
                        echo "<a href='./script/calendario_auto.php?t=FK770JC' class='btn'>Prenota</a>";

                    }else{
                        echo "<button class='btn btn-warning'>DEVI ACCEDERE</button>";
                    }
                    ?>                </div>
            </div>

            <div class="swiper-slide box">
                <img src="images/vehicle-3.png" alt="">
                <div class="content">
                    <h3>VOLVO V40</h3>
                    <div class="price"> <span>targa : </span> EZ667SJ </div>
                    <p>
                        Usata
                        <span class="fas fa-circle"></span> Grigia
                        <span class="fas fa-circle"></span> cambio manuale
                        <span class="fas fa-circle"></span> gasolio
                        <span class="fas fa-circle"></span> Posto n°7
                    </p>
                    <?php
                    if(isset($_SESSION['email'])){
                        echo "<a href='./script/calendario_auto.php?t=EZ667SJ' class='btn'>Prenota</a>";

                    }else{
                        echo "<button class='btn btn-warning'>DEVI ACCEDERE</button>";
                    }
                    ?>                </div>
            </div>

            <div class="swiper-slide box">
                <img src="images/vehicle-4.png" alt="">
                <div class="content">
                    <h3>FIAT DOBLO</h3>
                    <div class="price"> <span>targa : </span> FA578GR </div>
                    <p>
                        Usata
                        <span class="fas fa-circle"></span> Bianca
                        <span class="fas fa-circle"></span> cambio manuale
                        <span class="fas fa-circle"></span> gasolio
                        <span class="fas fa-circle"></span> Posto n° MAGAZZINO
                    </p>
                    <?php
                    if(isset($_SESSION['email'])){
                        echo "<a href='./script/calendario_auto.php?t=FA578GR' class='btn'>Prenota</a>";

                    }else{
                        echo "<button class='btn btn-warning'>DEVI ACCEDERE</button>";
                    }
                    ?>                </div>
            </div>

            <div class="swiper-slide box">
                <img src="images/vehicle-5.png" alt="">
                <div class="content">
                    <h3>FIAT DOBLO</h3>
                    <div class="price"> <span>targa : </span> FB726BD </div>
                    <p>
                        Usata
                        <span class="fas fa-circle"></span> Grigia
                        <span class="fas fa-circle"></span> cambio manuale
                        <span class="fas fa-circle"></span> gasolio
                        <span class="fas fa-circle"></span> Posto n°5
                    </p>
                    <?php
                    if(isset($_SESSION['email'])){
                        echo "<a href='./script/calendario_auto.php?t=FB726BD' class='btn'>Prenota</a>";

                    }else{
                        echo "<button class='btn btn-warning'>DEVI ACCEDERE</button>";
                    }
                    ?>        
                </div>
            </div>

            

        </div>

        <div class="swiper-pagination"></div>

    </div>

</section>

      


<section class="contact" id="contact">

    <h1 class="heading"><span>Altre</span> Domande</h1>

    <div class="row">
    
    <iframe class="map" src="./images/parcheggio.png"><h3>PARCHEGGIO</h3></iframe>

        <form action="">
            <h3>Contattaci</h3>
            <input type="text" placeholder="Nome" class="box">
            <input type="email" placeholder="email" class="box">
            <input type="tel" placeholder="Telefono" class="box">
            <textarea placeholder="Scrivi.." class="box" cols="30" rows="10"></textarea>
            <input type="submit" value="Invia" class="btn">
        </form>

    </div>

</section>





<section class="footer" id="footer">

    <div class="box-container">

        
        <div class="box">
            <h3>Link Veloci</h3>
            <a href="./index.php"> <i class="fas fa-arrow-right"></i> home </a>
            <a href="./stanze.php"> <i class="fas fa-arrow-right"></i>Stanze  </a>
            <a href="#regole"> <i class="fas fa-arrow-right"></i>Automobili  </a>
            <?php
                if(isset($_SESSION['email'])){
                    echo "<a href='./profilo.php'> <i class='fas fa-arrow-right'></i>Profilo  </a>";
                }
            ?>

        </div>

        <div class="box">
            <h3>Link Veloci</h3>
            <a href="#home"> <i class="fas fa-arrow-right"></i> home </a>
            <a href="#vehicles"> <i class="fas fa-arrow-right"></i> Macchine Disponibili </a>
            <a href="#regole"> <i class="fas fa-arrow-right"></i> Regole </a>
            <a href="#contact"> <i class="fas fa-arrow-right"></i> Altre Domande </a>
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

<script src="https://kit.fontawesome.com/f83be6fc4b.js" crossorigin="anonymous"></script>
<script src="./js/script_auto.js"></script>


</body>
</html>

