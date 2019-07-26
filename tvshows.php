<!DOCTYPE html>
<html lang="en" dir="ltr">
  <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <title>Streaming - TV Shows</title>
    <link rel="stylesheet" href="ressources/style.css">
    <link rel="icon" href="ressources/favicon.jpg">
    <script type="text/javascript" src="js/scripts.js"></script>
    <script src="https://cdn.dashjs.org/latest/dash.all.min.js"></script>
    <script type="text/javascript" src="js/cookies.js"></script>
    <style media="screen">
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
          <li>
            <a href="movies.php">Movies</a>
          </li>
          <li style="background-color: #333;">
            <a href="tvshows.php">TV Shows</a>
          </li>
        </ul>
      </div>
      <!-- ACTIVATE SEARCH BAR -->
      <div class="search">
        <div class="searchIcon">
          <img src="ressources/Icons/search.png">
        </div>
        <div class="searchbar">
          <input type="text" value="" name="search_box" placeholder="Search...">
        </div>
      </div>
    </div>

    <div id="content" style="margin:30px 2% 10px;">
<?php
        $fn = fopen("js/shows.txt","r");
        $result = fgets($fn);
        echo $result;
        fclose($fn);
?>
    </div>
  </body>
</html>
