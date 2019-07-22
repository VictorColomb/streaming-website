function showOpenEp(season,episode) {
document.getElementById("videoPlayer").style.display="block"; 
var vidPath = "videos/shows/La Casa de Papel/S"+season+"/E"+episode+"/vid/manifest.mpd";
var player = dashjs.MediaPlayer().create();
player.initialize(document.querySelector("#videoPlayer"), vidPath, true); }

epList = '<p class="season">Season 1</p><button class="loadButton" onclick="showOpenEp(1,1)">1</button>'
document.getElementById("showEpSelector").innerHTML = epList;