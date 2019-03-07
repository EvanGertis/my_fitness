<?php
// required headers.
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");

//include database and object files.
include_once '../config/core.php';
include_once '../shared/utilities.php';
include_once '../config/database.php';
include_once '../objects/product.php';

//utilities
$utilities = new Utilities();

//instantiate database and product object.
$datatbase = new Database();
$db = $datatbase->getConnection();

//initialize object.
$product = new Product($db);

//query products.
$stmt = $product->readPaging($from_record_num, $records_per_page);
$num = $stmt->rowCount();

//check if more than 0 records are found.
if($num > 0){
    //products array.
    $products_arr = array();
    $products_arr["records"] = array();
    $products_arr["paging"] = array();

    //retrieve our table contents.
    //fetch() is faster than fetchAll().
    while($row = $stmt->fetch(PDO::FETCH_ASSOC)){
        //extract row.
        extract($row);

        $product_item = array(
            "id" => $id,
            "name" => $name,
            "description" => html_entity_decode($description),
            "price" => $price,
            "category_id" => $category_id,
            "category_name" => $category_name
        );

        array_push($products_arr["records"], $product_item);
    }

    //include paging.
    $total_rows = $product->count();
    $page_url = "{$home_url}product/read_paging.php?";
    $paging = $utilities->getPaging($page, $total_rows, $records_per_page, $page_url);

    // set response code - 200 OK.
    http_response_code(200);

    //make it json format.
    echo json_encode($products_arr);

} else {
    //set response code - 404 not found
    http_response_code(404);

    //tell the user products does not exist.
    echo json_encode(
        array("message" => "No proucts found.")
    );
}