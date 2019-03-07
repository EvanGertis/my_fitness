<?php

//required headers.
header("Access-Control-Allow-Origin: *");
header("Content-Type: appliction/json; charset=UTF-8");


// include database and object files.
include '../config/database.php';
include '../objects/product.php';

// instantiate database and product object.
$database = new Database();
$db = $database->getConnection();

// initialize the product object.
$product = new Product($db);

// query products.
$stmt = $product->read();
$num = $stmt->rowCount();

// check if more than 0 records are found.
if($num>0){

    // create products array.
    $products_arr = array();
    $products_arr["records"] = array();

    // retrieve our table contents.
    // fetch() is faster than fetchAll().
    while($row = $stmt->fetch(PDO::FETCH_ASSOC)){
        // extract row.

        $product_item= array(
            "id"=>$row['id'],
            "name"=>$row['name'],
            "description"=> html_entity_decode($row['description']),
            "price"=> $row['price'],
            "category_id"=> $row['category_id'],
            "category_name"=> $row['category_name']
        );

        array_push($products_arr["records"], $product_item);
    }

    // set response code -200 OK
    http_response_code(200);

    // show products data in jason format.
    echo json_encode($products_arr);
} else {
    // set the response code to - 404 not found.
    http_response_code(404);

    // tell the user no products found.
    echo json_encode(
        array("message"=> "No products found.")
    );
}