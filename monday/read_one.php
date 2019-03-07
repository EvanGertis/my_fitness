<?php
// required headers
header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Headers: access");
header("Access-Control-Allow-Methods: GET");
header("Access-Control-Allow-Credentials: true");
header("Content-Type: application/json");

//include database and object files.
include_once '../config/database.php';
include_once '../objects/monday.php';

// get database connection.
$database = new Database();
$db = $database->getConnection();

// prepare monday object.
$monday = new Monday($db);

//set ID property of record to read.
$monday->id = isset($_GET['id']) ? $_GET['id'] : die();

// read the details of monday to be edited.
$monday->readOne();

if($product->name!=null){
    //create array.
    $product_arr = array(
        "id" => $monday->id,
        "reps" => $monday->reps,
        "exercise" => $monday->exercise
    );

    // set response code - 200 OK.
    http_response_code(200);

    // make it json format.
    echo json_encode($monday_arr);
} else {

    // set response code - 404 Not found.
    http_response_code(404);

    //tell the user routine does not exist.
    echo json_encode(array("message"=> "Routine does not exist."));
}