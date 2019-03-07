<?php
//required headers
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");
header("Access-Control-Allow-Mehtods: POST");
header("Access-Control-Max-Age: 3600");
header("Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Authorization, X-Requested-With");

// include database and object files.
include_once '../config/database.php';
include_once '../objects/product.php';

// get database connection.
$database = new Database();
$db = $database->getConnection();

// prepare product object.
$product = new Product($db);

// get id of product to be edited.
$data = json_decode(file_get_contents("php://input"));

// set ID property of product to be edited.
$product->id = $data->id;

// set product property values.
$product->name = $data->name;
$product->price = $data->price;
$product->description = $data->description;
$product->category_id = $data->category_id;

if($product->update()){
    http_response_code(200);

    echo json_encode(array("message"=> "Product updated."));
} else {
    //set response code - 503 service unavailable.
    http_response_code(503);

    // tell the user.
    echo json_encode(array("message"=> "unable to update product"));
}