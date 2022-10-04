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


$m_ui = $_GET["m_ui"];
$m_ue = $_GET["m_ue"];
$m_ph = $_GET["m_ph"];


if(true)
{
 
    $product->userid = $m_ui;
    $product->firstname = "";
    $product->surname = "";
    $product->username = $m_ue;
    $product->passhash = "";
    $product->deliveryaddress = "";
    $product->mobilephone = "";
    $product->registrationdate = "";

    
    // create the product
    if($product->RegisterUser()){
 
        // set response code - 201 created
        http_response_code(201);
 
        // tell the user
        echo json_encode(array("message" => "Thank you. Your registration was successful."));
    }
 
    // if unable to create the product, tell the user
    else{
 
        // set response code - 503 service unavailable
        http_response_code(503);
 
        // tell the user
        echo json_encode(array("message" => "Unable to register."));
    }
}
 
// tell the user data is incomplete
else{
 
    // set response code - 400 bad request
    http_response_code(400);
 
    // tell the user
    echo json_encode(array("message" => "Unable to register. Data is incomplete."));
}
?>