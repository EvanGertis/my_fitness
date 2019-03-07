// initialize variables
var httpRequest = null;
var monday = document.getElementById("monday");
var content;


showRoutines()
appendAdd();

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
    var row = document.createElement('p');
    row.innerHTML = reps + " : " + exercise;
    row.setAttribute('id', id);
    var deleteButton = document.createElement('button');
    deleteButton.innerHTML = "delete";
    deleteButton.addEventListener("click", deleteRow);

    var editButton = document.createElement('a');
    editButton.setAttribute("href", "./edit.php")
    editButton.innerHTML = "edit";
    editButton.addEventListener("click", editRow);

    row.appendChild(editButton);
    row.appendChild(deleteButton);
    container.appendChild(row);

    monday.parentNode.appendChild(container);
}

function appendAdd(){
    var reps = document.createElement('input');
    var exercise = document.createElement('input');
    var add = document.createElement('input');
    var addForm = document.createElement('div');

    reps.setAttribute('type', 'text');
    reps.setAttribute("name", "reps");
    exercise.setAttribute('type', 'text');
    exercise.setAttribute("name", "exercise");
    add.setAttribute('type', 'submit');
    add.addEventListener("click", createNew);
    add.value = "add";

    addForm.appendChild(reps);
    addForm.appendChild(exercise);
    addForm.appendChild(add);

    monday.parentNode.parentNode.appendChild(addForm);
}

function deleteRow(e){
    httpRequest = new XMLHttpRequest();

    // gaurd.
    if(!httpRequest){
        alert('No xmlhttp instance avail.');
        return false;
    }

    // set callback handler.
    httpRequest.onreadystatechange = deleteResponse;
    httpRequest.open('POST', 'http://localhost/my_fitness/monday/delete.php');
    httpRequest.setRequestHeader('Content-type', 'application/raw');
    httpRequest.send(`{"id":"${e.target.parentNode.id}"}`);
}

function deleteResponse(){
    if(httpRequest.readyState === XMLHttpRequest.DONE){
        if(httpRequest.status === 200){
            location.reload();
        } else {
            alert("Error in the request");
        }
    }
}

function createNew(e){
    var reps = e.target.parentNode.children[0].value;

    var exercise = e.target.parentNode.children[1].value;

    httpRequest = new XMLHttpRequest();

    // gaurd.
    if(!httpRequest){
        alert('No xmlhttp instance avail.');
        return false;
    }

    // set callback handler
    httpRequest.open('POST', 'http://localhost/my_fitness/monday/create.php');
    httpRequest.setRequestHeader('Content-type', 'application/raw');
    httpRequest.send(`{"reps":"${reps}","exercise":"${exercise}"}`);
}

function editRow(e){
    console.log(e.target.parentNode.id);
}