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
$stmt = $product->checkRegMap($m_username);
$num = $stmt->rowCount();
 
// check if more than 0 record found
if($num == 1)
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
            "#username" => $username,
            "#allocated" => $allocated,
            "#walladd" => $walladd,
            "#prikeyhash" => $prikeyhash,
            "#firstname" => $firstname,
            "#surname" => $surname,
            "#mobilephone" => $mobilephone,
            "#allocationdate" => $allocationdate
        );
 
        array_push($products_arr["RECORDS"], $product_item);
    }
    
    http_response_code(200);
    echo json_encode($products_arr);
}
 
else{
 
    //return as null for not found IMPORTANT
    // set response code - 404 Not found
    //http_response_code(404);
 
    // tell the user no products found
    //echo json_encode(
    //    array("message" => "No user found.")
    //);
}

?>