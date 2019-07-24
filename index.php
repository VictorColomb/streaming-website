<!DOCTYPE html>

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
      @media screen and (max-width: 738px) {
        .showItem img {
          width: 110px;
          height: 146.6px;
        }
      }
      @media screen and (max-width: 738px) {
        .movieItem img {
          width: 110px;
          height: 146.6px;
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
        <a id="movieOverlayDownloadButton" href="" download="">
          <img src="ressources/Icons/download.png" style="width:75%; display:none;">
        </a>
        <p class="movieOverlayDownloadSize"></p>
      </div>
    </div>

    <div id="header">
      <div class="logo"><img src=ressources/netflix.jpg height=33.2px width=20px></div>
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

      <!-- Login -->
      <div class="login">
        <div class="loginbarContainer">
          <input class="loginbar" type="text" value="" name="search_box" placeholder="Not logged in...">
        </div>
        <div class="loginBtn">
          <p onclick="loginBtnCLicked()" >log-in</p>
        </div>
      </div>

        <!-- ACTIVATE SEARCH BAR -->
      <div class="search">
        <div class="searchbar">
          <input type="text" value="" name="search_box" placeholder="Search...">
        </div>
        <div class="searchIcon">
          <img src="ressources/Icons/search.png">
        </div>
      </div>

    </div>

    <div id="content" style="margin: 0;">
      <div class="contentMovies" style="margin-left:4%; margin-right:2%; width: 41.5%;">
        <a href="movies.php"><h3>Movies</h3></a>
<?php
          $fn = fopen("js/movies.txt","r");
          $result = fgets($fn);
          echo $result;
          fclose($fn);
?>
      </div>

      <div class="contentTVShow" style="margin-right:4%; margin-left:2%; width: 41.5%;">
        <a href="tvshows.php"><h3>TV Shows</h3></a>
<?php
        $fn = fopen("js/shows.txt","r");
        $result = fgets($fn);
        echo $result;
        fclose($fn);
?>
      </div>
    </div>

  </body>
</html>
