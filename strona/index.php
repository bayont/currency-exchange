<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="UTF-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Kantorek - Fabian Fetter</title>
    <link href="https://fonts.googleapis.com/css?family=Material+Icons|Material+Icons+Outlined|Material+Icons+Two+Tone|Material+Icons+Round|Material+Icons+Sharp" rel="stylesheet">
    <link rel="stylesheet" href="./css/global.css">
    <link rel="stylesheet" href="./css/index.css">
    <link rel="stylesheet" href="./css/nav.css">
  
   
  
  </head>
  <body>
  <?php include("./nav.php"); ?>

    <div class="container">
    <?php
        include_once("./helpers/dajAktualneKursy.php");
    ?>
    <header>
        <h1>Aktualne kursy</h1>
        <h5> <span class="md-18 material-icons-round">
      today
      </span> <span class="data"><?php echo $data; ?></span><span class="tabela"><?php echo $tabela; ?></span></h5>
    </header>
    <section class="tableContainer">
    <table>
        <tr>
            <th class='lp'>#</th>
            <th class='icons'></th> 
            <th class='align-left'>Nazwa waluty<div class="small">(państwo)</div></th>
            
            <th class='align-right'>Nominał <div class="small">Kliknij, aby pokazać wykres</div></th>
            <th class='align-right'>Kurs</th>
            <th class='align-right change'>Zmiana (%)</th>
            
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
            echo "<td class='lp'>".$i."</td>";
            echo "<td class='icons'>".$flaga."</td>";
            echo "<td class='align-left nazwa'>".'<a href="kurs.php?waluta='.$kurs["kod_waluty"].'">'.$kurs['nazwa']."</a></td>";
           
            
            echo '<td class="align-right">'.'<a href="kurs.php?waluta='.$kurs["kod_waluty"].'"><div class="nominal"> '.$kurs['nominal'].'</div></a>'.'</td>';
            
            echo "<td class='align-right kurs'>".$kurs['kurs']. " zł"."</td>";

            $zmiana = $kurs['zmiana'];
            $klasaZmiany = "";
            $zmiana -= 1.0;
            if($zmiana == 0.0) {
              $zmiana = '0,00';
            }
            else {
            if($zmiana >= 0) {
                $klasaZmiany = "change-up";
                $icon = "keyboard_arrow_up";
            }
            else {
              $zmiana = abs($zmiana);
              $klasaZmiany = "change-down";
              $icon = "keyboard_arrow_down";
            }
              $zmiana *= 100;
              $zmiana = str_replace(".", ",",strval(round($zmiana,2)));
              $ex = explode(',', "$zmiana,");
              if(count($ex) > 1)
              $zmiana = $ex[0].','.str_pad($ex[1], 2, '0', STR_PAD_RIGHT);
              else 
              $zmiana = $ex[0];
          }
          if($zmiana == "0,00") {
            $klasaZmiany = "unchanged";
            $icon = "remove";
          }

            
  
            echo "<td class='align-right'><div class='zmiana ".$klasaZmiany."'><span class='md-18 material-icons-round arrow'>".$icon."</span>".$zmiana."%</div></td>";
            
            
            
            echo "</tr>";
            $i++;
        }
        ?>
        </table>
        
        </div>
        <footer></footer>
  </body>
</html>
