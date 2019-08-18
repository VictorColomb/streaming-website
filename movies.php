<!DOCTYPE html>

<?php
  $mysqli = new mysqli(/*Server name*/ "localhost",/*User name*/  "phpuser",/*password*/  "phpuser",/*DB name*/  "streaming_server");
  if($mysqli->connect_error) {
    exit('Could not connect');
  }
?>

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
    </style>
  </head>


  <body>
    <div id="movieOverlay">
      <div class="movieOverlayFrame">
        <div id="overlayTitleDiv">
          <h1 id="overlayTitle"></h1>
        </div>
        <div id="showEpSelector">
          <!-- List of seasons and episodes, buttons linked to js function that should bring up the desired ep -->
        </div>
        <div id="videoPlayerDiv">
          <video id="videoPlayer" data-dashjs-player autoplay src="" controls>
            Your browser does not support the VIDEO tag and/or RTP streams.
          </video>
        </div>
      </div>
      <div class="movieOverlayClose"  onclick="OverlayOff()">
        <img src="ressources/Icons/close.png">
      </div>
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
          <li style="background-color: #333;">
            <a href="movies.php">Movies</a>
          </li>
          <li>
            <a href="tvshows.php">TV Shows</a>
          </li>
        </ul>
      </div>
      <div class="search">
        <form action="search.php" method="get">
          <div class="searchbar">
              <input type="text" name="q" placeholder="Search...">
          </div>
          <div class="searchIcon">
            <input type="image" src="ressources/Icons/search.png">
          </div>
        </form>
      </div>
    </div>

    <div id="sortSelector">
      <div id="sortSelectorInside">
        <div id="sortDropdown">
          <a href="?sort=name">Name</a>
          <a href="?sort=date_added">Date added</a>
          <a href="?sort=date_released">Date released</a>
        </div>
        <button id="sortButton">Sort by</button>
      </div>
    </div>

    <div id="content" style="margin:30px 2% 10px;">
      <?php
        $querry = "SELECT name FROM movies WHERE type='movie' ORDER BY ";
        /* bind_param("s",$_POST['sort']) SI le parametre POST existe et bind_param("s","name") sinon*/
        if (isset($_GET['sort'])) {
          if ($_GET['sort']=='date_released') {
            $sort = 'date_released DESC';
          } elseif ($_GET['sort']=='date_added') {
            $sort = 'date_added DESC';
          } else {
            $sort = $_GET['sort'];
          }
          $stmt = $mysqli->query($querry.$sort) or die('SQL ERROR<br>'.mysqli_error());
        } else {
          $sort = 'name';
          $stmt = $mysqli->query($querry.$sort) or die('SQL ERROR<br>'.mysqli_error());
        }
        while ($movie_name = mysqli_fetch_assoc($stmt)) {
          $movie_name_str = $movie_name['name'];
          $movie_id = str_replace("'", ",", str_replace(" ", "_", $movie_name_str));
          $movie_name_str_corr = str_replace("'",",", $movie_name_str);
          $tilde="'";
          echo '<div class="movieItem" id="'.$movie_id.'" onclick="MovieOverlayOn('.$tilde.$movie_name_str_corr.$tilde.');iwatched('.$tilde.$movie_id.$tilde.')"><div class="movie_img_wrap"><img src="videos/movies/'.$movie_name_str.'/thumb.jpg" width="100%"><p class="movie_image_description">'.$movie_name_str.'</p></div></div>';
        }
      ?>
    </div>
  </body>
</html>
