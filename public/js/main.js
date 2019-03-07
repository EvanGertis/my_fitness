// initialize variables
var httprequest;
var monday = document.getElementById("monday");

monday.addEventListener("click", showRoutines);

function showRoutines(){
    httprequest = new XMLHttpRequest();

    // gaurd.
    if(!httpRequest){
        alert('No xmlhttp instance avail.');
        return false;
    }

    // set callback handler.
    httpRequest.onreadystatechange = alertContents;
    httpRequest.open('GET', 'http://localhost/my_fitness/monday/read.php');
    httpRequest.setRequestHeader('Content-type', 'application/json');
    httpRequest.send(content);
}

function handleRequest(){
    if(httpRequest.readyState === XMLHttpRequest.DONE){
        if(httpRequest.status === 200){
            alert(httpRequest.responseText);
        } else {
            alert("Error in the request");
        }
    }
}