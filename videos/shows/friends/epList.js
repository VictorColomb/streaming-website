function showOpenEp(season,episode) {
var vidPath = "videos/shows/Friends/S"+season+"/E"+episode+"/vid.mpd";
document.getElementById("videoPlayer").src = vidPath;
document.getElementById("videoPlayer").style.display="block"; }

function loadEpList() {
epList = '<p class="season">Season 3</p><button class="loadButton" onclick="showOpenEp(3,1)">1</button>'
document.getElementById("showEpSelector").innerHTML = epList; }