<!DOCTYPE html>
<html lang="pl">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Archiwum kursów</title>
    <link href="https://fonts.googleapis.com/css?family=Material+Icons|Material+Icons+Outlined|Material+Icons+Two+Tone|Material+Icons+Round|Material+Icons+Sharp" rel="stylesheet">
    <link rel="stylesheet" href="./css/global.css">
    <link rel="stylesheet" href="./css/archiwum.css">
    <link rel="stylesheet" href="./css/nav.css">
</head>
<body>
    <?php include('./nav.php') ?>
    <div class="center">
    <h2>Wybierz walutę i jedną z zarchiwizowanych dat </h2>
    </div>
    <?php
    include("./helpers/dajDatyIWaluty.php");
    ?>
    <div class="container">
        <div class="inner-container">
    <div class="flex">
    <form action="" method="GET">
        <select name="data" id="data">
            <?php 
                foreach($daty as $data) {
                    echo "<option value='".$data."'>".$data."</option>";
                }
            ?>
        </select>
        <select name="waluta" id="waluta">
            <?php
                foreach($waluty as $waluta) {
                    echo "<option value='".$waluta['kod']."'>".$waluta['kod']." - ".$waluta['nazwa']."</option>";
                }
            ?>
        </select>
        <input type="submit" value="Sprawdź!">
    </form>
    </div>
    <div class="flex">
        <p>
    <?php
        if(isset($_GET['data'])) {
            
            $data = $_GET['data'];
            
            
            $waluta = $_GET['waluta'];
            echo "W dniu $data: ";
            echo "<script>
            document.querySelector('#data').value = '".$data."';
            document.querySelector('#waluta').value = '".$waluta."';
            </script>";
            include("./helpers/dajKursy.php");
            echo $kursy[0]['kurs']." ".$waluta."/PLN";
        }
    ?>
    </p>
    </div>
    </div>
    </div>
</body>
</html>