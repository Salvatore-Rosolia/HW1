

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title> DAMMI NOME E COGNOME</title>
</head>

<body>


    <form action="prova_connessione_db.php" method="POST">
        <p>
            <label for="nome">Nome</label>
            <input name="nome" id="nome" type="text">
        </p>
        <p>
            <label for="cognome">Cognome</label>
            <input name="cognome" id="cognome" type="text">
        </p>
        <p>

            <input type="submit" value="Inserisci">
        </p </form>

</body>

</html>

<?php

$local = "127.0.0.1";
$person = "root";
$password = "";
$nome_db = "test";








$conn = mysqli_connect($local, $person, $password, $nome_db);

if($conn === false ) {
    die("Errore di connessione: " . mysqli_connect_error($conn));
}

$nome = mysqli_real_escape_string($conn, $_POST['nome']);
$cognome = mysqli_real_escape_string($conn, $_POST['cognome']);



$query = "INSERT INTO persona (nome, cognome) values ('$nome', '$cognome')";

if ($res = mysqli_query($conn, $query) === true) {
    echo "<h1> Persona aggiunta con successo </h1>";
} else {
    echo "<h1> Persona non aggiunta con successo </h1>";
}




?>
