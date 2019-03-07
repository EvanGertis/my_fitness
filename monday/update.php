<?php
//required headers
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");
header("Access-Control-Allow-Mehtods: POST");
header("Access-Control-Max-Age: 3600");
header("Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Authorization, X-Requested-With");

// include database and object files.
include_once '../config/database.php';
include_once '../objects/monday.php';

// get database connection.
$database = new Database();
$db = $database->getConnection();

// prepare monday object.
$monday = new Monday($db);

// get id of monday to be edited.
$data = json_decode(file_get_contents("php://input"));

// set ID property of monday to be edited.
$monday->id = $data->id;

// set monday property values.
$monday->reps = $data->reps;
$monday->exercise = $data->exercise;

if($monday->update()){
    http_response_code(200);

    echo json_encode(array("message"=> "Routine updated."));
} else {
    //set response code - 503 service unavailable.
    http_response_code(503);

    // tell the user.
    echo json_encode(array("message"=> "unable to update routine"));
}