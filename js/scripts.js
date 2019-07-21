function MovieOverlayOn(title) {
  document.getElementById("overlayTitle").innerHTML = title;
  var vidPath = 'videos/movies/'+title+'/source/vid.mpd';
  document.getElementById("videoPlayer").src = vidPath;
  document.getElementById("movieOverlay").style.display = "block";
}
function ShowOverlayOn(title) {
  document.getElementById("overlayTitle").innerHTML = title;
  document.getElementById("movieOverlay").style.display = "block";
}

function OverlayOff() {
  document.getElementById("movieOverlay").style.display = "none";
}
