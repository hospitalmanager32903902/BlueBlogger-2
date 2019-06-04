
var navbar = document.querySelector("#navbar");
var navbarOffsetTop = navbar.offsetTop;
window.addEventListener("scroll",()=>{
    if(window.pageYOffset >= navbarOffsetTop){
        navbar.classList.add("sticky");
    } else {        
        navbar.classList.remove("sticky");
    }
});


window.onload = ()=>{
    var blog = document.querySelector("body").innerText;
    blog = blog.split("").map((char)=>{
        if ( char.charCodeAt() == '�'.charCodeAt() ){                    
            //console.log(char);
            return "'";
        } else {
            return char;
        }
    });
    //document.querySelector("body").innerText = blog.join("");
}
// window.addEventListener("load",()=>{
//     var body = document.querySelector("body");
//     body.style.opacity ="1";
//     body.style.transform ="skew(0deg)";
//     body.style.left ="0%";
// });

function homepage_sidelogin(node) {

    var username = node.querySelector("#userpane-username").value;
    var password = node.querySelector("#userpane-password").value;

    var ajaxReqquest = new XMLHttpRequest();
    ajaxReqquest.open("POST","login.php",false);    
    ajaxReqquest.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
    ajaxReqquest.send(`operation=homepagesidebarlogin&username=${username}&password=${password}`);    
    if( ajaxReqquest.responseText && ajaxReqquest.responseText != "login failed" ){
        response = JSON.parse(ajaxReqquest.responseText);
        node.classList.remove("shake");
        node.innerHTML = 
                `<div id="userpane-userdetail" onclick=window.location="user.php">
                    <img src="${response.user_profile_picture_link}" width="100px" height="100px" >
                    <span id="userpane-userdetail-name">${response.user_fullname}</span>
                    <div id="userpane-userdetail-age">${response.user_age}</div>
                    <div id="userpane-userdetail-gender">${response.user_gender}</div>
                    <div id="userpane-userdetail-profession">${response.user_profession}</div>
                </div>`;
        // changing the left side nav button
        document.querySelector("#navbar > a:first-child").innerText = "Dashboard";
        document.querySelector("#navbar > a:first-child").href = "dashboard.php";
        // adding the createnewpost button 
        var cnp = '<a id="homepage-createnewpost" href="createnewpost.php"><span>+</span> Create New Post</a>';
        document.querySelector("#postContainer").innerHTML = cnp + document.querySelector("#postContainer").innerHTML;
    } else {
        node.classList.add("shake");
        node.querySelector("#userpane-username").value = "";
        node.querySelector("#userpane-password").value = "";
        setTimeout(()=>{            
            node.classList.remove("shake");
        },1000)
    }
}

function showNotification(e) {
    // var offTop = bell.parentElement.offsetTop;
    // var offLeft = bell.parentElement.offsetLeft;
    console.log(window.event);
    var notpad = document.querySelector("#notificationpad");
    if ( notpad.style.display !="block" ){
        notpad.style.display="block";
    } else {
        notpad.style.display="none";
    }
    // notpad.style.top = (window.event.clientY+30) + "px";
    // notpad.style.left = (window.event.clientX-125) + "px";
}