function onResponse(response) {
    if(!response) {
        return null;
    } else return response.json();
}

function jsonRemComm(json) {
    var cella;
    console.log(json);
    if(json.exists === true) {
        console.log(json.exists);
        var lista_commenti = document.getElementsByClassName('box_commento');
        console.log(lista_commenti);

        for(let i=0;i<lista_commenti.length ; i++) {
            console.log(lista_commenti[i].attributes[0].value);
            if(lista_commenti[i].attributes[0].value == json.id_com) {
                cella = lista_commenti[i];
               
                cella.parentNode.parentNode.parentNode.childNodes[2].lastChild.lastChild.textContent = cella.parentNode.parentNode.parentNode.childNodes[2].lastChild.lastChild.textContent -1;
                cella.remove();
            }
        }
    } else {
        console.log('errore');
    }
}


function RemComm(event) {
    let y = event.currentTarget.parentNode.parentNode.parentNode;
    let idc = y.attributes['data-id'].nodeValue;
    console.log()
    console.log(idc);
    fetch('comment_controll.php?y='+idc).then(onResponse).then(jsonRemComm);
}

function closeComm(event) {
    console.log('sono in close');
    let comms = event.currentTarget.parentNode.parentNode.parentNode.lastChild.lastChild;
    console.log(event.currentTarget);
    console.log(comms);
    comms.innerHTML= '';
    comms.parentNode.classList.add('hidden');
    event.currentTarget.removeEventListener('click', closeComm);
    event.currentTarget.addEventListener('click', openShowComm);

}

function jsonCommShow(json) {
    var cella;
    var sel_box;
    if(json.length == 0 ) {
        console.log("non ci sono commenti");
     
    } else {
    let all_comm = json;
    console.log(all_comm);
    const box_c = document.getElementsByClassName('box_post');
    console.log(box_c);
    for(let l = 0; l<box_c.length; l++){
        console.log(box_c[l].attributes['data-id'].value);
        console.log(json[0].id_com_post);
        
        if(box_c[l].attributes['data-id'].nodeValue == json[0].id_com_post){
            sel_box = box_c[l].lastChild.lastChild;
            console.log(sel_box); 
        }
    }

    for(c in all_comm) {
         console.log(sel_box);

       
        
        
        // creo i contenitori 
        const box_commento = document.createElement('div');
        box_commento.setAttribute('data-id', all_comm[c].id_comment);
        box_commento.classList.add('box_commento');
        const top_com = document.createElement('div');
        const top_img_user = document.createElement('div');
        top_com.classList.add('top_com');
        top_img_user.classList.add('top_img_user');
        const box_img_comm = document.createElement('div');
        box_img_comm.classList.add('box_img_comm');
        const box_user_time = document.createElement('div');
        box_user_time.classList.add('box_user_time');
        const box_destroy = document.createElement('div');
        box_destroy.classList.add('box_destroy');
        const box_text = document.createElement('div');
        box_text.classList.add('box_text');

        //creo i tag HTML 
        const img_comm = document.createElement('img');
        const user = document.createElement('h3');
        const time = document.createElement('span');
        const text = document.createElement('p');

        img_comm.src = all_comm[c].image;
        console.log(all_comm[c]);
        user.textContent = all_comm[c].username;
        time.textContent = all_comm[c].time;
        text.textContent = all_comm[c].text;
        console.log(all_comm[c].your);
        if(all_comm[c].your !== 0) {
            const delet = document.createElement('buttom');
            delet.textContent = "Elimina";
            delet.addEventListener('click', RemComm);
            box_destroy.appendChild(delet);
        }

        box_text.appendChild(text);
        box_user_time.appendChild(user);
        box_user_time.appendChild(time);
        box_img_comm.appendChild(img_comm);

        top_img_user.appendChild(box_img_comm);
        top_img_user.appendChild(box_user_time);

        top_com.appendChild(top_img_user);
        top_com.appendChild(box_destroy);


        box_commento.appendChild(top_com);
        box_commento.appendChild(box_text);

     

        sel_box.appendChild(box_commento);

        const id_c = document.createElement('span');
        id_c.textContent = all_comm[c].id_comment;
        






    }

    }
}

function commentShow(c) {
    console.log(c);
    

    let g = c.parentNode.parentNode.parentNode.dataset.id;
 
    console.log(g);
    
    fetch('comment_controll.php?q='+g).then(onResponse).then(jsonCommShow);

}


function jsonAggComm(json) {
    if(json.exists === true) {
        console.log(json.exists);
        document.querySelector('comments').innerHTML ='';
        commentShow(c);
    } else {
        console.log('errore');
    }
}




function openShowComm(event) {
    console.log('riapro commenti');
    let h = event.currentTarget;
    h.removeEventListener('click', openShowComm);    
    h.addEventListener('click', closeComm);

    
    console.log(' apro lo show');
    let c = event.currentTarget.parentNode.parentNode.parentNode;
    console.log(c.lastChild);
    c.querySelector('section').classList.remove('hidden');
    

    console.log(c.lastChild);
    console.log('ho rimosso la classe dalla sezione');
    
    commentShow(h);

    
    

}



function jsonRimLike(json) {
    console.log(json);
    var cel;
    if(json.exists === true) {
        var boxs = document.getElementsByClassName('box_post');
        console.log(boxs);
        for(let w = 0 ; w< boxs.length; w++) {
            console.log(json.idp);
            if(boxs[w].attributes['data-id'].value == json.idp){
               cel = boxs[w];
                console.log(cel.childNodes[2].firstChild.firstChild);
                cel.childNodes[2].firstChild.firstChild.src = "like.png";
                cel.childNodes[2].firstChild.lastChild.textContent = cel.childNodes[2].firstChild.lastChild.textContent -1;
                cel.childNodes[2].firstChild.firstChild.removeEventListener('click', RimLike);
                cel.childNodes[2].firstChild.firstChild.addEventListener('click', AddLike);

            }
        }
        
        
    } else {
        console.log('errore');
    }
}



function RimLike(event) {
    let box = event.currentTarget.parentNode.parentNode.parentNode.dataset.id;
    console.log();
    fetch('likes.php?p='+box).then(onResponse).then(jsonRimLike);

}






    function jsonAddLike(json) {
        console.log(json);
        var cel;
        if(json.exists === true) {
            var boxs = document.getElementsByClassName('box_post');
            console.log(boxs);
            for(let w = 0 ; w< boxs.length; w++) {
                console.log(json.postid);
                if(boxs[w].attributes['data-id'].value == json.postid){
                   cel = boxs[w];
                    console.log(cel.childNodes[2].firstChild.firstChild);
                    cel.childNodes[2].firstChild.firstChild.src = "unlike.png";
                    let prova = cel.childNodes[2].firstChild.lastChild.textContent;
                    prova++;
                    console.log(cel.childNodes[2].firstChild.lastChild.textContent);
                    console.log(prova);
                    cel.childNodes[2].firstChild.lastChild.textContent = prova;
                    cel.childNodes[2].firstChild.firstChild.removeEventListener('click', AddLike);
                    cel.childNodes[2].firstChild.firstChild.addEventListener('click', RimLike);
    
                }
            }
            
         
        } else {
            console.log('errore');
        }
    }


function AddLike(event) {
    let box = event.currentTarget.parentNode.parentNode.parentNode.dataset.id;
    console.log(box);
    fetch('likes.php?q='+box).then(onResponse).then(jsonAddLike);
   
}


function jsonLike(json) {

    if(json.exists === true) {
        console.log('esiste');
        return true;
    } else {
        console.log('non esiste');
        return false;
    }



}



function jsonPosts(json) {
    console.log(json);
    const view_post = document.getElementById('posts');
    view_post.classList.add('view_post');
    
    var all_posts = json;
    console.log(all_posts);
    var n_post = all_posts.length;
    console.log(n_post);
    //view_post.innerHTML='';

    for(let p in all_posts) {

      


        


        const box_post = document.createElement('div');
        box_post.classList.add('box_post');

        box_post.dataset.id = all_posts[p].postid;
        //sezione top del post
        
        const top_post = document.createElement('div');
        top_post.classList.add('top_post');
        //sezione per avatar del post
        const con_avatar_post = document.createElement('div');
        con_avatar_post.classList.add('con_avatar_post');
        //sezione per username 
        const con_username_post = document.createElement('div');
        con_username_post.classList.add('con_username_post');
        //sezione per username e data
        const con_username_data = document.createElement('div');
        con_username_data.classList.add('con_username_data');
        //sezione per la data
        const con_data = document.createElement('div');
        con_data.classList.add('con_data');
        //sezione content
        const con = document.createElement('div');
        con.classList.add('con');
        // sezione testo del post
        const con_testo = document.createElement('div');
        con_testo.classList.add('con_testo');
        // sezione immagine caricata
        const con_content = document.createElement('div');
        con_content.classList.add('con_content');
        //sezione per like e comment
        const bot_post = document.createElement('div');
        bot_post.classList.add('bot_post');
        //sezione per likes
        const con_likes = document.createElement('div');
        con_likes.classList.add('con_likes');
        //sezione per comments
        const con_comments =document.createElement('div');
        con_comments.classList.add('con_comments');

        const section_com = document.createElement('section');
        
        
        
        
        
        
        
        section_com.classList.add('hidden');

        //creo i tag html per i dati del post 

        const avatar_post = document.createElement('img');
        avatar_post.classList.add('avatar_post');
        const username_post = document.createElement('h3');
        const data = document.createElement('p');
        const testo = document.createElement('p');
        
        const like = document.createElement('img');
        let n_likes = document.createElement('span');
        const comment = document.createElement('img');
        let n_comments = document.createElement('span');
        const box_comm = document.createElement('div');
        const form_com = document.createElement('form');
        form_com.setAttribute('method', 'POST');
        form_com.setAttribute('action', 'comment_controll.php');
        const segno = document.createElement('input');
        segno.classList.add('hidden');
        segno.setAttribute('name', 'segno');
        segno.setAttribute('value', box_post.dataset.id); 
        const text_comment = document.createElement('input');
        text_comment.setAttribute('type', 'text');
        text_comment.setAttribute('name', 'text_comment');
        const submit = document.createElement('input');
        submit.setAttribute('type', 'submit');
        submit.setAttribute('name', 'submit');
        submit.setAttribute('value', 'Commenta');

        
        const box_allcomm = document.createElement('div');
        box_comm.classList.add('box_comm');
        box_allcomm.classList.add('box_allcomm');

        
        
        //eventi bottoni
        comment.addEventListener('click', openShowComm);
    


        // riempio i tag html con i dati del post 

        avatar_post.src = all_posts[p].image;
        username_post.textContent = all_posts[p].username;
        data.textContent = all_posts[p].time;
        testo.textContent = all_posts[p].content.text;
        
        console.log('like:' +all_posts[p].liked);
        if(all_posts[p].liked == 1){
            console.log('ci sono');
            like.src = "unlike.png";
            like.addEventListener('click', RimLike);
        } else {
            like.src = "like.png";
            like.addEventListener("click", AddLike);
        }
        n_likes.textContent = all_posts[p].nlikes;
        comment.src = "comments.png";
        n_comments.textContent = all_posts[p].ncomments;


        con_avatar_post.appendChild(avatar_post);
        con_username_post.appendChild(username_post);
        con_data.appendChild(data);
        con_testo.appendChild(testo);
        
        con_likes.appendChild(like);
        con_likes.appendChild(n_likes);
        con_comments.appendChild(comment);
        con_comments.appendChild(n_comments);
        
        con_username_data.appendChild(con_username_post);
        con_username_data.appendChild(con_data);

        top_post.appendChild(con_avatar_post);
        top_post.appendChild(con_username_data);

        con.appendChild(con_testo);
        con.appendChild(con_content);

        bot_post.appendChild(con_likes);
        bot_post.appendChild(con_comments);
        form_com.appendChild(segno);
        form_com.appendChild(text_comment);
        form_com.appendChild(submit);
        box_comm.appendChild(form_com);
        
        section_com.appendChild(box_comm);
        section_com.appendChild(box_allcomm);

        box_post.appendChild(top_post);
        box_post.appendChild(con);
        box_post.appendChild(bot_post);
        box_post.appendChild(section_com);
        
        

        view_post.appendChild(box_post);
        if(all_posts[p].content.type === 'spotify') {
            let iframe = document.createElement('iframe');
            console.log(all_posts[p].content.id);
            iframe.src = "https://open.spotify.com/embed/track/"+encodeURIComponent(all_posts[p].content.id);
            iframe.frameBorder = 0;
            iframe.setAttribute('allowtransparency', 'true');
            iframe.allow = "encrypted-media";
        
            iframe.classList = "track_iframe";
            con_content.appendChild(iframe);
        
        } else {
            const image = document.createElement('img');
            image.src = all_posts[p].content.ele;
            con_content.appendChild(image);
        }
    }

}



function postShow() {

    fetch('post_show.php').then(onResponse).then(jsonPosts);
}

postShow();

//fetch('post_show.php').then(onResponse).then(jsonPosts);
