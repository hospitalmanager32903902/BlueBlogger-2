
var writingtool = document.querySelector("#writingtool");
var writingtoolOffsetTop = writingtool.offsetTop;
window.addEventListener("scroll",()=>{
    if(window.pageYOffset >= writingtoolOffsetTop){
        writingtool.classList.add("sticky");
    } else {        
        writingtool.classList.remove("sticky");
    }
});



function publish(){

    // set animation

    var post_thumb = document.querySelector("#postthumbnail").files[0];
    var post_title = document.querySelector("#post_title").value;
    var post_excerpt = document.querySelector("#post_excerpt").value;
    var post_body = document.querySelector("#writing_pad_textversion").value.trim().split("").map((elem)=>{
        return elem.charCodeAt() == 39 || elem.charCodeAt() == 34 ? "0" : elem;
    }).join("");
    console.log(post_body);
    if ( !(post_thumb && post_title.length && post_excerpt.length && post_body.length ) ) {
        alert(`Enter all the fields`);
        return;
    }
    console.log(post_body);
    var formData = new FormData();

    formData.append(
        "operation",
        "createnewpost"
    );
    formData.append(
        "post_thumnail",
        post_thumb
    );
    formData.append(
        "post_title",
        post_title
    );
    formData.append(
        "post_excerpt",
        post_excerpt
    );
    formData.append(
        "post_body",
        post_body
    );
    
    var ajaxReqquest = new XMLHttpRequest();
    ajaxReqquest.open("POST","createnewpost.php",false);    
    ajaxReqquest.send(formData);
    if ( ajaxReqquest.responseText == "Successsful" ) {
        // notify for post creation success
        alert("Successsful");
        window.location = "dashboard.php";
    } else {        
        // notify for post creation faliure
    }
}

function makeBold() {
    var pad = document.querySelector("#writing_pad_textversion");
    var selected = pad.innerHTML.substring(pad.selectionStart,pad.selectionEnd);
    pad.innerHTML = `<b>${selected}</b>`;

    console.log(selected);
}