<!DOCTYPE html>
<html lang="pl">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://fonts.googleapis.com/css?family=Material+Icons|Material+Icons+Outlined|Material+Icons+Two+Tone|Material+Icons+Round|Material+Icons+Sharp" rel="stylesheet">
    <link rel="stylesheet" href="./css/global.css">
    <link rel="stylesheet" href="./css/kalkulator.css">
    <link rel="stylesheet" href="./css/nav.css">

    <title>Kalkulator Walut</title>
</head>
<body>
    <?php include("./nav.php"); ?>

    <div class="container">

    <div class="inner-container">
        
    <div class="left">
    <h2>Kalkulator walut</h2>

    <?php
    include("./helpers/dajDatyIWaluty.php");
    echo "<script>";
    echo "const waluty = [";
    foreach($waluty as $waluta) {
        list($kod, $nazwa, $flaga) = $waluta;
        echo "{kod: '".$kod."', nazwa: '".$nazwa."'}, ";
    }

    echo "];";
    if(isset($_GET['walutaA']) && isset($_GET['walutaB']) && isset($_GET['wartosc'])) {
    $wA = $_GET['walutaA'];
    $wB = $_GET['walutaB'];
    $w = $_GET['wartosc'];
    echo "let defWartosc = $w; let defWalutaA = '$wA'; let defWalutaB = '$wB';";
    }
    else {
        echo "let defWartosc = null; let defWalutaA = null; let defWalutaB = null;";
    }
    echo "</script>";
    ?>

<svg xmlns="http://www.w3.org/2000/svg" enable-background="new 0 0 20 20" height="48px" viewBox="0 0 20 20" width="48px"
    fill="#FFFFFF">
    <defs>
        <clipPath id="svgPath">
        <path
                d="M15,4H5C4.45,4,4,4.45,4,5v10c0,0.55,0.45,1,1,1h10c0.55,0,1-0.45,1-1V5C16,4.45,15.55,4,15,4z M6.5,7.27h2 c0.28,0,0.5,0.22,0.5,0.5v0c0,0.28-0.22,0.5-0.5,0.5h-2C6.22,8.27,6,8.04,6,7.77v0C6,7.49,6.22,7.27,6.5,7.27z M9.5,12.5h-1v1 C8.5,13.78,8.28,14,8,14h0c-0.28,0-0.5-0.22-0.5-0.5v-1h-1C6.22,12.5,6,12.28,6,12v0c0-0.28,0.22-0.5,0.5-0.5h1v-1 C7.5,10.22,7.72,10,8,10h0c0.28,0,0.5,0.22,0.5,0.5v1h1c0.28,0,0.5,0.22,0.5,0.5v0C10,12.28,9.78,12.5,9.5,12.5z M13.5,13.25h-2 c-0.28,0-0.5-0.22-0.5-0.5v0c0-0.28,0.22-0.5,0.5-0.5h2c0.28,0,0.5,0.22,0.5,0.5v0C14,13.03,13.78,13.25,13.5,13.25z M13.5,11.75 h-2c-0.28,0-0.5-0.22-0.5-0.5v0c0-0.28,0.22-0.5,0.5-0.5h2c0.28,0,0.5,0.22,0.5,0.5v0C14,11.53,13.78,11.75,13.5,11.75z M13.91,9.18L13.91,9.18c-0.2,0.2-0.51,0.2-0.71,0L12.5,8.47l-0.71,0.71c-0.2,0.2-0.51,0.2-0.71,0l0,0c-0.2-0.2-0.2-0.51,0-0.71 l0.71-0.71l-0.71-0.71c-0.2-0.2-0.2-0.51,0-0.71v0c0.2-0.2,0.51-0.2,0.71,0l0.71,0.71l0.71-0.71c0.2-0.2,0.51-0.2,0.71,0v0 c0.2,0.2,0.2,0.51,0,0.71l-0.71,0.71l0.71,0.71C14.11,8.67,14.11,8.99,13.91,9.18z"  transform="scale(15.0)"/>
        
        </clipPath>
    </defs>

</svg>

    <form class='formContainer' action="" method="get">
    <div class="flex">
        <div class="label">Mam walutę:</div><select name="walutaA" id="walutaA"></select>
        </div>
        
        <div class="flex">
        <div class="label">chcę przeliczyć Na:</div><select name="walutaB" id="walutaB"></select>
        </div>
    <div class="flex">
        <span class="fontSize">Wprowadź ilość<span id="walutaSpan"></span>:</span><input type="number" name="wartosc" id="walutaAValue" required step="0.01" min="0.00">
    </div>
    <input type="submit" value="Przelicz">
    </form>
    </div>


    <?php
        if(isset($_GET['walutaA']) && isset($_GET['walutaB']) && isset($_GET['wartosc'])) {
            $kod_a = $_GET['walutaA'];
            $kod_b = $_GET['walutaB'];
            $wartosc = $_GET['wartosc'];
            $wartosc = floatval($wartosc);
            include("./helpers/dajAktualneKursy.php");
            $kurs_a = 0.0;
            $kurs_b = 0.0;
            if ($kod_a == "PLN") {
                
                foreach($kursy as $kurs) {
                    if ($kurs['kod_waluty'] == $kod_b) {
                        $kurs_b = floatval($kurs['kurs_raw']);
                    }
                }
                $kurs_koncowy = round(1.0/$kurs_b, 5);
            }
            else if($kod_b == "PLN") {
                foreach($kursy as $kurs) {
                    if ($kurs['kod_waluty'] == $kod_a) {
                        $kurs_a = floatval($kurs['kurs_raw']);
                    }
                }
                
                $kurs_koncowy = $kurs_a;
            }
            else {
                foreach($kursy as $kurs) {
                    if($kurs['kod_waluty'] == $kod_a) {
                        $kurs_a = floatval($kurs['kurs_raw']);
                    }
                    else if ($kurs['kod_waluty'] == $kod_b) {
                        $kurs_b = floatval($kurs['kurs_raw']);
                    }
                }

            $kurs_koncowy = $kurs_a/$kurs_b;
            
            }
            
            $przeliczone = floatval($wartosc)*$kurs_koncowy;
            

        }
?>
    <script>
        waluty.splice(0, 0, {kod: "PLN", nazwa: "polski złoty"});
        const walutaA = document.querySelector("#walutaA");
        const walutaB = document.querySelector("#walutaB");
        waluty.forEach((waluta) => {
            const newOption = document.createElement("option");
            newOption.value = waluta.kod;
            newOption.innerHTML = `${waluta.kod} | ${waluta.nazwa}`;
            walutaA.append(newOption);
            if(defWalutaA != null && waluta.kod == defWalutaA)
            newOption.selected = true;
        });

        const aOnChange = () => {
            document.querySelector("#walutaSpan").innerHTML = ` (${walutaA.value})`
            walutaB.innerHTML = "";
            waluty.forEach((waluta) => {
                if(waluta.kod != walutaA.value) {
                const newOption = document.createElement("option");
                newOption.value = waluta.kod;
                newOption.innerHTML = `${waluta.kod} | ${waluta.nazwa}`;
                walutaB.append(newOption);
                if(defWalutaB != null && waluta.kod == defWalutaB)
            newOption.selected = true;
            }
            });

        }
        aOnChange();
        document.querySelector("#walutaAValue").value = defWartosc;
        walutaA.onchange = aOnChange;
    </script>


<div class='right'>
    <?php
    if(isset($wartosc)) {
        $przeliczone = str_replace(".", "," , strval(round($przeliczone, 2)));
        $ex = explode(',', "$przeliczone,");
        $przeliczone = $ex[0].','.str_pad($ex[1], 2, '0', STR_PAD_RIGHT);
        $kurs_koncowy = str_replace(".", "," , strval(floatval(round($kurs_koncowy,4))));
        $wartosc = str_replace(".", "," , strval($wartosc));
        $flagaA = "";
        $flagaB = "";
        if($kod_a !="XDR" ) {
        $kraj = strtolower(substr($kod_a, 0, 2));
        include("./helpers/dajFlage.php");
        $flagaA = $flaga;
        }
        if($kod_b != "XDR") {
        $kraj = strtolower(substr($kod_b, 0, 2));
        include("./helpers/dajFlage.php");
        $flagaB = $flaga;
        }

        echo "
        <div class='kalkulator-wrapper'>
            <div class='heading'>Kalkulator walut
                <div class='small kurs'>$kurs_koncowy $kod_a/$kod_b</div>
            </div>
            <div class='kalkulator-content'>
                <div class='flaga'>$flagaA</div>
                <div class='walutaA'>$wartosc $kod_a</div>
                <div class='equals'>=</div>
                <div class='walutaB'>$przeliczone $kod_b</div>
                <div class='flaga'>$flagaB</div>
            </div>
            
        </div>
    ";
     } ?>
    </div>
</div>
</div>
</body>
</html>