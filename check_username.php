

<?php

session_start();


    header('Content-Type: application/json');
    //connessione all DB
    $conn = mysqli_connect('127.0.0.1', 'root', '', 'sociale') or die("Errore : ".mysqli_connect_error());
    // escape dell'imput
    $username = mysqli_real_escape_string($conn, $_GET["username"]);
    //scrivo la query per cercare in base al username
    $query = "SELECT username FROM profilo WHERE username = '$username'";

    $res = mysqli_query($conn, $query) or die("Errore : ".mysqli_error($conn));
    // scrivo il json tramite  il PHP


    echo json_encode(array('exists' => mysqli_num_rows($res) > 0 ? true : false));
    
    
    // chiudo la connessione
    mysqli_close($conn);
?>
