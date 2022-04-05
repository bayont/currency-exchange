<!DOCTYPE html>
<html lang="pl">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo $_GET["waluta"]; ?>/PLN - kurs</title>
    <script src="./chart.min.js"></script>
    <link href="https://fonts.googleapis.com/css?family=Material+Icons|Material+Icons+Outlined|Material+Icons+Two+Tone|Material+Icons+Round|Material+Icons+Sharp" rel="stylesheet">
    <link rel="stylesheet" href="./css/global.css">
    <link rel="stylesheet" href="./css/kurs.css">
    <link rel="stylesheet" href="./css/nav.css">
</head>
<body>
            
<?php
$waluta = $_GET["waluta"];
include("./helpers/dajKursy.php");
if($waluta != "XDR"){
    $kraj = strtolower(substr($waluta, 0, 2));
    include("./helpers/dajFlage.php");
    }
    else $flaga="";
?>
<?php include("./nav.php"); ?>


<div class="container">

<div class="inner-container">
<div class="left">
    <div class="kurs">
<h1>Kurs <span class="para"><?php echo $waluta ?>/PLN</span></h1>
<h2><?php echo $flaga." ".$kursy[0]['nazwa'] ?></h2>
<h1 style=<?php
                    $il_kursow = count($kursy);
                    if($il_kursow > 1)
                        if($kursy[count($kursy)-1]['kurs_raw'] > $kursy[count($kursy)-2]['kurs_raw']) {
                            echo "'color: rgba(20, 185, 20, 1.0)', ";
                        }
                        else if ($kursy[count($kursy)-1]['kurs_raw'] == $kursy[count($kursy)-2]['kurs_raw']) {
                            echo "'color: rgba(54, 162, 235, 1.0)', ";
                        }
                        else {
                            echo "'color: rgba(235, 50, 50, 1.0)', ";
                        }
                    else {
                        echo "'color: rgba(54, 162, 235, 1.0)', ";
                    }
                ?>><?php echo str_replace(".", ",", $kursy[count($kursy)-1]['kurs_raw']) ?> zł</h1>
<div class="wykresContainer">
<canvas id="wykresWaluty" width="100" height="100"></canvas>
</div>
</div>
</div>
<div class="right">
    <h2>Sprawdź inne wykresy</h2>
    <div class="scrollable">
    <?php
            include("./helpers/dajWaluty.php");
            foreach($waluty as $wal) {
                list($kod, $nazwa, $flaga) = $wal;
                echo "<a class='kursAnchor' href='kurs.php?waluta=$kod'><div class='item'><div class='flaga'>$flaga</div> <div class='nazwa'>$nazwa<div class='small'>$kod</div></div></div></a>";
            }
    ?>
    </div>
</div>
</div>
</div>






<script>
let ctx = document.querySelector("#wykresWaluty").getContext('2d');

let wykres = new Chart(ctx, {
    type: 'line',
    data: {
        labels: [<?php
        $out_str = "";
      foreach($kursy as $kurs) {
        $out_str =  $out_str.'"'.$kurs['data'].'"'.", ";
      }
      $out_str = substr($out_str, 0, strlen($out_str)-2);
      echo $out_str;
    
    ?>],
        datasets: [{
            label: 'kurs <?php echo $waluta; ?>/PLN',
            data: [
                <?php
                $out_str = "";
                foreach($kursy as $kurs) {
                    $out_str =  $out_str.$kurs['kurs_raw'].", ";
                }
                $out_str = substr($out_str, 0, strlen($out_str)-2);
                echo $out_str;
    
                ?>
            ],
            backgroundColor: [
                'rgba(255, 255, 255, 0.2)',
            ],
            borderColor: [
                <?php
                    $il_kursow = count($kursy);
                    if($il_kursow > 1)
                        if($kursy[count($kursy)-1]['kurs_raw'] > $kursy[count($kursy)-2]['kurs_raw']) {
                            echo "'rgba(20, 185, 20, 1.0)', ";
                        }
                        else if ($kursy[count($kursy)-1]['kurs_raw'] == $kursy[count($kursy)-2]['kurs_raw']) {
                            echo "'rgba(54, 162, 235, 1.0)', ";
                        }
                        else {
                            echo "'rgba(235, 50, 50, 1.0)', ";
                        }
                    else {
                        echo "'rgba(54, 162, 235, 1.0)', ";
                    }
                ?>
            ],
            borderWidth: 3
        }]
    },
    options: {
        
    }
})
</script>
</body>
</html>
