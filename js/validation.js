function validation(){
    let frm = document.regForm;
    let ok = true;
    let email = frm.inputEmail;
    let errEmail = document.getElementById('errEmail');
    if(!email.value.length){
        errEmail.innerText = "L'e-mail n'est pas valide";
        email.classList.add('input-error');
        ok = false;
    } else{
        errEmail.innerText = "";
        email.classList.remove('input-error');
    }

    let password = frm.inputPassword;
    let errPassword = document.getElementById('errPassword');
    if(password.value.length >= 8 && /[A-Z]/.test(password.value) && /[a-z]/.test(password.value) && /[0-9]/.test(password.value)){
        errPassword.innerText = "";
        password.classList.remove('input-error');
    } else{
        errPassword.innerText = "Le mot de passe doit contenir au moins 8 caractères, une lettre majuscule, une lettre minuscule et un chiffre.";
        password.classList.add('input-error');
        ok = false;
    }

    let confirmPassword = frm.inputConfirmPassword;
    let errConfirmPassword = document.getElementById('errConfirmPassword');
    if(confirmPassword.value === password.value){
        errConfirmPassword.innerText = "";
        confirmPassword.classList.remove('input-error');
    } else{
        errConfirmPassword.innerText = "Vous n'avez pas confirmé le mot de passe.";
        confirmPassword.classList.add('input-error');
        ok = false;
    }

    let phoneNumber = frm.inputPhoneNumber;
    let errPhoneNumber = document.getElementById('errPhoneNumber');
    if(/^\+[0-9]*$/.test(phoneNumber.value)){
        errPhoneNumber.innerText = "";
        phoneNumber.classList.remove('input-error');
    } else{
        errPhoneNumber.innerText = "Le numéro de téléphone n'est pas valide.";
        phoneNumber.classList.add('input-error');
        ok = false;
    }

    let firstName = frm.inputFirstName;
    let errFirstName = document.getElementById('errFirstName');
    if(firstName.value.length < 1){
        errFirstName.innerText = "Le nom doit avoir au moins 1 caractère.";
        firstName.classList.add('input-error');
        ok = false;
    } else{
        errFirstName.innerText = "";
        firstName.classList.remove('input-error');
    }

    let lastName = frm.inputLastName;
    let errLastName = document.getElementById('errLastName');
    if(lastName.value.length < 1){
        errLastName.innerText = "Le prénom doit avoir au moins 1 caractère.";
        lastName.classList.add('input-error');
        ok = false;
    } else{
        errLastName.innerText = "";
        lastName.classList.remove('input-error');
    }

    let nickname = frm.inputNickName;
    let errNickname = document.getElementById('errNickName');
    if(nickname.value.length < 1){
        errNickname.innerText = "Le prénom doit avoir au moins 1 caractère.";
        nickname.classList.add('input-error');
        ok = false;
    } else{
        errNickname.innerText = "";
        nickname.classList.remove('input-error');
    }

    let selection = frm.countries;
    console.log("Pays selecte: " + selection.options[selection.selectedIndex].text);

    let usage = frm.usage;
    for(let i = 0; i < usage.length; i++){
        if(usage[i].checked)
            console.log(usage[i].value);
    }

    /*let checkboxes = frm.musicType;
    for(let i = 0; i < checkboxes.length; i++){
        if(checkboxes[i].checked)
            console.log(checkboxes[i].value);
    }*/

    return ok;
}