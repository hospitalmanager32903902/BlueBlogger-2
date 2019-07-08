function showNotificationPane(node) {
    let notiPane = document.querySelector("#notification-pane");
    if( window.event.target == node ) { 
        if( notiPane.style.display == "" || notiPane.style.display == "none" ) {
            notiPane.style.display = "block";
        } else {
            notiPane.style.display = "none";
        }
    }
}