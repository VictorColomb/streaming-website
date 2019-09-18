<!DOCTYPE html>


<?php
  error_reporting(0);
  $mysqli = new mysqli(/*Server name*/ "localhost",/*User name*/  "phpuser",/*password*/  "phpuser",/*DB name*/  "streaming_server");
  if($mysqli->connect_error) {
    exit('Could not connect to database');
  }
  $day = date('d');
  $month = date('m');
  $year = date('Y');

if (isset($_GET['submit']) and isset($_POST['year'])) {
  if ($_GET['submit'] == 'movies') {
    $submitted = "";
    foreach($_POST['name'] as $key => $value) {
      if (strlen($_POST['year'][$key])==4 and strlen($_POST['month'][$key])==2 and strlen($_POST['day'][$key])==2) {
        $querry = 'INSERT IGNORE INTO movies (name, type, date_added, date_released) VALUES ("'.$_POST['name'][$key].'","movie","'.$year.'-'.$month.'-'.$day.'","'.$_POST['year'][$key].'-'.$_POST['month'][$key].'-'.$_POST['day'][$key].'")';
        $submitted .= $querry."\r\n";
        $mysqli->query($querry);
      }
    }
    ?>
    <script>
      alert("Submitted movies");
      console.log("<?php echo $submitted; ?>");
    </script>
    <?php
  } elseif ($_GET['submit'] == 'shows') {
    $submitted = "";
    foreach($_POST['show'] as $key => $value) {
      if (strlen($_POST['year'][$key])==4 and strlen($_POST['month'][$key])==2 and strlen($_POST['day'][$key])==2) {
        $querry = 'INSERT IGNORE INTO movies (name, type, date_added, date_released, season, ep, serie) VALUES ("'.$_POST['show'][$key].'_s'.$_POST['season'][$key].'e'.$_POST['episode'][$key].'","show_ep","'.$year.'-'.$month.'-'.$day.'","'.$_POST['year'][$key].'-'.$_POST['month'][$key].'-'.$_POST['day'][$key].'","'.$_POST['season'][$key].'","'.$_POST['episode'][$key].'","'.$_POST['show'][$key].'")';
        $submitted .= $querry."\r\n";
        $mysqli->query($querry);
      }
    }
    ?>
    <script>
      alert("Submitted shows");
      console.log("<?php echo $submitted; ?>");
    </script>
    <?php
  }
}
?>


<html lang="en" dir="ltr">
  <head>
    <meta charset="utf-8">
    <title>Streaming - Fill database</title>
    <link rel="icon" href="../ressources/favicon.jpg">
    <script src="https://code.jquery.com/jquery-3.4.1.js" integrity="sha256-WpOohJOqMqqyKL9FccASB9O0KwACQJpFTUBLTYOVvVU=" crossorigin="anonymous"></script>
    <style media="screen">
      h2,h3,h4,h5 {
        display: inline;
      }
      a {
        text-decoration: none;
        color: black;
      }
    </style>
  </head>
  <body>
    <a href="."><h1>Submitting entries to the database</h1></a>
    <!-- MOVIES -->
    <h2>Movies</h2>
    <form class="moviesSubmit" action="?submit=movies" method="post">
    <?php
    $dir_path = './../videos/movies';
    $dir = array_diff(scandir($dir_path), array('..', '.'));
    foreach ($dir as $key => $movie) {
      if (is_dir($dir_path."/".$movie)) {
        $stmt = $mysqli->query('SELECT name FROM movies WHERE name="'.$movie.'" LIMIT 1');
        if (mysqli_fetch_row($stmt) == false) {
          echo '<h3 style="margin:0;">'.$movie."</h3>";
          $response = file_get_contents("http://www.omdbapi.com/?apikey=!!!YOUR-OMDB-KEY!!!&t=".urlencode($movie));
          $response = json_decode($response,true);
          if (isset($response['Response']) and $response['Response'] == 'True') {
            $date = strtotime(str_replace(" ", "-", $response['Released']));
            ?>
            <input type="hidden" name="name[]" value="<?php echo $movie; ?>">
            <input class="shit" type="text" name="year[]" value="<?php echo date("Y",$date); ?>" size="4" maxlength="4">
            <input class="shit" type="text" name="month[]" value="<?php echo date("m",$date); ?>" size="2" maxlength="2">
            <input class="shit" type="text" name="day[]" value="<?php echo date("d",$date); ?>" size="2" maxlength="2"><br>
            <?php
          } else {
            ?>
            <input type="hidden" name="name[]" value="<?php echo $movie; ?>">
            <input class="shit" type="text" name="year[]" placeholder="YYYY" size="4" maxlength="4">
            <input class="shit" type="text" name="month[]" placeholder="MM" size="2" maxlength="2">
            <input class="shit" type="text" name="day[]" placeholder="DD" size="2" maxlength="2"><br>
            <?php
          }
        }
      }
    }
    ?>
    <div class="submitClass" style="margin: 30px 0;">
      <input type="submit" name="submitMovies" value="Submit movies to db">
    </div>
    </form>



    <!-- SHOWS -->
    <br><h2>Shows</h2>
    <form class="showsSubmit" action="?submit=shows" method="post">
    <?php
    $dir_path = './../videos/shows';
    $dir = array_diff(scandir($dir_path), array('..', '.'));
    foreach ($dir as $key => $show) {
      if (is_dir($dir_path."/".$show)) {
        $isthereseason = true;
        $showid = str_replace(' ','_',str_replace("'",",",$show));

        $dirdir = array_diff(scandir($dir_path."/".$show), array('..', '.'));
        foreach ($dirdir as $keykey => $season) {
          if (is_dir($dir_path."/".$show."/".$season) and substr($season,0,1)=="S") {
            $isthereep = true;
            $seasonNo = substr($season,1);
            $dirdirdir = array_diff(scandir($dir_path."/".$show."/".$season), array('..', '.'));
            foreach ($dirdirdir as $keykeykey => $ep) {
              if (is_dir($dir_path."/".$show."/".$season."/".$ep) and substr($ep,0,1)=="E") {
                $stmt = $mysqli->query('SELECT name FROM movies WHERE name="'.$show."_".$season.$ep.'" LIMIT 1');
                if (mysqli_fetch_row($stmt) == false) {
                  $epNo = substr($ep,1);
                  if ($isthereseason) {
                    echo '<h3 id="'.$showid.'" style="margin:0;">'.$show."</h3>";
                  }
                  $isthereseason = false;
                  if ($isthereep) {
                    echo '<br><h4 id="'.$showid.'_S'.$seasonNo.'" style="margin:0;">Season '.$seasonNo."</h4>";
                  }
                  $isthereep = false;
                  echo '<br><h5 style="margin:0;">Episode '.$epNo."</h5>";
                  $response = file_get_contents("http://www.omdbapi.com/?apikey=!!!YOUR-OMDB-KEY!!!&t=".urlencode($show)."&season=".$seasonNo."&episode=".$epNo);
                  $response = json_decode($response,true);
                  if (isset($response['Response']) and $response['Response']=='True') {
                    $date = strtotime(str_replace(" ", "-", $response['Released']));
                    ?>
                    <input type="hidden" name="show[]" value="<?php echo $show ?>">
                    <input type="hidden" name="season[]" value="<?php echo $seasonNo; ?>">
                    <input type="hidden" name="episode[]" value="<?php echo $epNo; ?>">
                    <input class="shit" type="text" name="year[]" value="<?php echo date("Y",$date); ?>" size="4" maxlength="4">
                    <input class="shit" type="text" name="month[]" value="<?php echo date("m",$date); ?>" size="2" maxlength="2">
                    <input class="shit" type="text" name="day[]" value="<?php echo date("d",$date); ?>" size="2" maxlength="2"><br>
                    <?php
                  } else {
                    ?>
                    <input type="hidden" name="show[]" value="<?php echo $show ?>">
                    <input type="hidden" name="season[]" value="<?php echo $seasonNo; ?>">
                    <input type="hidden" name="episode[]" value="<?php echo $epNo; ?>">
                    <input class="shit" type="text" name="year[]" placeholder="YYYY" size="4" maxlength="4">
                    <input class="shit" type="text" name="month[]" placeholder="MM" size="2" maxlength="2">
                    <input class="shit" type="text" name="day[]" placeholder="DD" size="2" maxlength="2"><br>
                    <?php
                  }
                }
              }
            }
          }
        }
      }
    }
    ?>
    <div class="submitClass" style="margin: 30px 0;">
      <input type="submit" name="submitShow" value="Submit shows to db">
    </div>
    </form>
    <script>
      $('.shit').keyup(function() {
        if(this.value.length >= $(this).attr('maxlength'))
        {
          $(this).next().focus();
        }
      });
    </script>
  </body>
</html>
