
<?php
// apro la sessione
session_start();


if(empty($_SESSION['id'])){
  //  header(('Location: login.php'));
}

if($_POST['tipo'] === 'image') {
header('Content-Type: application/json');


// check del testo se è settato lo salvo altrimenti niente



   // Controllo se i requisiti dell'immagine inserita sono idonei per il check

// 1) settiamo la cartella in cui fare l'upload
$cartella_upload ="upload_img/";  
// 2) settiamo un array in cui indichiamo il tipo di file che consentiamo l'upload
// in questo esempio solo immagini  
$tipi_consentiti = array("<image/gif","image/png","image/jpeg","image/jpg");    
// 3) settiamo la dimensione massima del file (1048576 byte = 1Mb)
$max_byte = 50000000;  // 50mb
print_r($_FILES);
    // Controllo se il file è stato settato
    if(isset($_FILES['image'])) {
        $image= $cartella_upload.$_FILES['image']['name'];

    // verifico che l'utente abbia selezionato un file
    if(trim($_FILES['image']['name']) == '') {
        echo "Non hai selezionato nessun file!";
    }
    
    //verifico che il file sia stato caricato 
    else if(!is_uploaded_file($_FILES['image']['tmp_name']) or $_FILES['image']["error"] > 0 ) {
        var_dump($_FILES['image']['error']);
        print_r($_FILES['image']['error']);
        echo "Si sono verificati problemi nella procedura di upload!";
    }
// verifichiamo che il tipo è fra quelli consentiti
$file_est= explode('.', $_FILES["image"]["type"]);
$file_estension = strtolower(end($file_est));
echo $file_estension;
 if(in_array($file_estension,$tipi_consentiti) === false){
    echo 'Il file che si desidera uplodare non è fra i tipi consentiti!';
    }
// verifichiamo che la dimensione del file non eccede quella massima
   else if($_FILES["image"]["size"] > $max_byte) {
    echo 'Il file che si desidera uplodare eccede la dimensione massima!';
      }
// verifichiamo che la cartella di destinazione settata esista
    else if(!is_dir($cartella_upload)) {
     echo 'La cartella in cui si desidera salvare il file non esiste!';
        }
// verifichiamo che la cartella di destinazione abbia i permessi di scrittura
    else if(!is_writable($cartella_upload)) {
     echo "La cartella in cui fare l'upload non ha i permessi!";
        }
// Sposto il file nella cartella da me desiderata

else if (!move_uploaded_file($_FILES['image']['tmp_name'], $cartella_upload.$_FILES['image']['name'])) {
    echo "<p>Errore nel caricamento dell'immagine!!</p>";
    
  } else {
      
    $conn = mysqli_connect("127.0.0.1", "root", "", "sociale");
      
    $testo = mysqli_real_escape_string($conn, $_POST['testo']);
    $user_id = mysqli_real_escape_string($conn, $_SESSION['id']);
    $ima = mysqli_real_escape_string($conn, $image);

    $query = "INSERT INTO POSTS (user, items) value ( '$user_id' , json_object('type' , '$file_estension', 'text' , '$testo', 'ele', '$ima'))";

    if(mysqli_query($conn, $query)) {
      echo json_encode(array('ok' => true));
      header('Location: home.php');
      exit;
  } 
  echo json_encode(array('ok' => false));
  }
  mysqli_close($conn);
}







} else if($_POST['tipo'] === 'spotify') {

  $conn = mysqli_connect("127.0.0.1", "root", "", "sociale");
      
  $testo = mysqli_real_escape_string($conn, $_POST['testo']);
  $user_id = mysqli_real_escape_string($conn, $_SESSION['id']);
  $tipo = mysqli_real_escape_string($conn, $_POST['tipo']);
  $idbrano = mysqli_real_escape_string($conn, $_POST['idbrano']);
echo $idbrano;
  $query = "INSERT INTO POSTS (user, items) values ( '$user_id' , json_object('type' , '$tipo', 'text' , '$testo', 'id', '$idbrano'))";

  if(mysqli_query($conn, $query)) {
    echo json_encode(array('ok' => true));
  header('Location: home.php');
    exit;
} 
echo json_encode(array('ok' => false));

mysqli_close($conn);
}





   

 
    
        
    
    
?>