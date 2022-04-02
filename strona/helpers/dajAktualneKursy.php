<?php

$conn = mysqli_connect("localhost", "root", "", "kantorek");
if(mysqli_connect_errno()) {
    echo "Nie udało się połączyć z bazą danych.";
    exit();
}
$q = "SELECT DISTINCT data FROM kursy ORDER BY data DESC LIMIT 2;";
$result = mysqli_query($conn, $q);
$data = mysqli_fetch_row($result)[0];
$data_zeszla = mysqli_fetch_row($result)[0];
$q = 'SELECT * FROM kursy WHERE data = "'.$data_zeszla.'";';
$result = mysqli_query($conn, $q);
$k_zeszle = array();
while($x = mysqli_fetch_row($result)) {
    $k_zeszle[$x[3]] = floatval($x[4]);
}


$q = 'SELECT * FROM kursy WHERE data = "'.$data.'";';
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
    $kurs = floatval($x[4]);
    $kursy[$i]["kurs_raw"] = $kurs;
    $mnoznik = 1;
    $kursy[$i]["zmiana"] = $kurs/floatval($k_zeszle[$kursy[$i]["kod_waluty"]]);
    if($kurs >= 0.1)
    $kursy[$i]["kurs"] = $kurs;
    else {
        while(floatval($kurs) < 0.1) {
            $kurs *= 10;
            $mnoznik *=10;
        }
        $kursy[$i]["kurs"] = strval($kurs);
    }
    $kursy[$i]["nominal"] = strval($mnoznik)." ".$x[3];
    

    $kursy[$i]["kurs"] = str_replace(".", "," , strval($kursy[$i]["kurs"]));
    
    $kursy[$i]["nazwa"] = $x[5];
    $i++;
}
$data = $kursy[0]['data'];
$tabela = $kursy[0]['tabela'];

mysqli_close($conn)
?>