<!DOCTYPE html>
<html lang="de">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <link rel="stylesheet" href="style.css">
  <title>Quiz</title>
</head>

<body>


  <div id="quiz">
    <?php
    $lektion = $_GET['lektion'] ?? 0;
    if ($lektion == 0) { // lektion 0 = Übersicht
      echo '<a href="index.php?lektion=2">Testfragen Lektion 2</a>';
      echo '<a href="index.php?lektion=3">Testfragen Lektion 3</a>';
      echo '<a href="index.php?lektion=4">Testfragen Lektion 4</a>';
      echo '<a href="index.php?lektion=5">Testfragen Lektion 5</a>';
      echo '<a href="index.php?lektion=6">Testfragen Lektion 6</a>';
      echo '<a href="index.php?lektion=7">Testfragen Lektion 7</a>';
      echo '<a href="index.php?lektion=8">Testfragen Lektion 8</a>';
      echo '<a href="index.php?lektion=9">Testfragen Lektion 9</a>';
    }
    if ($lektion != 0) { // Wenn nicht Übersicht ...
    
      $text = file_get_contents("lektion_" . $lektion . ".json"); // ... lade die .json der Lektion ...
      echo '<h1>Lektion ' . $lektion . '</h1>'; // ... füge die Lektionsnummer in die Überschrift ein
      $json = json_decode($text, true);

      $html = '';
      // füllt die Seite mit den Fragen und Antworten aus der json
      foreach ($json as $frage) {
        $html .= '<fieldset>';
        $html .= '<legend>' . $frage['frage'] . '</legend>';
        foreach ($frage['antworten'] as $antwort) {
          $html .= '<input type="checkbox" onclick="zeigeSpan(\'' . $antwort["id"] . '\')">' . $antwort['text'] . // zeigt bei einem klick auf das Kästchen den <span>
            '</input><br/>
                      <span id="' . $antwort["id"] . '" style="display:none;">' . $antwort["erklaerung"] . '</span><br/>';
          if ($antwort["richtig"] == false) {
            $html .= '<script> document.getElementById(\'' . $antwort["id"] . '\').style.color = "red";</script>'; // färbt den <span> für falsche Antworten rot
          }
        }
        $html .= '</fieldset><br/>';
      }
      $html .= '<a href="index.php?lektion=0">Zur Übersicht</a>';
      echo $html;
    }


    ?>
  </div>
  <script>
    function zeigeSpan(id) {
      var x = document.getElementById(id);
      if (x.style.display === "none") {
        x.style.display = "block";
      } else {
        x.style.display = "none";
      }
    }
  </script>
</body>

</html>