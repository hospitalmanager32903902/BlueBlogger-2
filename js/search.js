function showMore(node) {
    if( node.parentElement.style.height == "380px" ){
        node.parentElement.style.height = "150px";
        node.innerText = "Show More ↓↓↓ ";
    } else {        
        node.parentElement.style.height = "380px";
        node.innerText = "Show Less ↑↑↑ ";
    }
}

function mark(params) {    
    let searchKey = window.location.search.split("=")[1].toLocaleLowerCase();
    Array.from(document.querySelectorAll(".matched-content-item")).forEach(function(elem){
        elem.querySelector(".post-title").innerHTML = elem.querySelector(".post-title").innerText.split(" ").map(function(elem){
            if( elem.toLocaleLowerCase() == searchKey || elem.toLocaleLowerCase().includes(searchKey) ){
                if( elem.toLocaleLowerCase() == searchKey ){
                    return `<span style='background:yellow;'>${elem}</span>`;
                } else {
                    return markHelper(elem,searchKey);
                }
            }
            else
                return elem;
        
        }).join(" ");
        
        elem.querySelector(".post-content").innerHTML = elem.querySelector(".post-content").innerText.split(" ").map(function(word){
            if( word.toLocaleLowerCase() == searchKey || word.toLocaleLowerCase().includes(searchKey) ){
                if( word.toLocaleLowerCase() == searchKey ){
                        return `<span style='background:yellow;'>${word}</span>`;
                    } else {
                        return markHelper(word,searchKey);
                    }
                }
                else {
                    return word;
                }    
        }).join(" ");

    });

    function markHelper(text, word){
        var acc = [];
        var arr = text.split(" ");
        arr.forEach( (elem) => {
            if(elem.toLowerCase().includes(word)){
        // 		acc.push(`<span style='background:yellow'>${elem}</span>`);
                var s = elem.toLowerCase().indexOf(word);
                var e = word.length;
                var butter = elem.substring(0,s) + `<span style='background:#ffc1079e;'>${word}</span>` + elem.substring(s+e);
                acc.push(butter);
            } else {
                acc.push(elem);
            }
        });
        return acc.join(" ");
    }
}

function enterSearch(e){
    if (e.key.toLowerCase() == "enter") {
        search( N("#searchButton") );
    }
}

function search(searchKey) {
    window.location = "search.php?q=" + searchKey.previousElementSibling.value.trim();
}

window.onload = function(){
    mark();
}