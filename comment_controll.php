<?php

session_start();

if(empty($_SESSION['id'])){
    header('Location: logout.php');
}


$conn = mysqli_connect('127.0.0.1', "root", "", "sociale");

$idu = mysqli_real_escape_string($conn, $_SESSION['id']);


if(isset($_GET['q'])){
$idp = mysqli_real_escape_string($conn, $_GET['q']);

$query = "SELECT comments.id as idcomment, comments.post as idcompost,
 comments.text as text, comments.time as time , comments.user as iduser,
  profilo.username as username, profilo.image as image,
   profilo.id as idu
    from comments LEFT JOIN profilo on comments.user = profilo.id where comments.post = '$idp'";

$res = mysqli_query($conn, $query);

$arraycomm = array();
while($comm =  mysqli_fetch_assoc($res)){

    $your = $comm['idu'] !== $idu ? 0 : $comm['idu'];
    $arraycomm[] = array('id_comment' => $comm['idcomment'],
     'id_com_post' => $comm['idcompost'], 'text' => $comm['text'],
      'time' => $comm['time'], 'userid' => $comm['iduser'],
       'username' => $comm['username'], 'image' => $comm['image'],
        'your' => $your);
}

echo json_encode($arraycomm);

exit;
}
else if (isset($_POST['text_comment'])){

    $idp = mysqli_real_escape_string($conn, $_POST['segno']);
    $text = mysqli_real_escape_string($conn, $_POST['text_comment']);

    $query = "INSERT INTO comments(user, post, text) value ( '$idu', '$idp', '$text')";

    $res = mysqli_query($conn, $query);

    if($res === true) {
        echo json_encode(array('exists' => true));
        header('Location:home.php');
        mysqli_close($conn);
    }
    echo json_encode(array('exists' => false));
    header('Location:home.php');


    exit;
}

else if(isset($_GET['y'])){

    $idc = mysqli_real_escape_string($conn, $_GET['y']);

    $query = "DELETE FROM comments WHERE id = '$idc'";

    $res = mysqli_query($conn, $query);

    if($res === true) {
    echo json_encode(array('exists' => true, 'id_com' => $idc), true);

        mysqli_close($conn);
    } else {
    echo json_encode(array('exists' => false), true);
    }
    exit;
}


?>