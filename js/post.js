

function shootcomment() {
    // setting data variables
    var comment_content = document.querySelector("#newcomment").value;
    var commentor_username = document.querySelector("#userpane-userdetail").getAttribute("data-username");
    var commentor_fullname = document.querySelector("#userpane-userdetail-name").innerHTML;
    var comment_post_id = parseInt(document.querySelector("#content").getAttribute("data-post-id"));
    console.log();
    const ajaxReq = new XMLHttpRequest();
    ajaxReq.open("POST","comments.php",false);
    ajaxReq.setRequestHeader("Content-type","application/x-www-form-urlencoded");
    ajaxReq.send(`operation=registernewcomment&comment_content='${comment_content}'&commentor_username='${commentor_username}'&comment_post_id=${comment_post_id}&commentor_fullname='${commentor_fullname}'`);

    if ( ajaxReq.responseText == "successful" ) {        
        var newcomment = `<div class="comment newcommentanimation" >
                                <div class="commentor">
                                    <img src="${N('#userpane-userdetail>img').src}" alt="" width="80px" height="80px" class="commentorAvatar">  <!-- Commentor Avatar -->
                                    <label for="commentorAvatar">${commentor_fullname}</label>
                                </div>                       
                                <div class="commentcontent"> 
                                    ${comment_content}                       
                                </div>
                            </div>`;
        N("#comments").innerHTML = newcomment + N("#comments").innerHTML;
        N("#newcomment").value = "";
        setTimeout(() => {
            N(".comment").classList.remove("newcommentanimation");
        }, 3001);
    } else {
        //alert(ajaxReq.responseText);
    }
}

function N(identifier) {
    return document.querySelector(identifier);
}



