<?php
session_start();

if(empty($_SESSION['id'])){
    header('Location: login.php');
}

$conn = mysqli_connect("127.0.0.1", "root", "", "sociale");
$idu = mysqli_real_escape_string($conn, $_SESSION['id']);


if(isset($_GET['q'])){

    $idp = mysqli_real_escape_string($conn, $_GET['q']);

    $query = "INSERT INTO likes (user, post) VALUES ( '$idu', '$idp')";

    $res= mysqli_query($conn, $query);

    if ($res === true) {
        echo json_encode(array('postid' => $idp, 'exists' => true));
    } else {
        echo json_encode(array('exists' => false));
    }

 
    mysqli_close($conn);
    exit;
} else if(isset($_GET['p'])){
    $idp = mysqli_real_escape_string($conn, $_GET['p']);

    $query = "DELETE from likes WHERE user = $idu and post = $idp";

    $res= mysqli_query($conn, $query);

    
        echo json_encode(array('exists' => true, 'idp' => $idp));
    

   
    mysqli_close($conn);
    exit;
}



?>