
<?php include("./partials/header.php")?>

    <div class="card" style="width: 18rem;">
    <div class="card-header">
        My workouts
    </div>
    <ul class="list-group list-group-flush">
        <li id = "list" class="list-group-item">Monday</li>
    </ul>
    </div>

<?php include("./partials/footer.php")?>
<script>

(function create() {
    var xhttp = new XMLHttpRequest();
    var list = document.getElementById("list");

    // cycle through data and add it to the list.
    xhttp.onreadystatechange = function () {
        if(this.readyState == 4 && this.status ==200){
            var res = JSON.parse(this.response);
            res.records.forEach(e => {

                //generate main list.
                var li = document.createElement("li")
                li.setAttribute("id", e.id)
                li.innerHTML = `${e.reps} ${e.exercise}`;

                //generate ui buttons.
                var editButton = document.createElement('button');
                editButton.innerHTML = "edit";
                editButton.addEventListener("click", editRoutine);
                
                var deleteButton = document.createElement('button');
                deleteButton.innerHTML = "delete";
                deleteButton.addEventListener("click", deleteRoutine);
                
                //append ui children.
                li.appendChild(editButton);
                li.appendChild(deleteButton);

                list.appendChild(li);
            })
        }
    };
    xhttp.open("GET", "../monday/read.php" );
    xhttp.send();
})();

function updateUi(){
    var xhttp = new XMLHttpRequest();
    var list = document.getElementById("list");
    
    // cycle through data and add it to the list.
    xhttp.onreadystatechange = function () {
        if(this.readyState == 4 && this.status ==200){
            list.innerHTML = "Monday";
            var res = JSON.parse(this.response);
            res.records.forEach(e => {
                
                //generate main list.
                var li = document.createElement("li")
                li.setAttribute("id", e.id)
                li.innerHTML = `${e.reps} ${e.exercise}`;

                //generate ui buttons.
                var editButton = document.createElement('button');
                editButton.innerHTML = "edit";
                editButton.addEventListener("click", editRoutine);
                
                var deleteButton = document.createElement('button');
                deleteButton.innerHTML = "delete";
                deleteButton.addEventListener("click", deleteRoutine);
                
                //append ui children.
                li.appendChild(editButton);
                li.appendChild(deleteButton);
                
                list.appendChild(li);
            })
        }
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

function editRoutine(e){
    var rowId = e.target.parentNode.id;
}

</script>