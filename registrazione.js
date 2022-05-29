
function jsonEmail(json) {
    if(json.exists === true) {
        document.querySelector('.email').classList.add('error');
        document.querySelector('.email span').textContent = "Email già in uso!";
    } else {
        document.querySelector('.email').classList.remove('error');
        
    }
    checkForm();
}

function jsonUsername(json) {
    if(json.exists == true) {
        document.querySelector('.username').classList.add('error');
        document.querySelector('.username span').textContent = "Username già in uso!";
        
    } else {
        document.querySelector('.username').classList.remove('error');
    }
    checkForm();
}


function onResponse(response) {
    if(response.ok) {
        return response.json();
    } else {
        return null;
    }
}


function checkUsername() {
    const input_username = document.querySelector('.username input').value.trim();
    if(!/^[a-zA-Z0-9_]{1,20}$/.test(input_username)) {
        document.querySelector('.username').classList.add('error');
        document.querySelector('.username span').textContent = "Max 20 Caratteri ( lettere, numeri e undescore)"
        formResult.username=false;
        checkForm();
    } else {
        fetch('check_username.php?username='+encodeURIComponent(String(input_username))).then(onResponse).then(jsonUsername);
    }
}




function checkNome() {
    const input_nome = document.querySelector('.nome input');

    var regex7 = /[0-9]+/;

    if(input_nome.value.length == 0) {
        document.querySelector('.nome').classList.add('error');
        document.querySelector('.nome span').textContent = "Inserisci un nome il campo è obbligatorio";
        formResult.cognome= false;
    } else if(regex7.test(input_nome.value) === true) {
        document.querySelector('.nome').classList.add('error');
        document.querySelector('.nome span').textContent = "Inserisci un nome valido(non puo' contenere numeri)";
        formResult.cognome= false;
    } else {
        document.querySelector('.nome').classList.remove('error');
        formResult.cognome = true;
    }
    checkForm();
}


function checkCognome() {
    const input_cognome=document.querySelector('.cognome input').value;
    var regex6 = /[0-9]+/;
    if(input_cognome.length === 0 ) {
        document.querySelector('.cognome').classList.add('error');
        document.querySelector('.cognome span').textContent = "Inserisci un cognome il campo è obbligatorio";
        formResult.cognome= false;
    } else if(regex6.test(input_cognome) === true) {
        document.querySelector('.cognome').classList.add('error');
        document.querySelector('.cognome span').textContent = "Inserisci un cognome valido(non puo' contenere numeri)";
        formResult.cognome= false;
    } else {
        document.querySelector('.cognome').classList.remove('error');
        formResult.cognome = true;
    }

    checkForm();

}



function checkEmail() {
    const input_email = document.querySelector('.email input').value;
    var regex4 = /^(([^<>()\[\]\\.,;:\s@"]+(\.[^<>()\[\]\\.,;:\s@"]+)*)|(".+"))@((\[[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\])|(([a-zA-Z\-0-9]+\.)+[a-zA-Z]{2,}))$/;
    if(regex4.test(input_email) === false ) {
        document.querySelector('.email').classList.add('error');
        formResult.email = false;
    } else {
        
        fetch(`check_email.php?email=${encodeURIComponent(String(input_email))}`).then(onResponse).then(jsonEmail);
    }
    checkForm();
}



function checkPassword() {
    const input_password = document.querySelector('.password input').value;
    var regex = /^[A-Za-z0-9]+$/;
    
    if(input_password.length < 8){
        
        document.querySelector('.password').classList.add('error');
        console.log("pass troppo corta");
        formResult.password = false;
    }else if(regex.test(input_password) === false ) {
        console.log("Pass non contiene i caratteri giusti");
        document.querySelector('.password').classList.add('error');
    } else  {
        console.log("la pass va bene");
        document.querySelector('.password').classList.remove('error');
        
        formResult.password = true;
    }
    checkForm();
}

function checkForm() {
    
    // controllo che tutti i campi siano stati controllati 
    Object.keys(formResult).length !==5 || Object.values(formResult).includes(false);
}



// inizializzo un oggetto dove inserire i risultati dei vari check del form
const formResult = {};

// ad ogni casella del form aggiungo un evento che si attiva quando la casella in questione perde il focus
document.querySelector('.username input').addEventListener('blur', checkUsername);
document.querySelector('.nome input').addEventListener('blur', checkNome);
document.querySelector('.cognome input').addEventListener('blur', checkCognome);
document.querySelector('.email input').addEventListener('blur', checkEmail);
document.querySelector('.password input').addEventListener('blur', checkPassword);

if (document.querySelector('.error') !== null) {
    checkUsername(); checkPassword(); checkEmail();
    document.querySelector('.nome input').dispatchEvent(new Event('blur'));
    document.querySelector('.surname input').dispatchEvent(new Event('blur'));
}



