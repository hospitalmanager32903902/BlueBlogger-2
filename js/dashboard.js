function highlightSelected(node){
    node.classList.add("selected");
    node.parentElement.querySelectorAll("*").forEach( elem => {
        elem.classList.remove("selected");
    });    
    node.classList.add( "selected" );
} highlightSelected( N("#posts") );

function renderAllPost( data,count ){
    var post = 
        `<div class="post" data-postid="${data.post_id}">
                <span id="dashboard-post-number" class="dashboard-post-element">${count}</span>       
                <span id="dashboard-post-tumbnail" class="dashboard-post-element">
                    <img src=img/post_image/${data.post_thumbnail} width="100%" height="100%" />
                </span>
                <a href="post.php?post=${data.post_id}">
                    <span id="dashboard-post-title" class="dashboard-post-element">${data.post_title}</span>
                </a>
                <span id="dashboard-post-visit" class="dashboard-post-element">${data.post_visit_count}</span>
                <span id="dashboard-post-comments" class="dashboard-post-element">${data.post_comment_count}</span>
                
                <!-- delete post ---->
                <span id="dashboard-post-delete" class="dashboard-post-element"  onclick="alertPrompt(this.parentElement)">
                    <svg viewBox="0 0 24 24" id="ic_delete_24px" width="50%" height="50%"><path   d="M6 19c0 1.1.9 2 2 2h8c1.1 0 2-.9 2-2V7H6v12zM19 4h-3.5l-1-1h-5l-1 1H5v2h14V4z"></path></svg>
                </span>
                <!-- edit post ---->
                <span id="dashboard-post-edit" class="dashboard-post-element" onclick="window.location='editpost.php?postid=${data.post_id}'">
                    <svg viewBox="0 0 24 24" id="ic_edit_24px" width="50%" height="50%"><path d="M3 17.25V21h3.75L17.81 9.94l-3.75-3.75L3 17.25zM20.71 7.04a.996.996 0 0 0 0-1.41l-2.34-2.34a.996.996 0 0 0-1.41 0l-1.83 1.83 3.75 3.75 1.83-1.83z"></path></svg>
                </span>
                <span id="dashboard-post-draft" class="dashboard-post-element"  onclick="draft(this)">

                </span>
                <span id="dashboard-post-unpublish" class="dashboard-post-element" onclick="pub(this)">
                    UN<i>p</i>UBLISH     
                </span>
            </div>`;
    var allpostlist = N("#allpostlist");
    allpostlist.innerHTML += post;
}

//  fetches the posts from the database and retuens it
//  it does it in synchronusly method 
function getPostData(){    
    var ajaxReqquest = new XMLHttpRequest();
    ajaxReqquest.open("GET","getallpostlist.php",false);
    ajaxReqquest.send();    
    return ajaxReqquest.responseText;
}

// this the main function where the program starts
function main(){
    JSON.parse( getPostData() ).forEach(( data,count ) => {
        renderAllPost( data,count + 1 );
    });
}

// This function throws an prompt alert when any
// deletion button is clicked to to be deleted
function alertPrompt(node){
    // html code for the modal
    var modal = 
        `<div id="alertPromptModal" style="overflow:hidden;opacity:0;width:100%;height:100%;background: #000000a3;position: absolute;top: 0;left: 0px;z-index: 100;">
            <div id="modalContent" style=" transition-duration:0.2s; transition-timing-function:cubic-bezier(0, 0, 0, 2.79); transform:scale(.5); text-align: center;width: 515px;height: 200px;border-radius: 5px;position:relative;margin:200px auto;background: white;box-sizing: border-box;padding: 20px;opacity: 1;">
                <h3 style="margin: 1px 1px 55px 0px;"> Are you Sure You Want to Delete This post ?  </h3>
                <button onclick="deletePost(${node.getAttributeNode("data-postid").value})" style="font-family:verdana;font-size: 17px;color: white;border:0px;width: 48%;height:50px;background: dodgerblue;cursor: pointer;border-radius: 4px;"> Yes </button>
                <button onclick="deletePost()" style="font-family:verdana;font-size: 17px;color: white;border:0px;width: 48%;height:50px;background: dodgerblue;cursor: pointer;border-radius: 4px;"> Cancel </button>
            </div>
        </div>
        `;
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

// this function performs the deletion operation on being clicked on delete button the alertPromt()
// function is triggered which prompts the user for confirmation if he confirms then this deletePost()
// function triggered with post id as argument. then deletePost() deletes the post with the id of postid
function deletePost(postid){
    alertPromptModal.style.opacity = 0;
    alertPromptModal.style.transitionTimingFunction="linear";  
    setTimeout(() => {      
        N("#modalContent").style.transform="scale(.5)";  
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
    if( ajaxReqquest.responseText == "post deleted"){
        alert("Post Deleted");
    } else {
        alert(ajaxReqquest.responseText);
    }
}
// -----------------------------/deletePost()-------------------------------------

window.addEventListener("load",()=>{
    main();
});

// --------------- Functions to make our life a little easier ----------------------


function N(indentifier) {
    return document.querySelector(indentifier);
}