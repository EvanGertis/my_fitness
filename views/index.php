
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
    xhttp.onreadystatechange = function () {
        if(this.readyState == 4 && this.status ==200){
            document.getElementById("list").innerHTML = this.responseText;
        }
    };
    xhttp.open("GET", "../monday/read.php" );
    xhttp.send();
})();
</script>