<?php

session_start();
if(empty($_SESSION['id'])){
header("Location: login.php");} else {
    $conn = mysqli_connect("127.0.0.1", "root", "" , "sociale");
    $id = mysqli_real_escape_string($conn, $_SESSION['id']);
    $query= "SELECT * FROM  profilo WHERE id = '$id'";
    $result = mysqli_query($conn, $query);

    $user = mysqli_fetch_assoc($result);}
?>


<!DOCTYPE html>

<hmtl>

    <head>
        <title>Together</title>
        <link rel="stylesheet" href="home.css">
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/flickity/3.0.0/flickity.min.css" integrity="sha512-fJcFDOQo2+/Ke365m0NMCZt5uGYEWSxth3wg2i0dXu7A1jQfz9T4hdzz6nkzwmJdOdkcS8jmy2lWGaRXl+nFMQ==" crossorigin="anonymous" referrerpolicy="no-referrer" />
        
        
        <link rel="preconnect" href="https://fonts.googleapis.com">
        <script src="home.js" defer></script>
        <script src="post_content.js" defer></script>
        <script src="post_show.js" defer></script>
        <link href="https://fonts.googleapis.com/css2?family=Roboto+Serif:ital,wght@1,600&display=swap" rel="stylesheet">

        <link rel="preconnect" href="https://fonts.googleapis.com">
        <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
        <link href="https://fonts.googleapis.com/css2?family=Cabin:ital@1&display=swap" rel="stylesheet">

        <link rel="preconnect" href="https://fonts.googleapis.com">
        <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
        <link href="https://fonts.googleapis.com/css2?family=Prompt&display=swap" rel="stylesheet">

        <link rel="preconnect" href="https://fonts.googleapis.com">
        <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
        <link href="https://fonts.googleapis.com/css2?family=Kanit:ital@1&display=swap" rel="stylesheet">
        <meta name="viewport" content="width=device-width, initial-scale=1">
    </head>

    <body>
        <header>
        <nav id='barra'>
<div class='barra_sinistra'>
    <img src=together.png>
<h1>Together</h1>


</div>
<div class='barra_destra'>
<form id ='form_search' method='GET' name='cerca_persone' class='hidden'>
<input id='testo' name='cerca_username' type='text' placeholder='cerca persone' >
<input type ='submit' value='Cerca' id='cerca'>
</form>

<div id="user_case"><img src="<?php if(isset($_SESSION['id'])) {echo $user['image'];}?>"></div>
<a href='logout.php' id='logout'><h2> Logout </h2></a>
</div>
            </nav>
        </header>
        
        <div id="colonna_destra" class ='hidden'>

            <div id="chat_box">
                
            </div>


           

        </div>

        <div id="corpo">

        <div id="new_post">
                    <div id="img_profile" style="background-image: url('<?php echo $user['image'] == null ? "profilo.png" : $user['image']?>')">  </div>
                    <div id="text">
                        <form action="new_post.php" method="POST" enctype="multipart/form-data">
                            <input type="text" id="testo" name="testo" cols="4" placeholder="A cosa stai pensando?"> </textarea> 
                            <div id="preview" class="hidden"></div>
                            <input type='hidden' id='idbrano' name='idbrano' value =''>
                            <div id="option" >
                            <label><input type="radio" name="tipo" id="spotify" value="spotify"> Musica</label>
                            <label><input type="radio" name="tipo" id="img" value="image"> Foto</label>
                            
                            </div>
                            <div id= "search_music" class ="hidden">
                                
                                    
                                <input type="text" id='title' placeholder="cerca il contenuto">
                                <input type="submit" id="c_s" value="cerca">
                            </div>
                            <div id="load_image" class="hidden">
                            <input type="hidden" name="MAX_FILE_SIZE" value="99999999999">
                            <input type="file" id="image" name="image"></br>
                            </div>
                            
                            <input id="post" type="submit" value="Post"></div>
                        </form>
                    </div>
<div id="spotify_show">


</div>
                <div id="posts">
            
            </div>
        </div>
        <section id="view_users" class="hidden">


       
            
        </section>

        <section id="box_chat" class = "hidden"></section>
        
        
        
        <footer id="fine">
            <div id="end">
                <a>Autore: Salvatore Rosolia </a>
                <a>Matricola: O46001354</a>
                <a>Corso: Web Programming 2021/22</a>
            </div>
        </footer>


    </body>
</hmtl>