var movieOverlayisOn = false;
var loginOverlayisOn = false;

function MovieOverlayOn(title) {
  var goodTitle = title.replace(/,/g,"'");
  document.getElementById("overlayTitle").innerHTML = goodTitle;
  var vidPath = 'videos/movies/'+goodTitle+'/vid/manifest.mpd';
  var dwdpath = 'videos/movies/'+goodTitle+'/vid.mp4';
  var player = dashjs.MediaPlayer({}).create();  document.getElementById("videoPlayer").style.display="block";
  player.initialize(document.querySelector("#videoPlayer"), vidPath, true);
  document.getElementById("showEpSelector").style.display = "none";
  document.getElementById("videoPlayerDiv").style.margin="40px 0 10px";
  document.getElementById("movieOverlay").style.display = "block";
  document.getElementById("movieOverlayDownloadButton").href = dwdpath;
  document.getElementById("movieOverlayDownloadButton").download = goodTitle+'.mp4';
  document.getElementById("movieOverlayDownload").style.display = "block";
  //document.getElementById("movieOverlayDownloadButton").href=dwdpath;
  //document.getElementById("movieOverlayDownloadButton").download=title;
}
function ShowOverlayOn(title) {
  var goodTitle = title.replace(/,/g,"'");
  document.getElementById("overlayTitle").innerHTML = goodTitle;
  var jsContent = 'function showOpenEp(season,episode) { document.getElementById("videoPlayer").style.display="block";  var vidPath = "videos/shows/'+goodTitle+'/S"+season+"/E"+episode+"/vid/manifest.mpd"; var dwdpath = "videos/shows/'+goodTitle+'/S"+season+"/E"+episode+"/vid.mp4"; var player = dashjs.MediaPlayer().create(); player.initialize(document.querySelector("#videoPlayer"), vidPath, true); document.getElementById("movieOverlay").style.display = "block"; document.getElementById("movieOverlayDownloadButton").download = "'+goodTitle+' S"+season+"E"+episode+".mp4"; document.getElementById("movieOverlayDownloadButton").href = dwdpath; document.getElementById("movieOverlayDownload").style.display = "block"; }';
  var script = document.createElement('script');
  script.innerHTML = jsContent;
  document.head.appendChild(script);

  xmlhttp = new XMLHttpRequest();
  xmlhttp.onreadystatechange = function() {
    if (this.readyState==4 && this.status==200) {
      var epList = this.responseText;
      document.getElementById("showEpSelector").innerHTML = epList;
      console.log("Loaded episode list for "+goodTitle);
    }
  }
  xmlhttp.open("GET","js/geteplist.php?show="+title.replace(/ /g,"+"),true);
  xmlhttp.send();

  document.getElementById("showEpSelector").style.display = "block";
  document.getElementById("videoPlayer").style.display="none";
  document.getElementById("videoPlayerDiv").style.margin="0 0 10px";
  document.getElementById("movieOverlayDownload").style.display = "none";
  document.getElementById("movieOverlay").style.display = "block";
}
function OverlayOff() {
  document.getElementById("movieOverlay").style.display = "none";
  document.getElementById("videoPlayer").pause()
}
function OverlayOffKey(e) {
  if (e == 27) {
    OverlayOff()
    LoginOverlayOff()
  }
}

function LoginOverlayOn() {
  console.log("Oppened Login Overlay");
  document.getElementById("login").style.display = "block";
  document.getElementById("loginBtnOverlay").style.background = "#333";
  loginOverlayisOn = true;
}
function LoginOverlayOff() {
  console.log("Shut Login Overlay");
  document.getElementById("login").style.display = "none";
  document.getElementById("loginBtnOverlay").style.background = "black";
  loginOverlayisOn = false;
}

function ToggleLoginOverlay(){
  if (loginOverlayisOn) {
    LoginOverlayOff();
  }
  else {
    LoginOverlayOn();
  }
}
