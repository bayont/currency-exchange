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
    $waluty[$i] = array();
    $waluty[$i]['kod'] = $x[0];
    $waluty[$i]['nazwa'] = $x[1];
    $i++;
}



mysqli_close($conn)
?>