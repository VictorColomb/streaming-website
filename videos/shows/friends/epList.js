function showOpenEp(season,episode) {
var vidPath = "videos/shows/Friends/S"+season+"/E"+episode+"/vid.mp4";
document.getElementById("videoPlayer").src = vidPath;
document.getElementById("videoPlayer").style.display="block"; }

function loadEpList() {
epList = '<p class="season">Season 1</p><button class="loadButton" onclick="showOpenEp(1,1)">1</button><p class="season">Season 2</p><p>No episodes</p><p class="season">Season 3</p><button class="loadButton" onclick="showOpenEp(3,1)">1</button>'
document.getElementById("showEpSelector").innerHTML = epList; }
