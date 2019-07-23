//creates cookies to know if a user has already watched a movie or tv-show

//dictionnarie wich store if the user has or hasnt watched a movie or tv-show
//the key is a string (the movie or tv-show name) and the value is a boolean (watched or not)
var watched = {"Shutter_Island":false};

//get or sets a cookie
function setCookie(name,value) {
    document.cookie = name + "=" + (value || "");
}

function getCookieValue(name) {
    var b = document.cookie.match('(^|[^;]+)\\s*' + name + '\\s*=\\s*([^;]+)');
    return b ? b.pop() : '';
}

function cookiesInit() {
  //finds all available Movies WIP
  //watched = JSON.parse(content);

  //loads the cookies to see which vidos the user has already seen
  watchedCookie = getCookieValue("watched");
  if (watchedCookie != null) {
    for (var key in watched) {if (watchedCookie.hasOwnProperty(key)) {watched[key] = watchedCookie[key];document.getElementById(key).style.color = "red";}}
  }
}

//changes the color of text of already watched stuff
function iwatched(title){
  watched[title] = true;
  setCookie("watched",watched);
  document.getElementById(title).style.color = "red";
}
