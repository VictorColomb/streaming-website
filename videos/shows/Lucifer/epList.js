function showOpenEp(season,episode) {
document.getElementById("videoPlayer").style.display="block"; 
var vidPath = "videos/shows/Lucifer/S"+season+"/E"+episode+"/vid/manifest.mpd";
var player = dashjs.MediaPlayer().create();
player.initialize(document.querySelector("#videoPlayer"), vidPath, true); }

epList = ''.concat('<p class="season">Season 1</p><p>No episodes</p>');
document.getElementById("showEpSelector").innerHTML = epList;