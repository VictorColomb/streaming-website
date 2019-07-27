<?php
/* OBJECTIVE: returns the list of videos from an sql database given a user's name*/

$mysqli = new mysqli(/*Server name*/ "78.193.98.200",/*User name*/  "phpuser",/*password*/  "phpuser",/*DB name*/  "`streaming_server`");
if($mysqli->connect_error) {
  exit('Could not connect');
}

$querry = "SELECT video FROM users_watched WHERE username = ?";

if ($stmt = $mysqli->prepare($querry)) {
  /* Binds the variable to the querry */
  $stmt->bind_param("s", $_GET['q']);

  /* Executes querry */
  $stmt->execute();

  /* Stores the result (to get properties)*/
  $stmt->store_result();

  /* Gets the number of rows */
  $nb_rows = $stmt->num_rows;

  /* Binds the result to the variable*/
  $stmt->bind_result($video_id);

  /* Outputs the results */
  while ($stmt->fetch()) {
    echo $video_id.';';
  }

  /* free result */
  $stmt->free_result();

  /* close statement*/
  $stmt->close();
}
 ?>
