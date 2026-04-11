const toggle = document.getElementById("toggleMenu");
const backMenu = document.getElementById("backMenu");
const menu = document.getElementById("menu");
const overlay = document.getElementById("overlay");
const menuText = document.querySelector(".menu-text");

toggle.addEventListener("click", function(){
    menu.classList.toggle("show");
    overlay.classList.toggle("show");
    
});

backMenu.addEventListener("click", function(){
    menu.classList.remove("show");
    overlay.classList.remove("show");
});

overlay.addEventListener("click", function(){
    menu.classList.remove("show");
    overlay.classList.remove("show");
});