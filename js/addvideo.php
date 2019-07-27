<?php
//Uses auto incremented table
/* OBJECTIVE: add a video watched by a user to the sql database */

$mysqli = new mysqli(/*Server name*/ "127.0.0.1",/*User name*/  "phpuser",/*password*/  "phpuser",/*DB name*/  "users_data");
if($mysqli->connect_error) {
  exit('Could not connect');
}

/* Adds the video to the database with the given index*/
$querry = "INSERT INTO users_watched_3 (username, video) VALUES ";

  $username = $_POST['username'];
  $video = $_POST['video'];
  $finalvar = "('".$username."','".$video."')";
  $mysqli->query($querry.$finalvar);

 ?>
