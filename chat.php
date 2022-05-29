<?php

session_start();

if(empty($_SESSION['id'])) {
    header('Location: login.php');
}

header('Content-Type: application/json');


$conn = mysqli_connect('127.0.0.1', "root", "", "sociale");

$idu = mysqli_real_escape_string($conn, $_SESSION['id']);



if(isset($_GET['userid'])){
$idc = mysqli_real_escape_string($conn, $_GET['userid']);

$query1 = "SELECT id FROM chats where user1 = $idu and user2 = $idc";

$query2 = "SELECT id FROM chats where user1 = $idc and user2 = $idu";

$res = mysqli_query($conn, $query1);

if(mysqli_num_rows($res) > 0 ) {
    while($entry = mysqli_fetch_array($res)){
    echo json_encode(array('exists' => true, 'idchat' => $entry[0], 'userid' => $idc)); }
} else {
    mysqli_free_result($res);
    $res= mysqli_query($conn, $query2);
    if(mysqli_num_rows($res) > 0 ) {
        while($entry = mysqli_fetch_array($res)) {
        echo json_encode(array('exists' => true,'idchat' => $entry[0], 'userid' => $idc)); }
    } else {
        echo json_encode(array('exists' => false, 'userid' => $idc));
    }
    mysqli_close($conn);
}
} else if(isset($_GET['q'])){

    $idc = mysqli_real_escape_string($conn, $_GET['q']);

    $query = "INSERT INTO chats (user1 , user2) value ($idu, $idc)";

    $res = mysqli_query($conn, $query);
    if($res === true) {
        echo json_encode(array('exists' => true, 'userid' => $idc, 'idchat' => mysqli_insert_id($conn)));
    } else {
    echo json_encode(array('exists' => false));}

    mysqli_close($conn);
    } else if(isset($_GET['idc'])) {

        $idc = mysqli_real_escape_string($conn , $_GET['idc']);

        $query = "SELECT messages.id as idmessage, messages.time as time,
         messages.text as testo, profilo.username as username, profilo.image as image
          FROM messages LEFT JOIN profilo on messages.iduser = profilo.id
           where messages.idchat = $idc ORDER BY messages.id DESC";
    
        $res = mysqli_query($conn, $query);

        $arraymess = array();
        while($mess = mysqli_fetch_assoc($res)) {

            $arraymess[] = array('idmessage' => $mess['idmessage'], 
            'time' => $mess['time'], 'text' => $mess['testo'],
             'username' => $mess['username'], 'image' => $mess['image']);


        } mysqli_free_result($res);
        echo json_encode($arraymess);
        // chiudo la connessione
        mysqli_close($conn);
    
    
    } else if(isset($_POST['idchat'])) {


        $idc = mysqli_real_escape_string($conn, $_POST['idchat']);
        $testo = mysqli_real_escape_string($conn, $_POST['mess']);

        $query = "INSERT INTO messages( idchat, iduser, text) value ('$idc', '$idu', '$testo')";

        $res = mysqli_query($conn, $query);

        if($res === true) {
            echo json_encode(array('exists' => true, 'idchat' => $idc));
        } else {
            echo json_encode(array('exists' => false));
        }
       
        mysqli_close($conn);

    }
?>