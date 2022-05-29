<?php

session_start();


if(!isset($_SESSION['id'])) {
    header("Location: login.php");
}
header('Content-Type: application/json');

$conn = mysqli_connect("127.0.0.1", "root", "", "sociale");

$user = mysqli_real_escape_string($conn, $_SESSION['id']);

$query = "SELECT username , nome, cognome, image, nposts from profilo where id = '$user'";

$res = mysqli_query($conn, $query);

$peopleArray = array();

while($people = mysqli_fetch_assoc($res)) {
    $peopleArray[] = array('username' => $people['username'],  'nome' => $people['nome'], 'cognome' => $people['cognome'], 'image' => $people['image'], 'nposts' => $people['nposts']);
}

echo json_encode($peopleArray);
mysqli_close($conn);





?>