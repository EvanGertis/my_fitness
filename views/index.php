
<?php include("./partials/header.php")?>

    <div class="card" style="width: 18rem;">
    <div class="card-header">
        My workouts
    </div>
    <ul class="list-group list-group-flush">
        <li id = "list" class="list-group-item"></li>
    </ul>
    </div>

<?php include("./partials/footer.php")?>
<script>
updateUi();

function updateUi(){
    var xhttp = new XMLHttpRequest();
    var list = document.getElementById("list");
    // cycle through data and add it to the list.
    xhttp.onreadystatechange = function () {
        list.innerHTML = "Monday";
        if(this.readyState == 4 && this.status ==200){
    
            var res = JSON.parse(this.response);
            res.records.forEach(e => {
                //generate main list.
                var li = document.createElement("li")
                li.setAttribute("id", e.id)

                // ui content begin.
                var reps = document.createElement("p");
                reps.setAttribute("contentEditable", "true");
                reps.innerHTML = `${e.reps}`;
                reps.addEventListener('keydown', edit)
                
                var exercise = document.createElement("p");
                exercise.setAttribute("contentEditable", "true");
                exercise.innerHTML = `${e.exercise}`;
                exercise.addEventListener('keydown', edit)
                // ui content end.

                //generate ui button.
                var deleteButton = document.createElement('button');
                deleteButton.innerHTML = "delete";
                deleteButton.addEventListener("click", deleteRoutine);
                
                //append ui content.
                li.appendChild(reps);
                li.appendChild(exercise);

                //append ui children.
                li.appendChild(deleteButton);

                list.appendChild(li);
            })
        }
        var addNew = document.createElement("li");
        addNew.setAttribute("id", "add");

        var newReps = document.createElement("input");
        newReps.setAttribute("placeholder", "Enter new reps");
        newReps.setAttribute("id", "new_reps");

        var newExercise = document.createElement("input");
        newExercise.setAttribute("placeholder", "Enter a new exercise");
        newExercise.setAttribute("id", "new_exercise");

        var addNewButton = document.createElement("button");
        addNewButton.innerHTML = "add";
        addNewButton.addEventListener("click", addNewRecord);

        addNew.appendChild(newReps);
        addNew.appendChild(newExercise);
        addNew.appendChild(addNewButton);
        list.appendChild(addNew);
    };
    xhttp.open("GET", "../monday/read.php" );
    xhttp.send();

}


function deleteRoutine(e){
    var rowId = e.target.parentNode.id;
    var xhttp = new XMLHttpRequest();
    
    // regenerate ui.
    xhttp.onreadystatechange = updateUi;
    var params = `{"id":"${rowId}"}`;
    xhttp.open("POST", "../monday/delete.php")
    xhttp.setRequestHeader('Content-type', 'application/raw');
    xhttp.send(params);
}

function edit(e){
    var esc = event.which == 27;

    var repsEdit = e.target.parentNode.children[0];
    var exerciseEdit = e.target.parentNode.children[1];
    
    var reps = repsEdit.innerHTML
    var exercise = exerciseEdit.innerHTML

    var rowId = e.target.parentNode.id;
    var esc = event.which == 27,
        nl = event.which == 13,
        el = event.target,
        input = el.nodeName != 'INPUT' && el.nodeName != 'TEXTAREA',
        data = {};
    

    if (input) {
        if (esc) {
        // restore state
            document.execCommand('undo');
            el.blur();
            } else if (nl) {
                var xhttp = new XMLHttpRequest();
                
                // regenerate ui.
                xhttp.onreadystatechange = updateUi;
                var params = `{"id":"${rowId}", "reps":"${reps}", "exercise":"${exercise}"}`;
                xhttp.open("POST", "../monday/update.php")
                xhttp.setRequestHeader('Content-type', 'application/raw');
                xhttp.send(params);

                el.blur();
                event.preventDefault();
            }
        }


    

}

//inserts a new record into the table.
function addNewRecord(e){
    var reps = e.target.parentNode.children[0].value;
    var exercise = e.target.parentNode.children[1].value;

    var xhttp = new XMLHttpRequest();
    xhttp.onreadystatechange = updateUi;
    var params = `{"reps":"${reps}", "exercise":"${exercise}"}`;
    xhttp.open("POST", "../monday/create.php");
    xhttp.setRequestHeader('Content-type', 'application/raw');
    xhttp.send(params);
}

</script>