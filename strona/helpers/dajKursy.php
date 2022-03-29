<?php


$conn = mysqli_connect("localhost", "root", "", "kantorek");
if(mysqli_connect_errno()) {
    echo "Nie udało się połączyć z bazą danych.";
    exit();
}
if(isset($waluta)) {
 if(isset($data)) 
    $q = "SELECT * FROM kursy WHERE kod_waluty = '".$waluta."' AND data = '".$data."';";
 else
 $q = "SELECT * FROM kursy WHERE kod_waluty = '".$waluta."';";
}
else
$q = "SELECT * FROM kursy;";
$result = mysqli_query($conn, $q);
$kursy = array();
$tabela = "";
$data = "";
$i = 0;


while($x = mysqli_fetch_row($result)) {
    $kursy[$i] = array();
    $kursy[$i]["id"] = $x[0];
    $kursy[$i]["tabela"] = $x[1];
    $kursy[$i]["data"] = $x[2];
    $kursy[$i]["kod_waluty"] = $x[3];
    $kursy[$i]["kurs"] = $x[4];
    $kursy[$i]["nazwa"] = $x[5];
    $i++;
}
$data = $kursy[0]['data'];
$tabela = $kursy[0]['tabela'];

mysqli_close($conn)
?>