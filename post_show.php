<?php 

    session_start();

    if(empty($_SESSION['id'])) {
        header('Location: logout,php');
    }



    header('Content-Type: application/json');

    $conn = mysqli_connect("127.0.0.1", "root", "", "sociale");

    $userid = mysqli_real_escape_string($conn, $_SESSION['id']);
    

        $query = "SELECT profilo.id AS userid, profilo.username AS username, profilo.image AS image, 
        posts.id AS postid, posts.items AS content, posts.time AS time, posts.nlikes AS nlikes, posts.ncomments AS ncomments,
        EXISTS(SELECT userid FROM likes WHERE post = posts.id AND userid = $userid) AS liked 
        FROM posts JOIN profilo ON posts.user = profilo.id  ORDER BY postid DESC";

    $res = mysqli_query($conn, $query) or die(mysqli_error($conn));
    
    $postArray = array();
    while($entry = mysqli_fetch_assoc($res)) {
        // Scorro i risultati ottenuti e creo l'elenco di post
        $image = $entry['image'];
        
        $date = $entry['time'];
        $postArray[] = array('userid' => $entry['userid'],'username' => $entry['username'], 
                            'image' => $image,'postid' => $entry['postid'], 'content' => json_decode($entry['content'],true), 'nlikes' => $entry['nlikes'], 
                            'ncomments' => $entry['ncomments'], 'time' => $date, 'liked' => $entry['liked']);
    }
    echo json_encode($postArray);
    
    
    exit;

?>