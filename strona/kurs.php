<!DOCTYPE html>
<html lang="pl">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo $_GET["waluta"]; ?>/PLN - kurs</title>
    <script src="./chart.min.js"></script>
</head>
<body>
<?php
$waluta = $_GET["waluta"];
include("./helpers/dajKursy.php");
?>
<h1>Kurs <?php echo $waluta ?>/PLN</h1>
<h2><?php echo $kursy[0]['nazwa'] ?></h2>
<h1 style=<?php
                    $il_kursow = count($kursy);
                    if($il_kursow > 1)
                        if($kursy[count($kursy)-1]['kurs'] > $kursy[count($kursy)-2]['kurs']) {
                            echo "'color: rgba(20, 185, 20, 1.0)', ";
                        }
                        else if ($kursy[count($kursy)-1]['kurs'] == $kursy[count($kursy)-2]['kurs']) {
                            echo "'color: rgba(54, 162, 235, 1.0)', ";
                        }
                        else {
                            echo "'color: rgba(235, 50, 50, 1.0)', ";
                        }
                    else {
                        echo "'color: rgba(54, 162, 235, 1.0)', ";
                    }
                ?>><?php echo str_replace(".", ",", $kursy[count($kursy)-1]['kurs']) ?> zł</h1>
<div width="100" height="100">
<canvas id="wykresWaluty" width="100" height="100"></canvas>
<style>
    #wykresWaluty {
        max-width: 30rem;
        max-height: 20rem;
    }
</style>
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
                    $out_str =  $out_str.$kurs['kurs'].", ";
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
                        if($kursy[count($kursy)-1]['kurs'] > $kursy[count($kursy)-2]['kurs']) {
                            echo "'rgba(20, 185, 20, 1.0)', ";
                        }
                        else if ($kursy[count($kursy)-1]['kurs'] == $kursy[count($kursy)-2]['kurs']) {
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
