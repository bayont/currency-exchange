<?php
$conn = mysqli_connect("localhost", "root", "", "kantorek");
if(mysqli_connect_errno()) {
    echo "Nie udało się połączyć z bazą danych.";
    exit();
}
$q = "SELECT DISTINCT kod_waluty, nazwa FROM kursy;";
$res = mysqli_query($conn, $q);
$waluty = array();

while($x = mysqli_fetch_row($res)) {
    $waluty[$x[0]] = array();
    $waluty[$x[0]][0] = $x[0];
    $waluty[$x[0]][1] = $x[1];
    if($x[0] != "XDR"){
        $kraj = strtolower(substr($x[0], 0, 2));
        include("./helpers/dajFlage.php");
        $waluty[$x[0]][2] = $flaga;
    }
    else {
        $waluty[$x[0]][2] = '';
    }
}

?>