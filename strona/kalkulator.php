<!DOCTYPE html>
<html lang="pl">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="css/global.css">
    <title>Document</title>
</head>
<body>
    <?php
    include("./helpers/dajDatyIWaluty.php");
    echo "<script>";
    echo "const waluty = [";
    foreach($waluty as $waluta) {
        echo "{kod: '".$waluta['kod']."', nazwa: '".$waluta['nazwa']."'}, ";
    }

    echo "];</script>";
    ?>
    <form action="" method="get">
    <div class="flex">
        Z: <select name="walutaA" id="walutaA">
        </select> <br>
        Na: <select name="walutaB" id="walutaB"></select>
    </div>
    <div class="flex">
        Wpisz ilość<span id="walutaSpan"></span>:<input type="number" name="wartosc" id="walutaAValue" required step="0.01">
    </div>
    <input type="submit" value="Przelicz">
    </form>

    <script>
        waluty.splice(0, 0, {kod: "PLN", nazwa: "polski złoty"});
        const walutaA = document.querySelector("#walutaA");
        const walutaB = document.querySelector("#walutaB");
        waluty.forEach((waluta) => {
            const newOption = document.createElement("option");
            newOption.value = waluta.kod;
            newOption.innerHTML = `${waluta.kod} | ${waluta.nazwa}`;
            walutaA.append(newOption);
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
            }
            });

        }
        aOnChange();
        walutaA.onchange = aOnChange;
    </script>

    <?php
        if(isset($_GET['walutaA']) && isset($_GET['walutaB']) && isset($_GET['wartosc'])) {
            $kod_a = $_GET['walutaA'];
            $kod_b = $_GET['walutaB'];
            $wartosc = $_GET['wartosc'];
            $wartosc = floatval($wartosc);
            include("./helpers/dajAktualneKursy.php");
            $kurs_a = 0.0;
            $kurs_b = 0.0;

            //Zrobić obsługę polskiego złotego!
            if ($kod_a == "PLN") {
                
                foreach($kursy as $kurs) {
                    if ($kurs['kod_waluty'] == $kod_b) {
                        $kurs_b = $kurs['kurs'];
                    }
                }
                $kurs_koncowy = round(1.0/$kurs_b, 5);
            }
            else if($kod_b == "PLN") {
                foreach($kursy as $kurs) {
                    if ($kurs['kod_waluty'] == $kod_a) {
                        $kurs_a = $kurs['kurs'];
                    }
                }
                $kurs_koncowy = $kurs_a;
            }
            else {
                foreach($kursy as $kurs) {
                    if($kurs['kod_waluty'] == $kod_a) {
                        $kurs_a = $kurs['kurs'];
                    }
                    else if ($kurs['kod_waluty'] == $kod_b) {
                        $kurs_b = $kurs['kurs'];
                    }
                }

            $kurs_koncowy = $kurs_a/$kurs_b;
            
            }
            $przeliczone = floatval($wartosc)*$kurs_koncowy;
            echo "<div>";
            echo $wartosc." ".$kod_a." = ".$przeliczone." ".$kod_b;
            echo "</div>";

            echo "<div>";
            echo "Przy kursie: ".$kurs_koncowy." ".$kod_a."/".$kod_b;
            echo "</div>";

        }
    ?>
</body>
</html>