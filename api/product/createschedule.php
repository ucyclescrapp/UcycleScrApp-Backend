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
$m_total_price = $_GET["m_tp"];
$m_total_weight = $_GET["m_tw"];
$m_username = $_GET["m_us"];
$m_pickup_location = $_GET["m_pl"];
$m_pickup_date = $_GET["m_pd"];
$m_pickup_time = $_GET["m_pt"];
$m_status = $_GET["m_st"];

$m_phone = $_GET["m_pho"];
$m_address = $_GET["m_add"];
$m_landmark = $_GET["m_lan"];
$m_ppm = $_GET["m_ppm"];

 
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
    $product->total_price = $m_total_price;
    $product->total_weight = $m_total_weight;
    $product->username = $m_username;
    $product->pickup_location = $m_pickup_location;
    $product->pickup_date = $m_pickup_date;
    $product->pickup_time = $m_pickup_time;
    $product->status = $m_status;

    $product->phone = $m_phone;
    $product->address = $m_address;
    $product->landmark = $m_landmark;
    $product->ppm = $m_ppm;
    
    // create the product
    if($product->PlaceOrderSchedule()){
 
        // set response code - 201 created
        http_response_code(201);
 
        // tell the user
        echo json_encode(array("message" => "Thank you. Your schedule request is currently being processed. We will contact you shortly."));
    }
 
    // if unable to create the product, tell the user
    else{
 
        // set response code - 503 service unavailable
        http_response_code(503);
 
        // tell the user
        echo json_encode(array("message" => "Unable to send schedule."));
    }
}
 
// tell the user data is incomplete
else{
 
    // set response code - 400 bad request
    http_response_code(400);
 
    // tell the user
    echo json_encode(array("message" => "Unable to send schedule. Data is incomplete."));
}
?>