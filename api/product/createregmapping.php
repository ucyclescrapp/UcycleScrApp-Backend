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


$m_username = $_GET["m_us"];

$stmt = $product->checkRegMap($m_username);
$num = $stmt->rowCount();

if($num > 0){
    http_response_code(201);
 
        // tell the user
        echo json_encode(array("message" => "Account already created."));
}
else
{
if(true)
{

    
    $product->username = $m_username;

    // create the product
    if($product->RegisterMapUser($m_username)){
 
        // set response code - 201 created
        http_response_code(201);
 
        // tell the user
        echo json_encode(array("message" => "Thank you. Your account is being provisioned."));
    }
    else{
 
        // set response code - 503 service unavailable
        http_response_code(503);
 
        // tell the user
        echo json_encode(array("message" => "Unable to provision account."));
    }

}
 
// tell the user data is incomplete
else{
 
    // set response code - 400 bad request
    http_response_code(400);
 
    // tell the user
    echo json_encode(array("message" => "Unable to register. Data is incomplete."));
}
}
?>