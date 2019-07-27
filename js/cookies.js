//OBJECTIVE: Show the user wich shows he has already seen

//list wich stores the id of videos already watched by user
var watched = [];

//list storing
var added_watched = [];

//the username of the current user
//idealy not all usernames are loaded on to the users machine
//however no other easy available options
var username;
var requests;

//sets a cookie value given a cookie name
function setCookie(name,value) {
    document.cookie = name + "=" + (value || "");
}

//gets a cookie value given a cookie name
function getCookieValue(name) {
    var b = document.cookie.match('(^|[^;]+)\\s*' + name + '\\s*=\\s*([^;]+)');
    return b ? b.pop() : '';
}

//saves the videos watched by a given user-----------------------------Giga pas optimiser
function setWatched() {
  for (vid of added_watched) {
    xmlhttp = new XMLHttpRequest();
    xmlhttp.open("POST","js/addvideo.php",true);
    xmlhttp.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");
    xmlhttp.send("username=" + username + "&video=" + vid);
    console.log(vid + ' was removed');
  }
  added_watched = [];
}

//initializes the script
function cookiesInit() {
  //tries signing you in using cookies
  username = getCookieValue("username");

  if (username != null && username != "") {signIn(username)}
}

//changes the color of text of already watched stuff
function iwatched(title){
  console.log(title + ' was watched');
  if (watched.indexOf(title) == -1) {
    //modifies watched
    visualChange(title);
    watched.push(title);
    added_watched.push(title);
    console.log('it was added to added_watched');
    //if the user is logged in, saves his current activity
    if (username != null && username != "") {
      setWatched()
    }
  }
}

function loginBtnCLicked() {
  var val = document.getElementById('loginbar').value;
  if (val != null) {
    signIn(val);
  }
}

function visualChange(el) {
  //cresates a  new style for elements with id el
  var style = document.createElement('style');
  style.innerHTML =
  	'#' + el + ' {' +
      'background-color: red;'
  	'}';

  // Get the first script tag
  var ref = document.querySelector('script');

  // Insert our new styles before the first script tag
  ref.parentNode.insertBefore(style, ref)
}

//signs a user in
function signIn(name){
  //alert("Welcome " + name);
  username = name;
  document.getElementById("loginbar").value = name;
  document.getElementById("loginBtnOverlayText").innerHTML = "Welcome " + name;
  setCookie("username", username)
  console.log("Username: " + username);

  //http request to obtain the list of videos already watched by the user
  //the request returns a string composed of video ids seperated by ;
  xmlhttp = new XMLHttpRequest();
  xmlhttp.onreadystatechange = function() {
  if (this.readyState==4 && this.status==200)
    {
      var responseString = this.responseText;
      var serverResponse = responseString.split(';');
      console.log(responseString);
        //loads the list of videos the user has already seen
        if (serverResponse != null) {
          for (var el of serverResponse) { if (!(el in watched) && el != '') {watched.push(el); console.log('Already watched: ' +  el);visualChange(el)} }
        }

        setWatched()
    }
  }
  xmlhttp.open("GET","js/getuser.php?q=" + username,true);
  xmlhttp.send();

}
