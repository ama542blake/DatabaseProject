alert("validation_functions.js running");

let username = document.getElementById('loginUsername');

username.addEventListener('keyup', passwordDisabled);
username.addEventListener('cut', passwordDisabled);
username.addEventListener('keyup', loginBtnDisabled);
username.addEventListener('cut', loginBtnDisabled);

function passwordDisabled(){
	var passwordInput = document.getElementById("loginPassword");
	if(username.value.length<4){
		passwordInput.disabled = true;
	}else{
		passwordInput.disabled = false;
	}
}

let password = document.getElementById("loginPassword");

password.addEventListener('keyup', loginBtnDisabled);
password.addEventListener('cut', loginBtnDisabled);
password.addEventListener('keyup', passwordDisabled);
password.addEventListener('cut', passwordDisabled);

function loginBtnDisabled(){
	var passwordInput = document.getElementById("loginPassword");
	var loginBtn = document.getElementById("loginBtn");
	
	if(passwordInput.value.length<6){
		loginBtn.disabled = true;
	}else{
		loginBtn.disabled = false;
	}
	
}

let createUsername = document.getElementById("createUsername");

createUsername.addEventListener('keyup', createPasswordDisabled);
createUsername.addEventListener('cut', createPasswordDisabled);
createUsername.addEventListener('click', createPasswordDisabled);

function createPasswordDisabled(){
 var usernameInput = document.getElementById("createUsername");
 var passwordInput = document.getElementById("createPassword");
 var emailInput = document.getElementById("createEmail");
 var createBtn = document.getElementById("createBtn");
 
 if(usernameInput.value.length<4){
  passwordInput.disabled = true;
  emailInput.disabled = true;
  createBtn.disabled = true;
 }else{
  passwordInput.disabled = false;
 }
}

let createPassword = document.getElementById("createPassword");

createPassword.addEventListener('keyup', createEmailDisabled);
createPassword.addEventListener('cut', createEmailDisabled);
createPassword.addEventListener('click', createEmailDisabled);

function createEmailDisabled(){
 var passwordInput = document.getElementById("createPassword");
 var emailInput = document.getElementById("createEmail");
 var createBtn = document.getElementById("createBtn");
 
 if(passwordInput.value.length<6){
  emailInput.disabled = true;
  createBtn.disabled = true;
 }else{
  emailInput.disabled = false;
 }
}

let createEmail = document.getElementById("createEmail");

createEmail.addEventListener('keyup', createBtnDisabled);
createEmail.addEventListener('cut', createBtnDisabled);
createEmail.addEventListener('click', createBtnDisabled);

function createBtnDisabled(){
 var emailInput = document.getElementById("createEmail");
 var createBtn = document.getElementById("createBtn");
 
 if((emailInput.value.includes("@"))&&(emailInput.value.length>5)){
  createBtn.disabled = false;
 }else{
  createBtn.disabled = true;
 }
}