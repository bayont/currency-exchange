<?php
$conn = mysqli_connect("localhost", "root", "", "kantorek");
if(mysqli_connect_errno()) {
    echo "Nie udało się połączyć z bazą danych.";
    exit();
}


$q = "SELECT DISTINCT data FROM kursy ORDER BY data ASC;";
$result = mysqli_query($conn, $q);
$i = 0;
$daty = array();
while($x = mysqli_fetch_row($result)) {
    $daty[$i] = $x[0];
    $i++;
}

$q = "SELECT DISTINCT kod_waluty, nazwa FROM kursy;";
$result = mysqli_query($conn, $q);
$i = 0;
$waluty = array();

while($x = mysqli_fetch_row($result)) {
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




mysqli_close($conn)
?>