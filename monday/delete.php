<?php

//required headers.
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");
header("Access-Control-Allow-Methods: POST");
header("Accesss-Control-Max-Age: 3600");
header("Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Authorization, X-Requested-With");

// include database and object file.
include_once '../config/database.php';
include_once '../objects/monday.php';

// get database connection.
$database = new Database();
$db = $database->getConnection();

// perpare product object.
$monday = new Monday($db);

// get workout id.
$data = json_decode(file_get_contents("php://input"));

// get workout id.
$monday->id = $data->id;


// delete the product.
if($monday->delete()){
    http_response_code(200);

    //tell the user.
    echo json_encode(array("message"=> "routine was deleted"));
} else {

    //set response code - 503 service unavailable.
    http_response_code(503);
    
    // tell the user.
    echo json_encode(array("message"=>"unable to delete routine'"));
}