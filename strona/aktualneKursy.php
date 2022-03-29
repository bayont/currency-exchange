<!DOCTYPE html>
<html lang="pl">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Aktualne kursy</title>
</head>
<body>
    <?php
        include_once("./helpers/dajAktualneKursy.php");
    ?>
    <header>
        <h2>Tabela <?php echo $tabela; ?></h2>
        <h3>z dnia <?php echo $data; ?></h3>
        <a href=""></a>
    </header>
    <table>
        <tr>
            <th>Kurs</th>
            <th>Kod</th>
            <th>Nazwa</th>
            
        </tr>
        <?php
        foreach($kursy as $kurs) {
            if($kurs['kod_waluty'] != "XDR"){
            $kraj = strtolower(substr($kurs['kod_waluty'], 0, 2));
            include("./helpers/dajFlage.php");
            }
            else $flaga="";
            echo "<tr>";
            echo "<td>".$kurs['kurs']."</td>";

            echo '<td>'.'<a href="kurs.php?waluta='.$kurs["kod_waluty"].'">'.$kurs['kod_waluty'].'</a>'.'</td>';


            echo "<td>".$kurs['nazwa'].$flaga."</td>";
            
           
            
            echo "</tr>";
            
        }
        ?>
    </table>
</body>
</html>