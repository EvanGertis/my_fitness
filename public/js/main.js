// initialize variables
var httpRequest = null;
var monday = document.getElementById("monday");
var content;

monday.addEventListener("click", showRoutines);

function showRoutines(){
    httpRequest = new XMLHttpRequest();

    // gaurd.
    if(!httpRequest){
        alert('No xmlhttp instance avail.');
        return false;
    }

    // set callback handler.
    httpRequest.onreadystatechange = handleRequest;
    httpRequest.open('GET', 'http://localhost/my_fitness/monday/read.php');
    httpRequest.setRequestHeader('Content-type', 'application/json');
    httpRequest.send();
}

function handleRequest(){
    if(httpRequest.readyState === XMLHttpRequest.DONE){
        if(httpRequest.status === 200){
            content = JSON.parse(httpRequest.response);
            render(content);
        } else {
            alert("Error in the request");
        }
    }
}

function render(content){
    content.records.forEach(element => {
        var id = element.id;
        var reps = element.reps;
        var exercise = element.exercise;
        appendRoutine(id, reps, exercise);
    });
}

function appendRoutine(id, reps, exercise){
    var container = document.createElement('div');
    container.setAttribute('id', id);
    var row = document.createElement('p');
    row.innerHTML = reps + " : " + exercise;
    container.appendChild(row);
    monday.parentNode.appendChild(container);
}