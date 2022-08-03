<?php
include("connessione.php");

$data=str_replace("==date(", "", $_POST['data']);
$nome=$_POST['nome'];
$oraInizio=strval($_POST['oraInizio']).":00";
$oraFine=strval($_POST['oraFine']).":00";
$oggetti=$_POST['oggetti'];

$conn = new mysqli($host, $username, $pass, $db);
// Check connection
if ($conn->connect_error) {
  die("Connection failed: " . $conn->connect_error);
}

$sql = "SELECT idDipendenti FROM dipendenti WHERE email='$nome'";
$result = $conn->query($sql);

if ($result->num_rows > 0) {
  // output data of each row
  while($row = $result->fetch_assoc()) {
    $prenotazione_dipendenti=$row["idDipendenti"];
  }
}

$conn->close();

$prenotazione_sale=$_POST['prenotazione_sale'];

$conn = new mysqli($host, $username, $pass, $db);
// Check connection
if ($conn->connect_error) {
  die("Connection failed: " . $conn->connect_error);
}

print("INSERT INTO prenotazioni_sale VALUES(NULL, $data, $nome, $oraInizio, $oraFine, $oggetti, $prenotazione_dipendenti, $prenotazione_sale)");

$sql = "INSERT INTO prenotazioni_sale VALUES(NULL, '$data', '$nome', '$oraInizio', '$oraFine', '$oggetti', '$prenotazione_dipendenti', '$prenotazione_sale')";

if ($conn->query($sql) === TRUE) {
  echo "New record created successfully";
} else {
  echo "Error: " . $sql . "<br>" . $conn->error;
}

$conn->close();

?>