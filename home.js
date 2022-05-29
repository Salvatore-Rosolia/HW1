


function jsonFollow(json) {
    console.log(json.exists);
    return json.exists;
}




function onResponse(response) {
    if(response.ok) {
        return response.json();
    } else {
        return null;
    }
}



function jsonLoadMess(json) {
    console.log(json.length);

    const b_m = document.getElementById('con_messaggi');

    if(json.length === 0 ) {
        b_m.innerHTML='';
        const no_mess = document.createElement('h1');
        no_mess.classList.add('no_mess');
        
        no_mess.textContent = 'Non ci sono messaggi';
        b_m.appendChild(no_mess);
    } else {
        b_m.innerHTML = '';

        for(l in json) {

            const con_mess = document.createElement('div');
            con_mess.classList.add('con_mess');
            const top_mess = document.createElement('div');
            top_mess.classList.add('top_mess');

            const con_ava_mess = document.createElement('div');
            con_ava_mess.classList.add('con_ava_mess');

            const con_name_mess = document.createElement('div');
            con_name_mess.classList.add('con_name_mess');

            const con_time = document.createElement('div');
            con_time.classList.add('con_time');

            const con_testo = document.createElement('div');
            con_testo.classList.add('con_testo');

            // creo tag html 

            const ava_mess = document.createElement('img');
            ava_mess.src = json[l].image;
            const name_mess = document.createElement('h2');
            name_mess.textContent = json[l].username;

            const time_mess = document.createElement('span');
            time_mess.textContent = json[l].time;

            const testo_mess = document.createElement('p');
            testo_mess.textContent = json[l].text;



            // appendo i tag html nel div

            con_testo.appendChild(testo_mess);
            con_time.appendChild(time_mess);
            con_name_mess.appendChild(name_mess);
            con_ava_mess.appendChild(ava_mess);
            top_mess.appendChild(con_ava_mess);
            top_mess.appendChild(con_name_mess);
            top_mess.appendChild(con_time);

            con_mess.appendChild(top_mess);
            con_mess.appendChild(con_testo);
            
            b_m.appendChild(con_mess);
        }
    }



}

function loadChat(idchat) {

    fetch('chat.php?idc='+idchat).then(onResponse).then(jsonLoadMess);
}



function jsonSendMess(json) {
    loadChat(json.idchat);
}

function reloadChat(event) {
    console.log(event.currentTarget.parentNode.parentNode.parentNode);
    loadChat(event.currentTarget.parentNode.parentNode.parentNode.dataset.id);
}


function closeChat(event) {
    console.log(event.currentTarget.parentNode.parentNode.parentNode);

    let o = event.currentTarget.parentNode.parentNode.parentNode;
    o.innerHTML = '';
    o.classList.remove('box_chat');
    o.classList.add('hidden');
}

function sendMess(event) {

    event.preventDefault();

    console.log(event.currentTarget.parentNode.parentNode.dataset.id);
    const idch  = event.currentTarget.parentNode.parentNode.dataset.id;
    const formData = new FormData(document.getElementById('send_mess'));
    formData.append('idchat', idch); 
    fetch ('chat.php', { method: 'POST' , body: formData}).then(onResponse).then(jsonSendMess);

 }

function jsonLoadTopChat(json) {

console.log(json);

// creo tutti i contenitori 
const box_chat = document.getElementById('box_chat');
box_chat.innerHTML ='';
box_chat.classList.remove('hidden');
box_chat.setAttribute('data-id', json[0].idchat);
box_chat.classList.add('box_chat');
const top_chat = document.createElement('div');
top_chat.classList.add('top_chat');

const con_img_chat = document.createElement('div');
con_img_chat.classList.add('con_img_chat');

const con_name_chat = document.createElement('div');
con_name_chat.classList.add('con_name_chat');

con_azioni_chat = document.createElement('div');
con_azioni_chat.classList.add('con_azioni_chat');


// bottone per la chiusura della chat
const close_chat = document.createElement('buttom');
close_chat.textContent = 'X';
close_chat.classList.add('close_chat');
close_chat.addEventListener('click', closeChat);
//bottone per ricaricare la chat;
const load_chat = document.createElement('div');
const img_load = document.createElement('img');
img_load.src='reload.png';
load_chat.appendChild(img_load);
load_chat.classList.add('load_chat');
load_chat.addEventListener('click', reloadChat);

const con_messaggi = document.createElement('div');
con_messaggi.setAttribute('id', 'con_messaggi');

const con_scrivi_mess = document.createElement('form');
con_scrivi_mess.setAttribute('id', 'send_mess');
const mess = document.createElement('input');
mess.setAttribute('type', 'text');
mess.setAttribute('name', 'mess');
mess.setAttribute('id', 'mess');
const invia_mess = document.createElement('input');
invia_mess.setAttribute('type', 'submit');
invia_mess.setAttribute('name', 'invia_mess');
invia_mess.addEventListener('click', sendMess);

// creo i tag html per inserire i valori 

const img_chat = document.createElement('img');
img_chat.classList.add('img_chat');
img_chat.src = json[0].image;

const name_chat = document.createElement('h3');
name_chat.textContent = json[0].username;

con_img_chat.appendChild(img_chat);
con_name_chat.appendChild(name_chat);
con_azioni_chat.appendChild(close_chat);
con_azioni_chat.appendChild(load_chat);

top_chat.appendChild(con_img_chat);
top_chat.appendChild(con_name_chat);
top_chat.appendChild(con_azioni_chat);

con_scrivi_mess.appendChild(mess);
con_scrivi_mess.appendChild(invia_mess);

box_chat.appendChild(top_chat);
box_chat.appendChild(con_messaggi);
box_chat.appendChild(con_scrivi_mess);

loadChat(json[0].idchat);

}

function jsonCreateChat(json) {
    console.log(json);
    if(json.exists === true) {
        console.log(json.userid);
        console.log(json.idchat);
        
        fetch('cerca_persone.php?z='+json.userid+'&w='+json.idchat).then(onResponse).then(jsonLoadTopChat);
    }

}


function jsonChat(json) {

    if(json.exists === false) {
        console.log(json.userid);
        fetch('chat.php?q='+json.userid).then(onResponse).then(jsonCreateChat);
    } else {
        jsonCreateChat(json);
    }

}

function openChat(event) {
    const p = event.currentTarget.parentNode.parentNode.dataset.id;
    console.log(event.currentTarget.parentNode.parentNode.dataset.id);

    fetch ('chat.php?userid='+p).then(onResponse).then(jsonChat);
}


function chiudi_cerca(event) {
    const f = event.currentTarget.parentNode;
    f.innerHTML='';
    f.classList.remove('preview');
    f.classList.add('hidden');
    

}

function jsonPeople(json) {
    console.log(json);

   const g = document.getElementById('view_users');
   g.classList.add('view_users');
   g.classList.remove('hidden');
 
   
   
    view_users.innerHTML = '';
    const quit = document.createElement('buttom');
    quit.textContent = 'X';
    quit.classList.add('quit');
    quit.addEventListener('click', chiudi_cerca);
    
    
    for (persona of json) {





        const box = document.createElement('div');
        box.classList.add('carousel-cell');
        box.dataset.id = persona.id;
        const top = document.createElement('div');
        top.classList.add('div_imgp');
        const mid = document.createElement('div');
        mid.classList.add('mid');
        const bot = document.createElement('div');
        bot.classList.add('bot');
        const image = document.createElement('img');
        image.classList.add('prf_img');
        image.src = persona.image;
        const username = document.createElement('h2');
        username.textContent = persona.username;
        const chat = document.createElement('buttom');
        console.log('aggiungo evento');
        chat.addEventListener('click', openChat);
        chat.textContent ='Chatta';
        chat.classList.add('chat');
        const nome = document.createElement('p');
        nome.textContent = persona.nome;
        const cognome = document.createElement('p');
        cognome.textContent= persona.cognome;
        const post = document.createElement('p');
        post.textContent = "N° post : "+persona.nposts;
       

        
       
        top.appendChild(image);
        mid.appendChild(username);
        mid.appendChild(post);
        bot.appendChild(chat);

        box.appendChild(top);
       
        box.appendChild(mid);
        box.appendChild(bot);
       

         view_users.appendChild(box);
    }
    g.appendChild(quit);
}

function onResponse(response) {
    if(response.ok) {
        return response.json();
    } else {
        return null;
    }
}



function see_users(event) {
    event.preventDefault();
    
    const user_to_see = document.getElementById('testo').value;
    console.log(user_to_see);
   
    
    fetch("cerca_persone.php?user=" +encodeURIComponent(user_to_see)).then(onResponse).then(jsonPeople);

}



const cerca = document.getElementById('cerca');
cerca.addEventListener('click', see_users);


//funzione per far uscire il form di ricerca
function uscita_form(event) {
    event.currentTarget.classList.add("hidden");
    document.getElementById('form_search').classList.remove('hidden');

}

function see_option(event) {
    event.currentTarget;

}





function loadUserCase(json){
    console.log(json);
    const user_case = document.querySelector('#user_case');

    user_case.innerHTML = '';
    for(persona of json) {

        console.log('creo case');
        
        const box = document.createElement('div');
        box.classList.add('box');
        const nick = document.createElement('div');
        nick.classList.add('nick');
        
        const div_img = document.createElement('div');
        div_img.classList.add('div_img');
        const image = document.createElement('img');
        image.classList.add('prf_img');


        const username = document.createElement('h2');
        username.textContent = persona.username;
        
        
        image.src = persona.image;


        nick.appendChild(username);
        
        
        div_img.appendChild(image);
        box.appendChild(nick);
        box.appendChild(div_img);
        

        user_case.appendChild(box);

        user_case.addEventListener('click', see_option);
    }
}

function load_response(response) {
    if(response) {
        return response.json();
    }
}







// funzione per caricare 
function load_user_case() {

    fetch("load_user_case.php").then(load_response).then(loadUserCase);

}


load_user_case();



