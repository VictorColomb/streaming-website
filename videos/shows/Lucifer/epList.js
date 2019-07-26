function showOpenEp(season,episode) {
document.getElementById("videoPlayer").style.display="block"; 
var vidPath = "videos/shows/Lucifer/S"+season+"/E"+episode+"/vid/manifest.mpd";
var dwdpath = "videos/shows/Lucifer/S"+season+"/E"+episode+"/vid.mp4";
var player = dashjs.MediaPlayer().create();
player.initialize(document.querySelector("#videoPlayer"), vidPath, true)
document.getElementById("movieOverlay").style.display = "block";
document.getElementById("movieOverlayDownloadButton").download = "Lucifer S"+season+"E"+episode+".mp4";
document.getElementById("movieOverlayDownloadButton").href = dwdpath;
document.getElementById("movieOverlayDownload").style.display = "block"; }

epList = ''.concat('<p class="season">Season 1</p><p>No episodes</p>');
document.getElementById("showEpSelector").innerHTML = epList;