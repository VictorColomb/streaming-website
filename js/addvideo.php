<?php
//Uses auto incremented table
/* OBJECTIVE: add a video watched by a user to the sql database */

$mysqli = new mysqli(/*Server name*/ "localhost",/*User name*/  "phpuser",/*password*/  "phpuser",/*DB name*/  "streaming_server");
if($mysqli->connect_error) {
  exit('Could not connect');
}

/* Adds the video to the database with the given index*/
$querry = "INSERT INTO users_watched (username, video) VALUES ";

  $username = $_POST['username'];
  $video = $_POST['video'];
  $finalvar = "('".$username."','".$video."')";
  $mysqli->query($querry.$finalvar);

 ?>
