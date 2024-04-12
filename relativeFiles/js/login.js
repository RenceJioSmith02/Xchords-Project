// login script
const container = document.getElementById('container-login');
const registerBtn = document.getElementById('register');
const loginBtn = document.getElementById('login');

registerBtn.addEventListener('click', () => {
    container.classList.add("active");
});

loginBtn.addEventListener('click', () => {
    container.classList.remove("active");
});







// LOGIN POPUP
const ovarlayLogin = document.querySelector("[data-overlay]");

// main button login
document.querySelector("#show-login1").addEventListener("click",function(){
    document.querySelector(".pop-up.login").classList.add("active");
    ovarlayLogin.classList.add("active");
});

document.querySelector(".container-login .close-btn").addEventListener("click",function(){
    document.querySelector(".pop-up.login").classList.remove("active");
    ovarlayLogin.classList.remove("active");
});

// add to cart when not sig in 
function trylang(params) {
    document.querySelector(".pop-up.login").classList.add("active");
    ovarlayLogin.classList.add("active");
}




