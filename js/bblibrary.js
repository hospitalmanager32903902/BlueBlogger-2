
var navbar = document.querySelector("#navbar");
var navbarOffsetTop = navbar.offsetTop;
window.addEventListener("scroll",()=>{
    if(window.pageYOffset >= navbarOffsetTop){
        navbar.classList.add("sticky");
    } else {        
        navbar.classList.remove("sticky");
    }
});



// --------------- Functions to make our life a little easier ----------------------


function N(indentifier) {
    return document.querySelector(indentifier);
}