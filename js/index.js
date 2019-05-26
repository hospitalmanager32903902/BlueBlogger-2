
var navbar = document.querySelector("#navbar");
var navbarOffsetTop = navbar.offsetTop;
window.addEventListener("scroll",()=>{
    if(window.pageYOffset >= navbarOffsetTop){
        navbar.classList.add("sticky");
    } else {        
        navbar.classList.remove("sticky");
    }
});


// window.addEventListener("load",()=>{
//     var body = document.querySelector("body");
//     body.style.opacity ="1";
//     body.style.transform ="skew(0deg)";
//     body.style.left ="0%";
// });