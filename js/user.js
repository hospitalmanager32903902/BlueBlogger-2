

// window.addEventListener("load",()=>{
//     var body = document.querySelector("body");
//     body.style.opacity ="1";
//     body.style.transform ="skew(0deg)";
//     body.style.left ="0%";
// });

function showedit(that) {
    var edit_tool = that.querySelector("#edit-detail");
    edit_tool.style.display = "block";
}

function hideedit(that) {
    var edit_tool = that.querySelector("#edit-detail");
    edit_tool.style.display = "none";
}

function edit_user_detail_field(node) {
    node.style.display = "none";
    node.parentElement.onmouseover = null;
    node.parentElement.onmouseout = null;
    var parent = node.parentElement;
    var existing = node.parentElement.querySelector(".value").innerText;
    var inputter = 
                    `<input type="text" id="input_user_detail" value="${existing}">
                    <span id="input_user_detail_save" onclick="update_user_detail_field(this)">Update</span>`;
    node.parentElement.querySelector(".value").innerHTML = inputter;
    
    // parent.innerHTML = existing;
}

function update_user_detail_field(node) {
    document.querySelector("#edit-detail").style.display = "none";
    var parent = node.parentElement;
    parent.parentElement.addEventListener("mouseover",()=>{
        showedit(parent.parentElement);
    });
    parent.parentElement.addEventListener("mouseout",()=>{
        hideedit(parent.parentElement);
    });
    parent.innerHTML = node.previousElementSibling.value;
}