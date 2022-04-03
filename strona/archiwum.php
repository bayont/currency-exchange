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
    <div class="content">
    <div class="outputBox">
        <?php
        if(isset($_GET['data']) && isset($_GET['waluta'])) {
            $data = $_GET['data'];
            $waluta = $_GET['waluta'];
            include("./helpers/dajKursy.php");
            echo "<h3>W dniu $data kurs $waluta wynosił:</h3>";
            $k = $kursy[0]['kurs'];
            echo "<h2>$k zł</h2>";
        }
        else 
        echo "<h2>Wybierz datę i walutę!</h2>";
        ?>
    </div>
    <div class="pickers">
        <form id='sender' action="" method="GET">
            <input type="text" name="scroll" class="none">
        <div class="datePicker picker">
            <ul>
                <?php
                foreach($daty as $dat) {
                    echo "<li  class='inputContainer'><input type='radio' onclick='formSubmit()'  name='data' id='".$dat."' value='".$dat."' class='data'><label for='".$dat."' class='item'><div class='data'>$dat</div></li>";
                }
                ?>
            </ul>

        </div>
        <div class="currencyPicker picker scrollable">
            <ul>
                <?php
                foreach($waluty as $wal) {
                    list($kod, $nazwa, $flaga) = $wal;
                    echo "<li class='inputContainer'><input type='radio' onclick='formSubmit()' name='waluta' id='".$kod."' value='".$kod."'><label class='dateLabel item' for='".$kod."'><div class='flaga'>$flaga</div> <div class='nazwa'>$nazwa<div class='small'>$kod</div></div></label></li>";
                }
                ?>
            </ul>
        </div>
        </form>
    </div>
    </div>
    </div>
    </div>
    </div>

    <?php
        echo "<script>";
        if(isset($_GET['data'])) {
            $data = $_GET['data'];
            echo "document.querySelector(`input[value='$data']`).checked = true;";
        }

        if(isset($_GET['waluta'])) {
            $waluta = $_GET['waluta'];
            if(isset($_GET['scroll'])) {
            $scroll = $_GET['scroll'];
            echo "const it = document.querySelector(`input[value='$waluta']`);it.checked = true;document.querySelector(`.currencyPicker`).scrollTo({top: $scroll});";
            }
            else 
            echo "const it = document.querySelector(`input[value='$waluta']`);it.checked = true;";
        }

        echo "</script>";

        
    ?>


    <script>
        const formItem = document.querySelector("form#sender");
        function formSubmit() {
            document.querySelector('.none').value = document.querySelector(`.currencyPicker`).scrollTop;
            formItem.submit()
        }
    </script>
    
</body>
</html>