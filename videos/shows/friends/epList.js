function showOpenEp(season,episode) {
var vidPath = "videos/shows/Friends/S"+season+"/E"+episode+"/vid/manifest.mpd";
document.getElementById("videoPlayer").src = vidPath;
document.getElementById("videoPlayer").style.display="block"; }

epList = '<p class="season">Season 3</p><button class="loadButton" onclick="showOpenEp(3,1)">1</button>'
document.getElementById("showEpSelector").innerHTML = epList;