
let table = [N("#all-post-content"),N("#all-user-content"),N("#comment-table")];


function highlightSelected(node){
    

    node.classList.add("selected");
    node.parentElement.querySelectorAll("*").forEach( elem => {
        elem.classList.remove("selected");
    });    
    node.classList.add( "selected" );


} N("#posts").click();

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

                <span style="width:140px; overflow:hidden;"  class="dashboard-post-publish-date dashboard-post-element">${data.post_publish_date}</span>
                
                <!-- delete post ---->
                <span class="dashboard-post-element dashboard-post-delete"  onclick="alertPrompt(this.parentElement,'deletepost')">
                    <svg viewBox="0 0 24 24" id="ic_delete_24px" width="24px" height="24px"><path   d="M6 19c0 1.1.9 2 2 2h8c1.1 0 2-.9 2-2V7H6v12zM19 4h-3.5l-1-1h-5l-1 1H5v2h14V4z"></path></svg>
                </span>
                <!-- edit post ---->
                <span id="dashboard-post-edit" class="dashboard-post-element" onclick="window.location='editpost.php?postid=${data.post_id}'">
                    <svg viewBox="0 0 24 24" id="ic_edit_24px" width="50%" height="50%"><path d="M3 17.25V21h3.75L17.81 9.94l-3.75-3.75L3 17.25zM20.71 7.04a.996.996 0 0 0 0-1.41l-2.34-2.34a.996.996 0 0 0-1.41 0l-1.83 1.83 3.75 3.75 1.83-1.83z"></path></svg>
                </span>
                <span data-post-status="${data.post_status}" class="dashboard-post-unpublish dashboard-post-element" onclick="pubunpub(this)">   
                    <div class="pubunpubToggler">
                        <span>${data.post_status.toUpperCase()}</span>
                        <div class="pubunpubTogglerButton">                             
                            
                        <div>
                    </div> 
                </span>
            </div>`;
    var allpostlist = N("#allpostlist");
    allpostlist.innerHTML += post;
}

function renderAllComments( data,count ) {
    var comment = `
                    <div class="comment" data-comment-id="${data.comment_id}">                        
                        <span class="dashboard-comment-element comment-count">${count}</span>
                        <span class="dashboard-comment-element comment-commentor"><a href="user.php?username=${data.comment_commentor_username}">${data.comment_commentor_fullname}</a></span>
                        <span class="dashboard-comment-element comment-content" style="font-size: 14px;overflow-y: auto;">${data.comment_content}</span>
                        <span class="dashboard-comment-element comment-post"  style="font-size:13px;color:#343434; overflow-y: auto;"><a href=post.php?post=${data.post_id}>${data.post_title}</a></span>
                        <span class="dashboard-comment-element comment-date">${data.comment_birthdate}</span>                        
                        <span class="dashboard-comment-element comment-delete-checkbox">
                            <input style="transform: scale(2);margin-top: 14px;" type="checkbox" data-user-name="${data.comment_id}">
                        </span>
                    </div>
                `;
    N("#all-comments-list").innerHTML += comment;
    console.log(data);
}

function renderAllUser(data,count) {
    var user = `
                <tr data-user-name="${data.user_username}">                        
                    <td class="user-username"><a href="user.php?username=${data.user_username}">${data.user_fullname}</a></td>
                    <td class="user-username">${data.user_username}</td>
                    <td class="user-id" style="width:80px;">${data.user_id}</td>
                    <td class="user-posts">${data.user_post_count}</td>
                    <td class="user-joined" style='font-size:14px;color:#2a2a2a;'>${data.user_joined}</td>
                    <td class="user-email" style="width:200px;">${data.user_email}</td>
                    <td class="user-from">${data.user_from}</td>
                    <td class="user-delete-checkbox" style="width:50px;">
                        <input style="
                        transform: scale(1.5);
                    " type="checkbox" data-user-name="${data.user_username}">
                    </td>
                </tr>
                `;
    N("#user-table-body").innerHTML += user;
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

    }  else if ( type == "getusers" ) {
        var ajaxReqquest = new XMLHttpRequest();
        ajaxReqquest.open("POST","dashboard.php",false);
        ajaxReqquest.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
        ajaxReqquest.send(`operation=getdashboarduserlist`);
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

    // rendering all the users
    if( N("#users") ) {
        JSON.parse( getData("getusers") ).forEach(( data,count ) => {
            renderAllUser( data,count + 1 );
        });
    }


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

function pubunpub(node) {
    var post = node.parentElement;
    var postid = post.getAttributeNode("data-postid").value;
    var ajaxReqquest = new XMLHttpRequest();
    ajaxReqquest.open("POST","dashboardOperationBackEnd.php",false);    
    ajaxReqquest.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
    ajaxReqquest.send(`operation=${node.innerText.toLowerCase()}&postid=${postid}`);    
    console.log(ajaxReqquest.responseText);
    if( ajaxReqquest.responseText == "public" || ajaxReqquest.responseText == "private" ){
        
        let button = node.querySelector(".pubunpubTogglerButton");        
        let bar = node.querySelector(".pubunpubToggler");     
        let text = node.querySelector("div > span");

        if( text.innerText.trim().toUpperCase() == "PUBLIC" ){
            button.style.left = "62px";
            button.style.background = "linear-gradient(to left,#b3b3b3, white)";
            bar.style.background = "lightcoral";
            text.style.left = "3px";
            setTimeout( ()=>{
                text.innerText = "PRIVATE";
            },165);
        } else {
            button.style.left = "-8px";
            button.style.background = "linear-gradient(to right,#b3b3b3, white)";
            bar.style.background = "#48a5ff";
            text.style.left = "21px";
            setTimeout( ()=>{
                text.innerText = "PUBLIC";
            },135);
        }
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
  
    alertPromptModal.remove();

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

        // setting the removeAnimation class which makes the animation that we want disappear
        c = c[commentnumber]; // comment node we have to delete
        c.classList.remove("removeAnimationPart_2");
        c.classList.add("removeAnimation");

        if( c.previousElementSibling ){
            c.nextElementSibling ? c.nextElementSibling.classList.add("removeAnimationPart_2") : "";
        }

        // remove that node after the "disappearing animation" has done running 
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
    
    Array.from( document.querySelectorAll(".dashboard-post-unpublish") ).forEach( function(node){
        let button = node.querySelector(".pubunpubTogglerButton");        
        let bar = node.querySelector(".pubunpubToggler");     
        let text = node.querySelector("div > span");

        if( text.innerText.trim().toUpperCase() != "PUBLIC" ){
            button.style.left = "62px";
            button.style.background = "linear-gradient(to left,#b3b3b3, white)";
            bar.style.background = "lightcoral";
            text.style.left = "3px";
            text.innerText = "PRIVATE";
        } else {
            button.style.left = "-8px";
            button.style.background = "linear-gradient(to right,#b3b3b3, white)";
            bar.style.background = "#48a5ff";
            text.style.left = "21px";
            text.innerText = "PUBLIC";
        }
    });


});


function showComments(node) {    
    
    highlightSelected(node);
    table = [N("#all-post-content"),N("#all-user-content"),N("#comment-table")];
    table.forEach(function(tab){
        tab ? tab.style.display = "none" : "";
    });
    N("#comment-table").style.display="inline-block";
    // render comments 
}

function showPosts(node) {

    highlightSelected(node);
    table = [N("#all-post-content"),N("#all-user-content"),N("#comment-table")];
    table.forEach(function(tab){
        tab ? tab.style.display = "none" : "";
    });
    N("#all-post-content").style.display="inline-block";

    
}

function showUser(node) {

    highlightSelected(node);    
    table = [N("#all-post-content"),N("#all-user-content"),N("#comment-table")];
    table.forEach(function(tab){
        tab.style.display = "none";
    });
    N("#all-user-content") ? N("#all-user-content").style.display="block" : "";

}



function sort( node,by ) {
    let posts = Array.from(document.querySelectorAll(".post"));
    if( by == "title" ) {
        var order = node.getAttributeNode("data-sorted-bytitle").value;
        if( order == "no" || order == "asc") {
            node.setAttribute("data-sorted-bytitle","desc");
            node.innerText = "Title ▼";
            posts.sort( (a,b)=>{
                if( order == "no" || order == "asc"){
                    tmp = a;
                    a = b;
                    b = tmp;
                }
                return a.querySelector(".dashboard-post-title").innerText[0].charCodeAt(0) - b.querySelector(".dashboard-post-title").innerText[0].charCodeAt(0);
            });
        }
        else {            
            node.setAttribute("data-sorted-bytitle","asc");
            node.innerText = "Title ▲";
            posts.sort( (a,b)=>{
                return a.querySelector(".dashboard-post-title").innerText[0].charCodeAt(0) - b.querySelector(".dashboard-post-title").innerText[0].charCodeAt(0);
            });
        }
    }


    if( by == "views" ) {
        var order = node.getAttributeNode("data-sorted-byviews").value;
        if( order == "no" || order == "asc") {
            node.setAttribute("data-sorted-byviews","desc");
            node.innerText = "Views ▼";
            posts.sort( (a,b)=>{
                if( order == "no" || order == "asc"){
                    tmp = a;
                    a = b;
                    b = tmp;
                }
                return parseInt(a.querySelector(".dashboard-post-visit").innerText) - parseInt(b.querySelector(".dashboard-post-visit").innerText);
            });
        }
        else {            
            node.setAttribute("data-sorted-byviews","asc");
            node.innerText = "Views ▲";
            posts.sort( (a,b)=>{
                return parseInt(a.querySelector(".dashboard-post-visit").innerText) - parseInt(b.querySelector(".dashboard-post-visit").innerText);
            });
        }
    }


    if( by == "comments" ) {
        var order = node.getAttributeNode("data-sorted-bycomments").value;
        if( order == "no" || order == "asc") {
            node.setAttribute("data-sorted-bycomments","desc");
            node.innerText = "Comments ▼";
            posts.sort( (a,b)=>{
                if( order == "no" || order == "asc"){
                    tmp = a;
                    a = b;
                    b = tmp;
                }
                return parseInt(a.querySelector(".dashboard-post-comments").innerText) - parseInt(b.querySelector(".dashboard-post-comments").innerText);
            });
        }
        else {            
            node.setAttribute("data-sorted-bycomments","asc");
            node.innerText = "Comments ▲";
            posts.sort( (a,b)=>{
                return parseInt(a.querySelector(".dashboard-post-comments").innerText) - parseInt(b.querySelector(".dashboard-post-comments").innerText);
            });
        }
    }

    if( by == "date" ) {
        var order = node.getAttributeNode("data-sorted-bydate").value;
        if( order == "no" || order == "asc") {
            node.setAttribute("data-sorted-bydate","desc");
            node.innerText = "Published ▼";
            posts.sort( (a,b)=>{
                var sa = new Date(a.querySelector(".dashboard-post-publish-date").innerText).getTime();
                var sb = new Date(b.querySelector(".dashboard-post-publish-date").innerText).getTime();
                return  sb - sa;
            });
        }
        else {            
            node.setAttribute("data-sorted-bydate","asc");
            node.innerText = "Published ▲";
            posts.sort( (a,b)=>{                
                var sa = new Date(a.querySelector(".dashboard-post-publish-date").innerText).getTime();
                var sb = new Date(b.querySelector(".dashboard-post-publish-date").innerText).getTime();
                return  sa - sb
            });
        }
        console.log(posts);
    }


    let allpostlist = N("#allpostlist");
    allpostlist.innerHTML = "";
    posts.forEach( (post,index)=>{
        setTimeout( ()=>{
            allpostlist.appendChild(post);
        },100*index);
    });

}