<?php
session_start();

if(!isset($_SESSION['id'])){
    header("Location: logout.php");
}



//variabili utili

$client_id = "ab491bcc1c46484e9bb5a9e2af879120";
$client_secret = "53c266f3dd944cf88ef073445e3141b0";

// ACCESS TOKEN
$ch = curl_init();
curl_setopt($ch, CURLOPT_URL, 'https://accounts.spotify.com/api/token' );
curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
# Eseguo la POST
curl_setopt($ch, CURLOPT_POST, 1);
# Setto body e header della POST
curl_setopt($ch, CURLOPT_POSTFIELDS, 'grant_type=client_credentials'); 
curl_setopt($ch, CURLOPT_HTTPHEADER, array('Authorization: Basic '.base64_encode($client_id.':'.$client_secret)));
$token=json_decode(curl_exec($ch), true);
curl_close($ch);    




// QUERY EFFETTIVA
$query = $_GET['q'];
$query = urlencode($query);
$url = 'https://api.spotify.com/v1/search?type=track&q='.$query;
$ch = curl_init();
curl_setopt($ch, CURLOPT_URL, $url);
curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
# Imposto il token
curl_setopt($ch, CURLOPT_HTTPHEADER, array('Authorization: Bearer '.$token['access_token'])); 
$res=curl_exec($ch);
curl_close($ch);

echo $res;


?>
