<?php

/* OBJECTIVE: add a video watched by a user to the sql database */

$mysqli = new mysqli(/*Server name*/ "127.0.0.1",/*User name*/  "phpuser",/*password*/  "phpuser",/*DB name*/  "users_data");
if($mysqli->connect_error) {
  exit('Could not connect');
}

/* Finds the smallest unused index*/
$querry = "SELECT COUNT(id) FROM users_watched";

if ($stmt = $mysqli->prepare($querry)) {
  /* Executes quarry */
  $stmt->execute();

  /*Saves the result to $smallestIndex*/
  $stmt->store_result();
  $stmt->bind_result($smallestIndex);
  $stmt->fetch();

  /* close statement*/
  $stmt->close();
}


/* Adds the video to the database with the given index*/
$querry = "INSERT INTO users_watched (id,username, video) VALUES ";

  $username = $_POST['username'];
  $video = $_POST['video'];
  $finalvar = "(".$smallestIndex.",'".$username."','".$video."')";
  $mysqli = new mysqli(/*Server name*/ "127.0.0.1",/*User name*/  "phpuser",/*password*/  "phpuser",/*DB name*/  "users_data");
  $mysqli->query($querry.$finalvar);

 ?>
