<?php
// required headers
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");
 


// get database connection
include_once '../config/database.php';
include_once '../objects/product.php';
 
$database = new Database();
$db = $database->getConnection(); 
$product = new Product($db);


$m_orders = $_GET["m_or"];
$m_totalprice = $_GET["m_pr"];
$m_username = $_GET["m_us"];

 



// get posted data
//$data = json_decode(file_get_contents("php://input"));
 
// make sure data is not empty
if(true
//    !empty($data->name) &&
//    !empty($data->price) &&
//    !empty($data->description) &&
//    !empty($data->category_id)
)
{
 
    // set product property values
    //$product->name = $data->name;
    //$product->price = $data->price;
    //$product->description = $data->description;
    //$product->category_id = $data->category_id;
    //$product->created = date('Y-m-d H:i:s');

    $product->orders = $m_orders;
    $product->totalprice = $m_totalprice;
    $product->username = $m_username;

    
    // create the product
    if($product->PlaceOrder()){
 
        // set response code - 201 created
        http_response_code(201);
 
        // tell the user
        echo json_encode(array("message" => "Thank you. Your request is currently being processed."));
    }
 
    // if unable to create the product, tell the user
    else{
 
        // set response code - 503 service unavailable
        http_response_code(503);
 
        // tell the user
        echo json_encode(array("message" => "Unable to send order."));
    }
}
 
// tell the user data is incomplete
else{
 
    // set response code - 400 bad request
    http_response_code(400);
 
    // tell the user
    echo json_encode(array("message" => "Unable to send orders. Data is incomplete."));
}
?>