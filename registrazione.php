<?php

session_start();

if (isset($_SESSION['id'])) {
   header("Location: home.php");
    exit;
}

// Eseguo il controllo del form lato PHP 


if (isset($_POST['username']) && isset($_POST['nome']) && isset($_POST['cognome']) && isset($_POST['email']) && isset($_POST['password'])){

    $errori = array();
    $conn = mysqli_connect("127.0.0.1", "root", "", "sociale");

    // Controllo il campo Username
    if (!preg_match('/^[a-zA-Z0-9_]{1,20}$/', $_POST['username'])) {
        $errori[] = "L'username non contiene i caratteri richiesti!";
    } else {
        $username = mysqli_real_escape_string($conn, $_POST["username"]);

        $query_check_username = "select username from profilo where username = '$username'";

        $res = mysqli_query($conn, $query_check_username);

        while ($row = mysqli_fetch_array($res)) {
            $errori[] = "Username inserito già in uso!";
        }
    }


    //COntrollo il campo Nome 

    if (preg_match('/^[0-9]$/', $_POST['nome'])) {
        $errori[] = "Non puoi avere un numero nel nome";
    } 
    //Controllo il campo cognome 

    if (preg_match('/^[0-9]$/', $_POST['cognome'])) {
        $errori[] = "Non puoi avere un numero nel nome";
    } 

    //Controllo il campo email

    if (!filter_var($_POST['email'], FILTER_VALIDATE_EMAIL)) {
        $errori[] = "Email non valida";
    } else {

        $email = mysqli_real_escape_string($conn, $_POST['email']);
        $query_check_email = " select * from profilo where email = '$email'";

        $res = mysqli_query($conn, $query_check_email);
        while ($row = mysqli_fetch_array($res)) {
            $errori[] = "email inserito già in uso!";
        }
    }

    // controllo il campo password

    if (strlen($_POST['password']) < 8 ||
        !preg_match('/^[a-zA-Z]+$/', $_POST['password'])) {
        $errori[] = "La password non rispetta le caratteristiche!";
    }


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
    if(!isset($_FILES['dati_file'])) {
        echo "Il file non è stato settato"."<br>";
    }
    // verifico che l'utente abbia selezionato un file
    if(trim($_FILES['dati_file']['name']) == '') {
        echo "Non hai selezionato nessun file!";
    }
    
    //verifico che il file sia stato caricato 
    else if(!is_uploaded_file($_FILES['dati_file']['tmp_name']) or $_FILES['dati_file']["error"] > 0 ) {
        var_dump($_FILES['dati_file']['error']);
        print_r($_FILES['dati_file']['error']);
        echo "Si sono verificati problemi nella procedura di upload!";
    }
// verifichiamo che il tipo è fra quelli consentiti
$file_est= explode('.', $_FILES["dati_file"]["type"]);
$file_estension = strtolower(end($file_est));
echo $file_estension;
if(in_array($file_estension,$tipi_consentiti) === false){
    echo 'Il file che si desidera uplodare non è fra i tipi consentiti!';
    }
// verifichiamo che la dimensione del file non eccede quella massima
   else if($_FILES["dati_file"]["size"] > $max_byte) {
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

else if (!move_uploaded_file($_FILES['dati_file']['tmp_name'], $cartella_upload.$_FILES['dati_file']['name'])) {
    echo "Errore nel caricamento dell'immagine!!";
    
  }
// altrimenti significa che è andato tutto ok
    else {
     echo 'Upload eseguito correttamente!';
     $dati_file= $cartella_upload.$_FILES['dati_file']['name'];
     echo '<script> console.log("Upload eseguito correttamente"); </script>';

        
     $nome = mysqli_real_escape_string($conn, $_POST["nome"]);
     $cognome = mysqli_real_escape_string($conn, $_POST["cognome"]);
     $pass = mysqli_real_escape_string($conn, $_POST['password']);
     $password = password_hash($pass, PASSWORD_ARGON2I);



     $query_inserimento_profilo = "INSERT INTO profilo (username, nome, cognome, email, password, image) VALUE
      ('$username', '$nome', '$cognome', '$email', '$password','$dati_file') ";
    
     if ($conn->query($query_inserimento_profilo) === true) {
         // se la query da risultato positivo salvo l'username e l'id dell'utente in sessione
         $_SESSION['username'] = $_POST["username"];
         $_SESSION['id'] = mysqli_insert_id($conn);
         // chiudo la connessione
         mysqli_close($conn);
         header("Location: home.php");
         exit;
     }
    }   
}


?>











<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <link rel="stylesheet" href="login.css">
    <script src="registrazione.js" defer></script>
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Registrazione</title>
</head>

<body>

    <section id="registrazione">

        
         <h1>Registrati</h1>
        <form enctype="multipart/form-data" method="POST" action="registrazione.php">
          
            <div id='form_registrazione'>
                <div class="username"><label for='username'>Username</label>
                    <input type="text" name="username" id="username">
                    <span>Username non disponibile </span>
                </div>
                <div class="nome"><label for='nome'>Nome</label>
                    <input type="text" name="nome" id="nome">
                    <span>Nome non valido</span>
                </div>
                <div class="cognome"><label for='cognome'>Cognome</label>
                    <input type="text" name='cognome' id='cognome'>
                    <span>Cognome non valido </span>
                </div>
                <div class=" email"><label for='email'>E-mail</label>
                    <input type="text" name='email' id='email'>
                    <span>Email non valida </span>
                </div>
                <div class="password"><label for='password'>Password</label>
                    <input type="password" name="password" id="password">

                    <input type="button" onclick="mostraPass()" id="see_pass">
                    <span>Password non valida </span>
                    <script>
                        function mostraPass() {
                            const input = document.getElementById('password');
                            if (input.type === "password") {
                                input.type = "text";
                                document.getElementById('see_pass').style.backgroundImage = "url(occhio_aperto.png)";

                            } else {
                                input.type = "password";
                                document.getElementById('see_pass').style.backgroundImage = "url(occhio_chiuso.png)";

                            }
                        }
                    </script>

                </div>
                <div class="dati_file">
                    <input type="hidden" name="MAX_FILE_SIZE" value="524288">
                    <label for="dati_file"> Scegli la tua immagine profilo: </label>
                    <input type="file" name="dati_file"></br>

                    
                </div>

                <div class='start'>
                    <input type="submit" value="Registrati">
                </div>

            </div>
            <div class="login">Hai un account? <a href="login.php">Accedi</a></div>
            </div>



            </div>
        </form>


    </section>

</body>

</html>