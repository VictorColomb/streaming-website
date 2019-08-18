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

    <title>Streaming</title>
    <link rel="icon" href="ressources/favicon.jpg">
    <!--Style Sheet-->
    <link rel="stylesheet" href="ressources/style.css">
    <script type="text/javascript" src="js/scripts.js"></script>
    <script src="https://cdn.dashjs.org/latest/dash.all.min.js"></script>
    <script type="text/javascript" src="js/cookies.js"></script>
    <style media="screen">
      .descriptionBox{
        margin: 0 0 50px 0;
      }
      .showItem {
        position: relative;
        float:left;
        margin: 0 1.666% 20px;
        box-sizing: border-box;
        cursor: pointer;
        width: 19.168%;
      }
      .movieItem {
        position: relative;
        float:left;
        margin: 0 1.666% 20px;
        box-sizing: border-box;
        cursor: pointer;
        width: 19.168%;
      }
      @media screen and (max-width: 1650px) {
        .movieItem img {
          height: 180px;
        }
        .showItem img {
          height: 180px;
        }
      }
      @media screen and (max-width: 1450px) {
        .movieItem img {
          height: 160px;
        }
        .showItem img {
          height: 160px;
        }
      }
      @media screen and (max-width: 1300px) {
        .movieItem {
          width: 30%;
        }
        .movieItem img {
          height: 200px;
        }
        .showItem {
          width: 30%;
        }
        .showItem img {
          height: 200px;
        }
      }
      @media screen and (max-width: 1100px) {
        .movieItem img {
          height: 180px;
        }
        .showItem img {
          height: 180px;
        }
      }
      @media screen and (max-width: 1000px) {
        .movieItem img {
         height: 160px;
        }
        .showItem img {
         height: 160px;
        }
      }
      @media screen and (max-width: 900px) {
        .movieItem {
          width: 46.668%;
        }
        .movieItem img {
          height: 200px;
        }
        .showItem {
          width: 46.668%;
        }
        .showItem img {
          height: 200px;
        }
      }
      @media screen and (max-width: 700px) {
        .movieItem img {
         height: 180px;
        }
        .showItem img {
         height: 180px;
        }
      }
      @media screen and (max-width: 600px) {
        .movieItem img {
         height: 160px;
        }
        .showItem img {
         height: 160px;
        }
      }
      @media screen and (max-width: 500px) {
        .movieItem img {
         height: 140px;
        }
        .showItem img {
         height: 140px;
        }
      }
      @media screen and (max-width: 400px) {
        .movieItem {
          width: 96.668%;
        }
        .movieItem img {
          height: 200px;
        }
        .contentMovies {
          margin-left: 1.5%;
        }
        .showItem {
          width: 96.668%;
        }
        .showItem img {
          height: 200px;
        }
        .contentTVShow {
          margin-right: 1.5%
        }
      }
      @media screen and (max-width: 200px) {
        .movieItem img {
         height: 180px;
        }
        .showItem img {
         height: 180px;
        }
      }
    </style>
  </head>


  <body onload="cookiesInit()" onkeydown="OverlayOffKey(event.keyCode)">
    <!-- Finds the watched and unwatched videos of a user through cookies-->
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
      <div class="logo"><a href="."><img src=ressources/netflix.jpg height=33.2px width=20px></a> </div>
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

    <div id="content">
      <div class="contentMovies">
        <div class="contentTitle">
          <a href="movies.php"><h3>Movies</h3></a>
        </div>
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

      <div class="contentTVShow">
        <div class="contentTitle">
          <a href="tvshows.php"><h3>TV Shows</h3></a>
        </div>
<?php
  $querry = "SELECT serie FROM (SELECT serie, MAX(date_added) as da, MAX(date_released) as dr FROM movies GROUP BY serie HAVING serie IS NOT NULL) as shit ORDER BY ";
  /* bind_param("s",$_POST['sort']) SI le parametre POST existe et bind_param("s","name") sinon*/
  if (isset($_GET['sort'])) {
    if ($_GET['sort'] == 'date_added') {
      $sort='da DESC';
    }
    else if ($_GET['sort'] == 'date_released') {
      $sort='dr DESC';
    }
    else {
      $sort='serie';
    }
  } else {
    $sort = 'serie';
  }
  $stmt = $mysqli->query($querry.$sort) or die('SQL ERROR<br>'.mysqli_error());
  while ($movie_name = mysqli_fetch_assoc($stmt)) {
    $movie_name_str = $movie_name['serie'];
    $movie_name_str_corr = str_replace("'",",", $movie_name_str);
    $tilde="'";
    echo '<div class="showItem" onclick="ShowOverlayOn('.$tilde.$movie_name_str_corr.$tilde.')"><div class="tv_img_wrap"><img src="videos/shows/'.$movie_name_str.'/thumb.jpg"><p class="tv_image_description">'.$movie_name_str.'</p></div></div>';
  }
?>
      </div>
    </div>
    <script id='showJS'></script>
  </body>
</html>
