



function checkPassword() {
    const input_password = document.querySelector('.password input').value;
    
  
    if(input_password.length < 8) {
        
        document.querySelector('.password').classList.add('error');
        document.querySelector('.password span').textContent = "Inserire una password";
        formAccesso.pwd = false;
        checkFormLog();
        
    } else  {
        document.querySelector('.password').classList.remove('error');
        formAccesso.pwd = true;
    }
    
}





function checkUsername() {
    const input_username = document.querySelector('.username input').value.trim();
    if(!/^[a-zA-Z0-9_]{1,20}$/.test(input_username)) {
        document.querySelector('.username').classList.add('error');
        document.querySelector('.username span').textContent = "Max 20 Caratteri ( lettere, numeri e undescore)";
        formAccesso.user=false;
        checkFormLog();
    } else {
        
        
        document.querySelector('.username').classList.remove('error');
        formAccesso.user=true;
    }
}

function checkFormLog() {

    Object.keys(formAccesso).length !==2 || Object.values(formAccesso).includes(false);
}


const formAccesso = {};

document.querySelector('.username input').addEventListener('blur', checkUsername);
document.querySelector('.password input').addEventListener('blur' , checkPassword);

if (document.querySelector('.error') !== null) { checkUsername();  checkPassword()}