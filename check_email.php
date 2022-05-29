<?php

session_start();

header('Content-Type: application/json');
    //connessione all DB
    $conn = mysqli_connect('127.0.0.1', 'root', '', 'sociale') or die("Errore : ".mysqli_connect_error());
    // escape dell'imput
    $email = mysqli_real_escape_string($conn, $_GET["email"]);
    //scrivo la query per cercare in base al username
    $query = "select * from profilo where email = '$email'";

    $res = mysqli_query($conn, $query) or die("Errore : ".mysqli_connect_error());
    // scrivo il json tramite  il PHP
    echo json_encode(array('exists' => mysqli_num_rows($res) > 0 ? true : false));
    // chiudo la connessione
    mysqli_close($conn);
?>
