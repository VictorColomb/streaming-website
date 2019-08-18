<?php

$mysqli = new mysqli(/*Server name*/ "localhost",/*User name*/  "phpuser",/*password*/  "phpuser",/*DB name*/  "streaming_server");
if($mysqli->connect_error) {
  exit('Could not connect');
}

$tilde = "'";
if (isset($_GET['show'])) {
  $output = '';
  $querry = 'SELECT DISTINCT(season) FROM movies WHERE serie = "'.$_GET['show'].'" ORDER BY season';
  $stmt = $mysqli->query($querry) or die('SQL Error.');
  while ($season = mysqli_fetch_assoc($stmt)) {
    $output .= '<p class="season">Season '.$season['season'].'</p>';
    $querry = 'SELECT ep FROM movies WHERE serie = "'.$_GET['show'].'" AND season = "'.$season['season'].'" ORDER BY ep';
    $epstmt = $mysqli->query($querry) or die('SQL Error.');
    while ($ep = mysqli_fetch_assoc($epstmt)) {
      $output .= '<button class="loadButton" id="'.$_GET['show'].'_s'.$season['season'].'e'.$ep['ep'].'" onclick="showOpenEp('.$season['season'].','.$ep['ep'].');iwatched('.$tilde.''.$_GET['show'].'_s'.$season['season'].'e'.$ep['ep'].$tilde.')">'.$ep['ep'].'</button>';
    }
  }
  echo $output;
} else {
  echo "Parameter error.";
}

?>
