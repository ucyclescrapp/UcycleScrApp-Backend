<?php
// required headers
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");
 
// database connection will be here
// include database and object files
include_once '../config/database.php';
include_once '../objects/product.php';

$history_user = $_GET["m_hu"];
 
// instantiate database and product object
$database = new Database();
$db = $database->getConnection();
 
// initialize object
$product = new Product($db);
 
// read products will be here
// query products
$stmt = $product->readHistory($history_user);
$num = $stmt->rowCount();
 
// check if more than 0 record found
//if($num>0)
{
 
    // products array
    $products_arr=array();
    $products_arr["RECORDS"]=array();
 
    // retrieve our table contents
    // fetch() is faster than fetchAll()
    // http://stackoverflow.com/questions/2770630/pdofetchall-vs-pdofetch-in-a-loop
    while ($row = $stmt->fetch(PDO::FETCH_ASSOC)){
        // extract row
        // this will make $row['name'] to
        // just $name only
        extract($row);
 
        $product_item=array(
            "#id" => $id,
            "#orders" => $orders,
            "#total_price" => $total_price,
            "#total_weight" => $total_weight,
            "#username" => $username,
            "#pickup_location" => $pickup_location,
            "#pickup_date" => $pickup_date,
            "#pickup_time" => $pickup_time,
            "#status" => $status
        );
 
        array_push($products_arr["RECORDS"], $product_item);
    }
 
    // set response code - 200 OK
    http_response_code(200);
 
    // show products data in json format
    echo json_encode($products_arr);
}
 
// no products found will be here
//else{
 
    // set response code - 404 Not found
//    http_response_code(404);
 
    // tell the user no products found
//    echo json_encode(
//        array("message" => "No products found.")
//    );
//}

?>