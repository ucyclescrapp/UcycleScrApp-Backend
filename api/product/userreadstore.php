<?php
// required headers
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");
 
// database connection will be here
// include database and object files
include_once '../config/database.php';
include_once '../objects/product.php';

$m_username = $_GET["m_us"];
 
// instantiate database and product object
$database = new Database();
$db = $database->getConnection();
 
// initialize object
$product = new Product($db);
 
// read products will be here
// query products
$stmt = $product->readUserStore($m_username);
$num = $stmt->rowCount();
 


// create the product
    if($num>0) {
        http_response_code(201);
        echo json_encode(array("message" => "Found"));
    }
    else {
        http_response_code(201);
        echo json_encode(array("message" => "NotFound"));
    }

 

?>