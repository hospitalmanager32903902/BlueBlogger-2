function showNotificationPane(node) {
    let notiPane = node.querySelector("#notification-pane");
    if( window.event.target != notiPane ) { 
        if( notiPane.style.display == "" || notiPane.style.display == "none" ) {
            notiPane.style.display = "block";
        } else {
            notiPane.style.display = "none";
        }
    }
}