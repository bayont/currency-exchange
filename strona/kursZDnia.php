<!DOCTYPE html>
<html lang="pl">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Kurs z dnia</title>
</head>
<body>
    <h1>Wybierz walutę aby poznać kurs z dowolnego dnia</h1>
    <?php
    include("./helpers/dajDatyIWaluty.php");
    ?>
    
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

    <?php
        if(isset($_GET['data'])) {
            $data = $_GET['data'];
            $waluta = $_GET['waluta'];
            echo "<script>
            document.querySelector('#data').value = '".$data."';
            document.querySelector('#waluta').value = '".$waluta."';
            </script>";
            include("./helpers/dajKursy.php");
            echo $kursy[0]['kurs']." ".$waluta."/PLN";
        }
    ?>
</body>
</html>