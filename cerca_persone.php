<?php

session_start();

if(empty($_SESSION['id'])){
    header("Location: login.php");
}


$conn = mysqli_connect('127.0.0.1' , 'root', '', 'sociale') or die(mysqli_error($conn));

if(isset($_GET['user'])){
$user = mysqli_real_escape_string($conn, $_SESSION['id']);
$username_search = mysqli_real_escape_string($conn, '%'.$_GET['user'].'%');


$query = "SELECT * from profilo where username LIKE '$username_search' AND id <> '$user'";

$res = mysqli_query($conn, $query);

$peopleArray = array();

while ($people = mysqli_fetch_assoc($res)) {

    $peopleArray[] = array('id' => $people['id'], 'username' => $people['username'],'nome' => $people['nome'],'cognome' => $people['cognome'],'nposts' => $people['nposts'],'image' => $people['image']);
} mysqli_free_result($res);
 echo json_encode($peopleArray);
 // chiudo la connessione
 mysqli_close($conn);
}else if(isset($_GET['z']) && isset($_GET['w'])) {

    $idu = mysqli_real_escape_string($conn, $_GET['z']);
    $query = "SELECT * from profilo where id like $idu";

    $res = mysqli_query($conn, $query);

    $peopleArray = array();

    while ($people = mysqli_fetch_assoc($res)) {
    
        $peopleArray[] = array('idchat' => $_GET['w'], 'id' => $people['id'], 'username' => $people['username'],'nome' => $people['nome'],'cognome' => $people['cognome'],'nposts' => $people['nposts'],'image' => $people['image']);
    } mysqli_free_result($res);
     echo json_encode($peopleArray);
     // chiudo la connessione
     mysqli_close($conn);
    }





?>