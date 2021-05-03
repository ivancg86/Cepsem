var pwicon = document.querySelector('.pw-icon');
var pwinput = document.getElementById('contrasenya');

if(pwicon){
    pwicon.onclick = function () {
        pwicon.classList.toggle('pw-icon--hide');
        if(pwinput.type == "text")pwinput.type = "password";
        else pwinput.type = "text"
    }
}
