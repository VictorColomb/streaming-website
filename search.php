<?php
  if (!isset($_GET['q'])) {
    header('Location: ./..');
    exit();
  } elseif ($_GET['q']=='') {
    header('Location: ./..');
    exit();
  }
  $mysqli = new mysqli(/*Server name*/ "78.193.98.200",/*User name*/  "phpuser",/*password*/  "phpuser",/*DB name*/  "streaming_server");
  if($mysqli->connect_error) {
    exit('Could not connect');
  }
?>
<!DOCTYPE html>
<html lang="en" dir="ltr">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">

  <title>Streaming - Movies</title>
  <link rel="stylesheet" href="ressources/style.css">
  <link rel="icon" href="ressources/favicon.jpg">
  <script type="text/javascript" src="js/scripts.js"></script>
  <script src="https://cdn.dashjs.org/latest/dash.all.min.js"></script>
  <script type="text/javascript" src="js/cookies.js"></script>
  <style media="screen">
  #header {
    margin-bottom: 30px;
  }

  .movieItem {
    position: relative;
    float:left;
    margin: 0 0.5% 20px;
    box-sizing: border-box;
    cursor: pointer;
    width: 10%;
  }
  @media screen and (max-width: 2000px) {
    .movieItem {
      width: 11.25%;
      margin: 0 0.625% 20px;
    }
  }
  @media screen and (max-width: 1700px) {
    .movieItem {
      width: 12.857%;
      margin: 0 0.7142% 20px;
    }
  }
  @media screen and (max-width: 1400px) {
    .movieItem {
      width: 15%;
      margin: 0 0.8333% 20px;
    }
  }
  @media screen and (max-width: 1000px) {
    .movieItem {
      width: 18%;
      margin: 0 1% 20px;
    }
  }
  @media screen and (max-width: 850px) {
    .movieItem {
      width: 22.5%;
      margin: 0 1.25% 20px;
    }
  }
  @media screen and (max-width: 650px) {
    .movieItem {
      width: 30%;
      margin: 0 1.666% 20px;
    }
  }
  @media screen and (max-width: 400px) {
    .movieItem {
      width: 45%;
      margin: 0 2.5% 20px;
    }
  }
  .showItem {
    position: relative;
    float:left;
    margin: 0 0.5% 20px;
    box-sizing: border-box;
    cursor: pointer;
    width: 10%;
  }
  @media screen and (max-width: 2000px) {
    .showItem {
      width: 11.25%;
      margin: 0 0.625% 20px;
    }
  }
  @media screen and (max-width: 1700px) {
    .showItem {
      width: 12.857%;
      margin: 0 0.7142% 20px;
    }
  }
  @media screen and (max-width: 1400px) {
    .showItem {
      width: 15%;
      margin: 0 0.8333% 20px;
    }
  }
  @media screen and (max-width: 1000px) {
    .showItem {
      width: 18%;
      margin: 0 1% 20px;
    }
  }
  @media screen and (max-width: 850px) {
    .showItem {
      width: 22.5%;
      margin: 0 1.25% 20px;
    }
  }
  @media screen and (max-width: 650px) {
    .showItem {
      width: 30%;
      margin: 0 1.666% 20px;
    }
  }
  @media screen and (max-width: 400px) {
    .showItem {
      width: 45%;
      margin: 0 2.5% 20px;
    }
  }
  </style>
</head>

<body onload="cookiesInit()" onkeydown="OverlayOffKey(event.keyCode)">
  <div id="movieOverlay">
    <div class="movieOverlayFrame">
      <div id="overlayTitleDiv">
        <h1 id="overlayTitle"></h1>
      </div>
      <div id="showEpSelector">
        <!-- List of seasons and episodes, buttons linked to js function that should bring up the desired ep -->
      </div>
      <div id="videoPlayerDiv">
        <video id="videoPlayer" controls></video>
      </div>
    </div>
    <div class="movieOverlayClose"  onclick="OverlayOff()">
      <img src="ressources/Icons/close.png">
    </div>
    <!-- Download button-->
    <div id="movieOverlayDownload">
      <a id="movieOverlayDownloadButton" href="" download="vid.mp4">
        <img src="ressources/Icons/download.png">
      </a>
      <p class="movieOverlayDownloadSize"></p>
    </div>
  </div>

  <div id="header">
    <div class="logo"><a href="../"><img src=ressources/netflix.jpg height=33.2px width=20px></a> </div>
      <div class="leftMenu">
        <ul>
          <li>
            <a href="movies.php">Movies</a>
          </li>
          <li>
            <a href="tvshows.php">TV Shows</a>
          </li>
      </ul>
    </div>

    <div id="loginBtnOverlay" onclick="ToggleLoginOverlay()">
      <p id="loginBtnOverlayText">Not Signed In</p>
    </div>

      <!-- ACTIVATE SEARCH BAR -->
    <div class="search">
      <form action="search.php" method="get">
        <div class="searchbar">
            <input type="text" name="q" placeholder="Search..." value="<?php echo $_GET['q']; ?>">
        </div>
        <div class="searchIcon">
          <input type="image" src="ressources/Icons/search.png">
        </div>
      </form>
    </div>

  </div>

  <!-- Login -->
  <div id="login">
    <p>Enter Username:</p>
    <div class="loginbarContainer">
      <input id="loginbar" type="text" value="" placeholder="Not logged in..." autofocus>
    </div>
    <small id="loginBtn" onclick="loginBtnCLicked();LoginOverlayOff()">Submit</small>
    <script>
      var input = document.getElementById("loginbar");
      input.addEventListener("keyup", function(event) {
        if (event.keyCode === 13) {
          event.preventDefault();
          document.getElementById("loginBtn").click();
        }
      });
    </script>
  </div>

  <!-- CONTENT -->
  <?php
  $query = "SELECT name,type FROM ((SELECT name,type FROM movies WHERE type='movie') UNION (SELECT serie,type FROM movies GROUP BY serie HAVING serie IS NOT NULL)) as shit WHERE name LIKE '%".$_GET['q']."%'";
  $stmt = $mysqli->query($query) or die('SQL ERROR<br>');
  $anyresults = false;
  while ($result = mysqli_fetch_assoc($stmt)) {
    $anyresults = true;
    if ($result['type'] == 'movie') {
      $movie_name_str = $result['name'];
      $movie_id = str_replace("'", ",", str_replace(" ", "_", $movie_name_str));
      $movie_name_str_corr = str_replace("'",",", $movie_name_str);
      $tilde="'";
      echo '<div class="movieItem" id="'.$movie_id.'" onclick="MovieOverlayOn('.$tilde.$movie_name_str_corr.$tilde.');iwatched('.$tilde.$movie_id.$tilde.')"><div class="movie_img_wrap"><img src="videos/movies/'.$movie_name_str.'/thumb.jpg" width="100%"><p class="movie_image_description">'.$movie_name_str.'</p></div></div>';
    } elseif ($result['type'] == 'show_ep') {
      $movie_name_str = $result['name'];
      $movie_name_str_corr = str_replace("'",",", $movie_name_str);
      $tilde="'";
      echo '<div class="showItem" onclick="ShowOverlayOn('.$tilde.$movie_name_str_corr.$tilde.')"><div class="tv_img_wrap"><img src="videos/shows/'.$movie_name_str.'/thumb.jpg"><p class="tv_image_description">'.$movie_name_str.'</p></div></div>';
    }
  }
  if (!$anyresults) {
    echo "No results.";
  }
  ?>

</body>
</html>
