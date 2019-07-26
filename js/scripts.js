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
  scriptPath = "videos/shows/"+goodTitle+"/epList.js";
  var script = document.createElement("script");
  script.src = scriptPath;
  document.head.appendChild(script);
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
