<?php

//required headers.
header("Access-Control-Allow-Origin: *");
header("Content-Type: appliction/json; charset=UTF-8");


// include database and object files.
include '../config/database.php';
include '../objects/monday.php';

// instantiate database and product object.
$database = new Database();
$db = $database->getConnection();

// initialize the monday object.
$monday = new Monday($db);

// query products.
$stmt = $monday->read();
$num = $stmt->rowCount();

// check if more than 0 records are found.
if($num>0){

    // create products array.
    $monday_arr = array();
    $monday_arr["records"] = array();

    // retrieve our table contents.
    // fetch() is faster than fetchAll().
    while($row = $stmt->fetch(PDO::FETCH_ASSOC)){
        // extract row.

        $monday_item= array(
            "id"=>$row['id'],
            "reps"=>$row['reps'],
            "exercise"=> html_entity_decode($row['exercise'])
        );

        array_push($monday_arr["records"], $monday_item);
    }

    // set response code -200 OK
    http_response_code(200);

    // show monday data in jason format.
    echo json_encode($monday_arr);
} else {
    // set the response code to - 404 not found.
    http_response_code(404);

    // tell the user no routines found.
    echo json_encode(
        array("message"=> "No routines found.")
    );
}