function MovieOverlayOn(title) {
  document.getElementById("overlayTitle").innerHTML = title;
  var vidPath = 'videos/movies/'+title+'/vid.mpd';
  document.getElementById("videoPlayer").src = vidPath;
  document.getElementById("showEpSelector").style.display = "none";
  document.getElementById("videoPlayer").style.display="block";
  document.getElementById("movieOverlay").style.display = "block";
}
function ShowOverlayOn(title) {
  document.getElementById("overlayTitle").innerHTML = title;
  scriptPath = "videos/shows/"+title+"/epList.js";
  var script = document.createElement("script");
  script.src = scriptPath;
  document.head.appendChild(script);
  loadEpList();
  document.getElementById("showEpSelector").style.display = "block";
  document.getElementById("videoPlayer").style.display="none";
  document.getElementById("movieOverlay").style.display = "block";
}
function OverlayOff() {
  document.getElementById("movieOverlay").style.display = "none";
  document.getElementById("videoPlayer").pause()
}
