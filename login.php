

<?php

session_start();  // Apro la sessione
if(!empty($_SESSION['id'])){ // Controllo se qualcuno fosse già loggato 
echo $_SESSION['id'];
header('Location: home.php');// Reindirizzo allo Home
}

// Controllo se i campi sono stati compilati 

if(!empty($_POST['username']) && !empty($_POST['password'])) {

    
    $conn = mysqli_connect("127.0.0.1", "root", "","sociale") or die(mysqli_connect_error()); //connessione al db


    $username = mysqli_real_escape_string($conn, $_POST['username']); 
    
    $pass = mysqli_real_escape_string($conn, $_POST['password']);
    $password = password_hash($pass, PASSWORD_ARGON2I);
    
    $query = "SELECT * FROM profilo where username = '$username'";

    $res = mysqli_query($conn, $query) or die("Errore: " .mysqli_error($conn));
    
    if($res === false) {
        exit("Errore: impossibile eseguire la query. " .mysqli_error($conn));
    }
    
    while ($row = mysqli_fetch_array($res)) {
        
        if(password_verify($pass, $row[2])) {

            $_SESSION['id'] = $row[0];
            $_SESSION['username']= $row[1];        
            header('Location: home.php');
            mysqli_free_result($res);
            mysqli_close($conn);   
        } else{   
            $error = "USername e/o password errati!";
        }
    }
}
?>






<!DOCTYPE html>
<html lang="en">



<head>
    <meta charset="UTF-8">
    <script src="login.js" defer></script>
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>Login</title>

    <link rel="stylesheet" href="login.css">


</head>

<body>
    <section id="login">
        <h2>Login</h2>
   
        <form name="login" method="POST">
            <div id="form_login">
                <div class="username">
                    <label for="username">Username</label>
                    <input type="text" name="username" id="username">
                    <span></span>

                </div>
                <div class="password">
                    <label for="password">Password</label>
                    <input type="password" name="password" id="password">
                    <input type="button" onclick="mostraPass()" id="see_pass" >
                        <script>
                            function mostraPass() {
                                const input = document.getElementById('password');
                                if(input.type === "password") {
                                    input.type = "text";
                                    document.getElementById('see_pass').style.backgroundImage = "url(occhio_aperto.png)";
                                    
                                } else {
                                    input.type = "password";
                                    document.getElementById('see_pass').style.backgroundImage = "url(occhio_chiuso.png)";
                                   
                                }
                            }
                        </script>
                        <span></span></div>
                <div>
                    <input type="submit" value="Login">
                </div>
                <div class="registrazione">Non hai un account? <a href="registrazione.php">Iscriviti</a></div>
            </div></div>
        </form>



    </section>






</body>

</html>

