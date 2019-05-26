function highlightSelected(node){
    node.classList.add("selected");
    node.parentElement.querySelectorAll("*").forEach((elem,index,self)=>{
        elem.classList.remove("selected");
    });    
    node.classList.add("selected");
}

function renderAllPost(data,count){
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
                <span id="dashboard-post-delete" class="dashboard-post-element" onclick="alertPrompt(this.parentElement)" >
                    <svg viewBox="0 0 24 24" id="ic_delete_24px" width="50%" height="50%"><path d="M6 19c0 1.1.9 2 2 2h8c1.1 0 2-.9 2-2V7H6v12zM19 4h-3.5l-1-1h-5l-1 1H5v2h14V4z"></path></svg>
                </span>
                <!-- edit post ---->
                <span id="dashboard-post-edit" class="dashboard-post-element">
                    <svg viewBox="0 0 24 24" id="ic_edit_24px" width="50%" height="50%"><path d="M3 17.25V21h3.75L17.81 9.94l-3.75-3.75L3 17.25zM20.71 7.04a.996.996 0 0 0 0-1.41l-2.34-2.34a.996.996 0 0 0-1.41 0l-1.83 1.83 3.75 3.75 1.83-1.83z"></path></svg>
                </span>
                <span id="dashboard-post-draft" class="dashboard-post-element">

                </span>
                <span id="dashboard-post-unpublish" class="dashboard-post-element"></span>
            </div>`;
    var allpostlist = document.querySelector("#allpostlist");
    allpostlist.innerHTML += post;
}

function getPostData(){
    
    var ajaxReqquest = new XMLHttpRequest();
    ajaxReqquest.open("GET","getallpostlist.php",false);
    ajaxReqquest.send();
    
    return ajaxReqquest.responseText;
}

function main(){
    var data = getPostData();
    data = JSON.parse(data);
    data.forEach((data,count)=>{
        renderAllPost(data,count+1);
    });
}

function alertPrompt(node){
    var modal = 
        `<div id="alertPromptModal" style="overflow:hidden;transform:scale(.5);opacity:0;transition-duration:0.3s; transition-timing-function:cubic-bezier(0, 0, 0, 2.79);width:100%;height:100%;background: #000000a3;position: absolute;top: 0;left: 0px;z-index: 100;">
            <div style="text-align: center;width: 515px;height: 200px;border-radius: 5px;transform:translate(-50%,-50%);position:relative;left:50%;top:50%;background: white;box-sizing: border-box;padding: 20px;opacity: 1;">
                <h3 style="margin: 1px 1px 55px 0px;"> Are you Sure You Want to Delete This post ?  </h3>
                <button onclick="deletePost(${node.getAttributeNode("data-postid").value})" style="font-family:verdana;font-size: 17px;color: white;border:0px;width: 48%;height:50px;background: dodgerblue;cursor: pointer;border-radius: 4px;"> Yes </button>
                <button onclick="deletePost()" style="font-family:verdana;font-size: 17px;color: white;border:0px;width: 48%;height:50px;background: dodgerblue;cursor: pointer;border-radius: 4px;"> Cancel </button>
            </div>
        </div>
        `;
    document.body.innerHTML += modal;
    
    setTimeout(() => {
        alertPromptModal = document.querySelector("#alertPromptModal");
        alertPromptModal.style.opacity = 1;   
        alertPromptModal.style.transform="scale(1)";   
        alertPromptModal.style.transitionTimingFunction="cubic-bezier(0, 0, 0, 2.79)";     
    }, 1);
}

function deletePost(postid){
    alertPromptModal.style.opacity = 0;
    alertPromptModal.style.transitionTimingFunction="linear";  
    setTimeout(() => {      
        alertPromptModal.style.transform="scale(.7)"; 
        alertPromptModal.remove();
    }, 300);
    if(postid){
        // deletion operation of the post
        console.log("Delete the post of ID " + postid);
    }
}


window.addEventListener("load",()=>{
    main();
})