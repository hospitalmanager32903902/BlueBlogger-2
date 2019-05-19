function highlightSelected(node){
    node.classList.add("selected");
    node.parentElement.querySelectorAll("*").forEach((elem,index,self)=>{
        elem.classList.remove("selected");
    });    
    node.classList.add("selected");
}