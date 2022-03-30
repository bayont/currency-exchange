<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="UTF-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Document</title>
    <link rel="stylesheet" href="./css/global.css">
    <link rel="stylesheet" href="./css/index.css">
    <link rel="stylesheet" href="./css/nav.css">
  
  </head>
  <body>
    <nav>
      <div class="logo">
        Kantorek
      </div>
      <div class="options">
      <div class="menuOption">
      <a href="kalkulator.php">Kalkulator walut</a>
      </div>
      <div class="menuOption">
      <a href="kursZDnia.php">Kurs z dnia</a>
      </div>
      </div>
    </nav>

    <div class="container">
    <?php
        include_once("./helpers/dajAktualneKursy.php");
    ?>
    <header>
        <h2>Tabela <i><?php echo $tabela; ?> </i></h2>
        <h3>z dnia <?php echo $data; ?></h3>
    </header>
    <table>
        <tr>
            <th>#</th>
            <th class='icons'></th> 
            <th class='align-left'>Nazwa waluty<div class="small">(państwo)</div></th>
            <th class='align-right'>Nominał <div class="small">Kliknij, aby pokazać wykres</div></th>
            <th class='align-right'>Kurs</th>
            
        </tr>
        <?php
        $i = 1;
        foreach($kursy as $kurs) {
            if($kurs['kod_waluty'] != "XDR"){
            $kraj = strtolower(substr($kurs['kod_waluty'], 0, 2));
            include("./helpers/dajFlage.php");
            }
            else $flaga="";
            echo "<tr>";
            echo "<td>".$i."</td>";
            echo "<td class='icons'>".$flaga."</td>";
            echo "<td class='align-left'>".$kurs['nazwa']."</td>";
           

            echo '<td class="align-right">'.'<a href="kurs.php?waluta='.$kurs["kod_waluty"].'"><div class="kurs"> '.$kurs['nominal'].'</div></a>'.'</td>';

            echo "<td class='align-right'>".$kurs['kurs']. " zł"."</td>";
            
            
            
           
            
            echo "</tr>";
            $i++;
        }
        ?>
        
        </div>
  </body>
</html>
