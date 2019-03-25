alert("validation_functions.js running");

let username = document.getElementById('loginUsername');
username.addEventListener('keyup', passwordDisabled);
username.addEventListener('cut', passwordDisabled);

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

function loginBtnDisabled(){
	var passwordInput = document.getElementById("loginPassword");
	var loginBtn = document.getElementById("loginBtn");
	
	if(passwordInput.value.length<6){
		loginBtn.disabled = true;
	}else{
		loginBtn.disabled = false;
	}
	
}

