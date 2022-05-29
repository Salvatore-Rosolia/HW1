let tipo;


function jsonSpotify(json){

    console.log('json ricevuto');
    console.log(json);


    if (json.tracks.items.length) {
    
    const container = document.getElementById('spotify_show');
    container.innerHTML = '';
    container.className = 'spotify';

    for (let track in json.tracks.items) {
        console.log(json);
        const card = document.createElement('div');
        card.dataset.id = json.tracks.items[track].id;
        card.classList.add('track');
        const img = document.createElement('img');
        img.src = json.tracks.items[track].album.images[0].url;
        card.appendChild(img);
        const info = document.createElement('div');
        info.classList.add('info');
        const name = document.createElement('div');
        name.classList.add('name');
        name.textContent = json.tracks.items[track].name;
        info.appendChild(name);
        const author = document.createElement('div');
        author.classList.add('author');
        author.textContent = json.tracks.items[track].artists[0].name;
        info.appendChild(author);
        card.appendChild(info);
        card.addEventListener('click', selectSpotify);
        container.appendChild(card);
        }

    }
}

function selectSpotify(event) {
    const track = event.currentTarget;
    console.log(track);
    const c = document.getElementById('spotify_show');
    c.innerHTML = '';
  
    console.log(track.dataset.id);
   
    const iframe = document.createElement('iframe');
    iframe.src = `https://open.spotify.com/embed/track/${track.dataset.id}`;
    iframe.frameBorder = 0;
    iframe.setAttribute('allowtransparency', 'true');
    iframe.allow = "encrypted-media";
    iframe.classList = "track_iframe";
    console.log(track.dataset.id);
    document.getElementById('idbrano').value = track.dataset.id;
    console.log(document.getElementById('idbrano'));
    const placeholder = document.getElementById('preview');
    placeholder.classList.add('preview');
    placeholder.classList.remove('hidden');
    placeholder.innerHTML = '';
    placeholder.appendChild(iframe);
    

    
}




//funione che cerca la canzone

function onResponse(response){
    console.log(response);
    return response.json();
}

function cercaSpotify(event) {
    console.log('sono entrato in spotify');
    event.preventDefault();
    tipo = 'spotify';

    const canzone = document.getElementById('title');
    
    console.log(canzone.value);
    const canzone_value = encodeURIComponent(canzone.value);

    fetch('cerca_spotify.php?q='+canzone_value).then(onResponse).then(jsonSpotify);
}



// Funzione che apre la sezione per cercare una canzone
function open_search_music(event) {
    tipo = 'spotify';
    box_search_image.classList.add('hidden');
    document.getElementById('preview').innerHTML ='';
    console.log(tipo);
    box_search_music.classList.remove('hidden');
}

//Aggiungo l'evento al cerca di spotify
const c_s = document.getElementById('c_s');
console.log(c_s);
c_s.addEventListener('click', cercaSpotify);


// Funzione che apre la sezione per caricare la foto
function open_search_image(event) {
    box_search_music.classList.add('hidden');
    document.getElementById('preview').innerHTML ='';

    box_search_image.classList.remove('hidden'); 
    document.getElementById('image').addEventListener('change', previewImage, false);
}
   

    function previewImage(event){
        
    var preview = document.getElementById('preview');

    
    preview.innerHTML= '';
    
        var imag = event.target.files;
        console.log(imag);
        var ele = document.createElement('div');
        if(preview.childElementCount > 0 ) {
            preview.innerHTML='';
    
        }
        

       
        //mostro le info dell'immagine
        var img = document.createElement('img');
        img.width = 300;
        img.src = window.URL.createObjectURL(imag[0]);
        img.alt = imag.name;

        //revoco l'accesso alla risorsa una volta letta
        img.onload = function() {
            window.URL.revokeObjectURL(this.src);
            preview.classList.add('preview');
            preview.classList.remove('hidden');
            
            ele.appendChild(img);
            preview.appendChild(ele);
        
        }
        
    }
    



//evento per visualizzare il form di ricerca della canzone
const spotify = document.getElementById('spotify');
spotify.addEventListener('click', open_search_music);

//evento per visualizzare il carica immagine
const image = document.getElementById('img');
image.addEventListener('click', open_search_image);

// creo due variabili per le due sezioni di ricerca
const box_search_image = document.getElementById('load_image');
const box_search_music = document.getElementById('search_music');




