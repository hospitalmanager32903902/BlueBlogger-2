window.addEventListener("load",function(){

});


function update() {

    var post_thumb = document.querySelector("#postthumbnail").files[0];
    var post_title = document.querySelector("#post_title").value.trim();
    var post_excerpt =  document.querySelector("#post_excerpt").value.trim();
    var post_body =  document.querySelector("#writing_pad_textversion").value.trim();
    let post_id = parseInt(window.location.search.split("=")[1]);

    if ( !(post_title.length && post_excerpt.length && post_body.length) ) {
        alert(`Enter all the fields`);
        return;
    }
    // makes a new form data to send data to server
    var formData = new FormData();
        formData.append(
            "operation",
            "updatepost"
        );
        if( post_thumb ) {
            formData.append(
                "post_thumnail",
                post_thumb
            );
        }
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
        formData.append(
            "post_id",
            post_id
        );
    
    var ajaxReqquest = new XMLHttpRequest();
    ajaxReqquest.open("POST","editpost.php",false);    
    ajaxReqquest.send(formData);
    if ( ajaxReqquest.responseText.trim() == "updated" ) {
        // notify for post creation success
        alert("updated");
        window.location = "dashboard.php";
    } else {        
        // notify for post creation faliure
        alert(ajaxReqquest.responseText);
    }
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

function cancel() {    
    window.location = "dashboard.php";
}