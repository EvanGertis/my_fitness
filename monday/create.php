<?php

//required headers.
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");
header("Access-Control-Allow-Methods: POST");
header("Access-Control-Max-Age: 3600");
header("Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Authorization, X-Requested-With");

// get database connection.
include_once '../config/database.php';

// instantiate product object.
include_once '../objects/monday.php';

$database = new Database();
$db = $database->getConnection();

$monday = new Monday($db);

// get posted data.
$data = json_decode(file_get_contents("php://input"));
// make sure data is not empty.
if(
    !empty($data->reps) &&
    !empty($data->exercise)
){
    // set monday property values.
    $monday->reps = $data->reps;
    $monday->exercise = $data->exercise;
    $monday->created = date('Y-m-d H:i:s');
    
    //create the product.
    if($monday->create()){

        //set response code -201 created
        http_response_code(201);

        //tell the user.
        echo json_encode(array("message"=> "routine was created."));
    } else {
        //if unable to create the routine, tell the user

        //set response code - 503 service unavailable.
        http_response_code(503);

        //tell the user.
        echo json_encode(array("message"=> "unable to create routine."));
    }
} else {
    // tell the user data is incomplete.
    http_response_code(400);

    //tell the user.
    echo json_encode(array("message"=> "Unable to create the routine"));
}