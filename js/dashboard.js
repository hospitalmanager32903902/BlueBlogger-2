function highlightSelected(node){
    
    setTimeout(() => {
        fixNavSize();
    }, 1);

    node.classList.add("selected");
    node.parentElement.querySelectorAll("*").forEach( elem => {
        elem.classList.remove("selected");
    });    
    node.classList.add( "selected" );
} highlightSelected( N("#posts") );

function renderAllPost( data,count ){
    var post = 
        `<div class="post" data-postid="${data.post_id}">
                <span class="dashboard-post-element dashboard-post-number">${count}</span>       
                <span class="dashboard-post-element dashboard-post-tumbnail">
                    <img src=img/post_image/${data.post_thumbnail} width="100%" height="100%" />
                </span>
                <a href="post.php?post=${data.post_id}">
                    <span class="dashboard-post-title dashboard-post-element">${data.post_title}</span>
                </a>
                <span id="" class="dashboard-post-visit dashboard-post-element">${data.post_visit_count}</span>
                <span id="" class="dashboard-post-comments dashboard-post-element">${data.post_comment_count}</span>
                
                <!-- delete post ---->
                <span id="dashboard-post-delete" class="dashboard-post-element"  onclick="alertPrompt(this.parentElement,'deletepost')">
                    <svg viewBox="0 0 24 24" id="ic_delete_24px" width="50%" height="50%"><path   d="M6 19c0 1.1.9 2 2 2h8c1.1 0 2-.9 2-2V7H6v12zM19 4h-3.5l-1-1h-5l-1 1H5v2h14V4z"></path></svg>
                </span>
                <!-- edit post ---->
                <span id="dashboard-post-edit" class="dashboard-post-element" onclick="window.location='editpost.php?postid=${data.post_id}'">
                    <svg viewBox="0 0 24 24" id="ic_edit_24px" width="50%" height="50%"><path d="M3 17.25V21h3.75L17.81 9.94l-3.75-3.75L3 17.25zM20.71 7.04a.996.996 0 0 0 0-1.41l-2.34-2.34a.996.996 0 0 0-1.41 0l-1.83 1.83 3.75 3.75 1.83-1.83z"></path></svg>
                </span>
                <span data-post-status="${data.post_status}" id="dashboard-post-unpublish" class="dashboard-post-element" onclick="pubunpub(this)">
                    ${data.post_status=="public"? "UNPUBLISH" : "PUBLISH" }     
                </span>
            </div>`;
    var allpostlist = N("#allpostlist");
    allpostlist.innerHTML += post;
}

function renderAllComments( data,count) {
    var comment = 
    `<div class="comment" data-commentid="${data.comment_id}">
    
            <!-- comment commentor name ---->
            <span id="dashboard-comment-number" class="dashboard-comment-element">${count}</span>  

            <!-- comment commentor ---->    
            <a href="user.php?username=${data.comment_post_author_username}">
                <span id="dashboard-comment-commentor" class="dashboard-comment-element">${data.comment_commentor_fullname}</span>
            </a>

            <!-- comment content ---->
            <span id="dashboard-comment-content" class="dashboard-comment-element">${data.comment_content}</span>
            
            <!-- comment post ---->
            <a href="post.php?post=${data.comment_post_id}">
                <span id="dashboard-comment-post" class="dashboard-comment-element">${data.post_title}</span>
            </a>

            <!-- comment date ---->
            <span id="dashboard-comment-date" class="dashboard-comment-element">${data.comment_date.split("-")[2]}-${data.comment_date.split("-")[1]}-${data.comment_date.split("-")[0]}</span>
            
            <!-- comment delete sender icon ---->
            <span id="dashboard-comment-delete" class="dashboard-comment-element"  onclick="alertPrompt(this.parentElement,'deletecomment')">
                <svg viewBox="0 0 24 24" id="ic_delete_24px" width="30px" height="30px"><path   d="M6 19c0 1.1.9 2 2 2h8c1.1 0 2-.9 2-2V7H6v12zM19 4h-3.5l-1-1h-5l-1 1H5v2h14V4z"></path></svg>
            </span>

            <!-- comment text sender icon ---->
            <span id="dashboard-comment-text" class="dashboard-comment-element" onclick="text(this)">
                     
            </span>
        </div>`;
        N("#allcommentslist").innerHTML += comment;
        console.log(data);
}

//  fetches the posts from the database and retuens it
//  it does it in synchronusly method 
function getData(type){    
    if ( type == "getposts" ) {        
        var ajaxReqquest = new XMLHttpRequest();
        ajaxReqquest.open("POST","dashboard.php",false);
        ajaxReqquest.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
        ajaxReqquest.send(`operation=getdashboardpostlist`);   
    } else if ( type == "getcomments" ) {
        var ajaxReqquest = new XMLHttpRequest();
        ajaxReqquest.open("POST","dashboard.php",false);
        ajaxReqquest.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
        ajaxReqquest.send(`operation=getdashboardcommentlist`);
    }     
    return ajaxReqquest.responseText;
}

// this the main function where the program starts
function main(){

    // rendering all the post 
    JSON.parse( getData("getposts") ).forEach(( data,count ) => {
        renderAllPost( data,count + 1 );
    });
    
    // rendering all the Comments
    JSON.parse( getData("getcomments") ).forEach(( data,count ) => {
        renderAllComments( data,count + 1 );
    });


}

// This function throws an prompt alert when any
// deletion button is clicked to to be deleted
function alertPrompt(node,type){
    var navbar = document.querySelector("#navbar");
    // html code for the modal
    if ( type !="deletecomment" ) {
        var modal = 
            `<div id="alertPromptModal" style="overflow:hidden;opacity:0;width:${navbar.offsetWidth}px;height:100vh;background: #000000a3;position: absolute;top: 0;left: 0px;z-index: 100;">
                <div id="modalContent" style=" transition-duration:0.2s; transition-timing-function:cubic-bezier(0, 0, 0, 2.79); transform:scale(.5); text-align: center;width: 515px;height: 200px;border-radius: 5px;position:relative;margin:200px auto;background: white;box-sizing: border-box;padding: 20px;opacity: 1;">
                    <h3 style="margin: 1px 1px 55px 0px;"> Are you Sure You Want to Delete This post ?  </h3>
                    <button onclick="deletePost(${node.getAttributeNode("data-postid").value})" style="font-family:verdana;font-size: 17px;color: white;border:0px;width: 48%;height:50px;background: dodgerblue;cursor: pointer;border-radius: 4px;"> Yes </button>
                    <button onclick="deletePost()" style="font-family:verdana;font-size: 17px;color: white;border:0px;width: 48%;height:50px;background: dodgerblue;cursor: pointer;border-radius: 4px;"> Cancel </button>
                </div>
            </div>
            `;        
    } else if ( type =="deletecomment" ){
        var modal = 
        `<div id="alertPromptModal" style="overflow:hidden;opacity:0;width:${navbar.offsetWidth}px;height:100vh;background: #000000a3;position: absolute;top: 0;left: 0px;z-index: 100;">
            <div id="modalContent" style=" transition-duration:0.2s; transition-timing-function:cubic-bezier(0, 0, 0, 2.79); transform:scale(.5); text-align: center;width: 515px;height: 200px;border-radius: 5px;position:relative;margin:200px auto;background: white;box-sizing: border-box;padding: 20px;opacity: 1;">
                <h3 style="margin: 1px 1px 55px 0px;"> Are you Sure You Want to Delete This post ?  </h3>
                <button onclick="deleteComment(${node.getAttributeNode("data-commentid").value},)" style="font-family:verdana;font-size: 17px;color: white;border:0px;width: 48%;height:50px;background: dodgerblue;cursor: pointer;border-radius: 4px;"> Yes </button>
                <button onclick="deleteComment()" style="font-family:verdana;font-size: 17px;color: white;border:0px;width: 48%;height:50px;background: dodgerblue;cursor: pointer;border-radius: 4px;"> Cancel </button>
            </div>
        </div>
        `; 
    }
    // pushing the the modal into body
    document.body.innerHTML += modal;
    
    // for making the modal animated
    setTimeout(() => {
        alertPromptModal = N("#alertPromptModal");
        alertPromptModal.style.opacity = 1;   
        N("#modalContent").style.transform = "scale(1)";   
        alertPromptModal.style.transitionTimingFunction = "cubic-bezier(0, 0, 0, 2.79)";     
    }, 1);
}

// this function performs the deletion operation. On being clicked on delete button the alertPromt()
// function is triggered which prompts the user for confirmation if he confirms then this deletePost()
// function triggered with post id as argument. then deletePost() deletes the post with the id of postid
function deletePost(postid){
    // modal fade in linearly
    alertPromptModal.style.opacity = 0;
    alertPromptModal.style.transitionTimingFunction="linear"; 
    // after fading in completely for 300 milisecond remove modal 
    setTimeout(() => {       
        alertPromptModal.remove();
    }, 300);
    if(postid){
        // deletion operation of the post offline
        console.log("Delete the post of ID " + postid);
        var p = document.querySelectorAll(".post");
        var postnumber;
        p.forEach((p,i)=>{
            if(p.getAttributeNode("data-postid").value == postid){
                postnumber = i;
            }
        });
        p = p[postnumber];
        setTimeout(()=>{
            p.style.opacity="0";
            p.style.height = "0px";
        },1);
        setTimeout(()=>{
            p.remove();
        },500);

        // calling deletePostFromDatabase function with post id as argument 
        // to delete from the database
        deletePostFromDatabase(postid);
    }
}
function deletePostFromDatabase(postid) {
    var ajaxReqquest = new XMLHttpRequest();
    ajaxReqquest.open("POST","dashboardOperationBackEnd.php",false);    
    ajaxReqquest.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
    ajaxReqquest.send(`operation=delete&postid=${postid}`);    
    if( ajaxReqquest.responseText == "Post Deleted"){
        console.log("Post Deleted");
    } else {
        console.log(ajaxReqquest.responseText);
    }
}
// -----------------------------/deletePost()------------------------------------- //

// ----------------------------- pubunpub()------------------------------------- //

function pubunpub(node_pub_unpub) {
    var post = node_pub_unpub.parentElement;
    var postid = post.getAttributeNode("data-postid").value;
    var ajaxReqquest = new XMLHttpRequest();
    ajaxReqquest.open("POST","dashboardOperationBackEnd.php",false);    
    ajaxReqquest.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
    ajaxReqquest.send(`operation=${node_pub_unpub.getAttributeNode('data-post-status').value}&postid=${postid}`);    
    console.log(ajaxReqquest.responseText);
    if( ajaxReqquest.responseText == "public" || ajaxReqquest.responseText == "private" ){
        node_pub_unpub.getAttributeNode('data-post-status').value = ajaxReqquest.responseText;
        node_pub_unpub.innerHTML = ajaxReqquest.responseText == "public" ? "<span style='transition-duration:1s;color:green'>UNPUBLISH</span>" : "<span style='transition-duration:1s;color:red'>PUBLISH</span>";
    } else {
        alert(ajaxReqquest.responseText);
    }
}

// ----------------------------- /pubunpub()------------------------------------- //

// ----------------------------- deleteComment()------------------------------------- //

function deleteComment(commentid) {
    // modal fade in linearly
    alertPromptModal.style.opacity = 1;
    alertPromptModal.style.transitionTimingFunction="linear"; 
    alertPromptModal.style.transitionDeuration=".8s"; 
    // after fading in completely for 300 milisecond remove modal 
    setTimeout(() => {       
        alertPromptModal.remove();
    }, 10);
    if(commentid){
        // deletion operation of the post offline
        console.log("Delete the Comment of ID " + commentid);
        var c = document.querySelectorAll(".comment");
        var commentnumber;
        c.forEach((c,i)=>{
            if( c.getAttributeNode("data-commentid").value == commentid ){
                commentnumber = i;
            }
        });
        setTimeout( ()=>{
            c = c[commentnumber]; // comment we have to delete
            c.classList.remove("removeAnimationPart_2");
            c.classList.add("removeAnimation");
        } , 1);
        if( c.previousElementSibling ){
            c.nextElementSibling ? c.nextElementSibling.classList.add("removeAnimationPart_2") : "";
        }

        // remove that node after the disappearing 
        // animation has done running 
        setTimeout(()=>{
            c.remove();
        },500);

        // calling deletePostFromDatabase function with comment id as argument 
        // to delete from the database
        deleteCommentFromDatabase(commentid);
    }
}
// ----------------------------- /deleteComment()------------------------------------- //


// ----------------------------- deleteCommentFromDatabase()------------------------------------- //
function deleteCommentFromDatabase(commentid) {
    var ajaxReqquest = new XMLHttpRequest();
    ajaxReqquest.open("POST","dashboardOperationBackEnd.php",false);    
    ajaxReqquest.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
    ajaxReqquest.send(`operation=deletecomment&commentid=${commentid}`);    
    if( ajaxReqquest.responseText == "Comment Deleted"){
        console.log("Comment Deleted");
    } else {
        console.log(ajaxReqquest.responseText);
    }
}
// ----------------------------- /deleteCommentFromDatabase()------------------------------------- //

window.addEventListener("load",()=>{
    main();
});


function showComments(node) {
    
    // rendering all the Comments
    
    N("#allcommentslist").innerHTML = "";
    JSON.parse( getData("getcomments") ).forEach(( data,count ) => {
        renderAllComments( data,count + 1 );
    });
    highlightSelected(node);
    N("#all-post-content").style.display="none";
    N("#all-comment-content").style.display="inline-block";
    // render comments 
}
function showPosts(node) {
    highlightSelected(node);
    N("#all-post-content").style.display="inline-block";
    N("#all-comment-content").style.display="none";
    setTimeout(() => {
        reveserFixNavSize();
    }, 1);
}



function fixNavSize(){
    console.log("fixNavSize");
    var navbar = document.querySelector("#navbar");
    var rightNav = document.querySelector("#rightNav");
    navbar.style.width = document.body.scrollWidth + "px";
    var tmpx = rightNav.offsetLeft;
    window.addEventListener("scroll", ()=>{
        rightNav.style.left = (tmpx + window.scrollX) + "px";
    });
};


function reveserFixNavSize(){
    console.log("reveserFixNavSize");
    var navbar = document.querySelector("#navbar");
    navbar.style.width = "100%";
};
