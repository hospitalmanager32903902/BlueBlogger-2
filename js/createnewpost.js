
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
    var post_title = document.querySelector("#post_title").value.trim();
    var post_excerpt =  document.querySelector("#post_excerpt").value.trim();
    var post_body =  document.querySelector("#writing_pad_textversion").value.trim();


    if ( !(post_thumb && post_title.length && post_excerpt.length && post_body.length ) ) {
        alert(`Enter all the fields`);
        return;
    }
    // makes a new from data to send data to server
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

// shows the image on being chosen as thumbnail pic
function showThumb(){
    var thumbpic = document.querySelector("#thumbpic");
    var file = document.querySelector("#postthumbnail");
    var fr = new FileReader();
    fr.readAsDataURL(file.files[0]);  
    fr.onload = function (e) {   
        thumbpic.src = fr.result;
        thumbpic.style.width = "100%";
        thumbpic.style.height = "100%";
        thumbpic.style.border = "4px solid white";
        thumbpic.style.margin = "0px";
    }
}

function cancel(params) {
    let con = confirm("Are You Sure You Want to Drop Your Work? ");
    if (con) {
        window.location = "dashboard.php";
    }
    
}