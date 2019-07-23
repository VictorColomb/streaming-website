function MovieOverlayOn(title) {
  document.getElementById("overlayTitle").innerHTML = title;
  var vidPath = 'videos/movies/'+title+'/vid/manifest.mpd';
  var dwdpath = 'videos/movies/'+title+'/vid.mp4';
  var player = dashjs.MediaPlayer().create();  document.getElementById("videoPlayer").style.display="block";
  player.initialize(document.querySelector("#videoPlayer"), vidPath, true);
  document.getElementById("showEpSelector").style.display = "none";
  document.getElementById("videoPlayerDiv").style.margin="40px 0 10px";
  document.getElementById("movieOverlay").style.display = "block";
  //document.getElementById("movieOverlayDownloadButton").href=dwdpath;
  //document.getElementById("movieOverlayDownloadButton").download=title;
}
function ShowOverlayOn(title) {
  document.getElementById("overlayTitle").innerHTML = title;
  scriptPath = "videos/shows/"+title+"/epList.js";
  var script = document.createElement("script");
  script.src = scriptPath;
  document.head.appendChild(script);
  document.getElementById("showEpSelector").style.display = "block";
  document.getElementById("videoPlayer").style.display="none";
  document.getElementById("videoPlayerDiv").style.margin="0 0 10px";
  document.getElementById("movieOverlay").style.display = "block";
}
function OverlayOff() {
  document.getElementById("movieOverlay").style.display = "none";
  document.getElementById("videoPlayer").pause()
}
function OverlayOffKey(e) {
  if (e ==27) {
    OverlayOff()
  }
}
