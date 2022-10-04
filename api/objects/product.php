<?php
class Product{
 
    // database connection and table name
    private $conn;
    private $table_name = "var_table"; 
    private $schedule_table_name = "sch_table";  

    private $registration_table_name = "reg_table";  

    private $type_table_name = "typ_table";

    private $notification_table_name = "not_table";

    private $store_table_name = "sto_table";

    private $barter_schedule_table_name = "bar_table";
    


    //schedule
    public $orders;
    public $total_price;
    public $total_weight;
    public $username;
    public $pickup_location;
    public $pickup_date;
    public $pickup_time;
    public $status;
    public $phone;
    public $address;
    public $landmark;
    public $ppm;

    //registration
    //Id` INT NOT NULL AUTO_INCREMENT,
    //public $userid;
    //public $firstname;
    //public $surname;
    //public $username;
    //public $passhash;
    //public $deliveryaddress;
    //public $mobilephone;
    //public $registrationdate; 

    public $notification;
    
    

    //public $itemname;
    //public $itempicture;

 
    // constructor with $db as database connection
    public function __construct($db){
        $this->conn = $db;
    }
    
    #1// read products
function read(){
 
    // select all query
    $query = "SELECT
                p.id,
                p.itemcode,
                p.itemname,
                p.description,
                p.price,
                p.itempicture,
                p.registrationdate,
                p.category,
                p.color,
                p.quantity,
                p.weight,
                p.plastictype
            FROM
                " . $this->table_name . " p
                
            ORDER BY
                p.id ASC";
    
    // prepare query statement
    $stmt = $this->conn->prepare($query);
 
    // execute query
    $stmt->execute();
 
    return $stmt;
}

 #2// place schedule order
function PlaceOrderSchedule(){
    
    // query to insert record
    $query = "INSERT INTO
                " . $this->schedule_table_name . "
            SET
                orders=:orders, 
                total_price=:total_price, 
                total_weight=:total_weight,                
                username=:username, 
                pickup_location=:pickup_location, 
                pickup_date=:pickup_date,
                pickup_time=:pickup_time, 
                status=:status,
                phone=:phone,
                address=:address,
                landmark=:landmark,
                ppm=:ppm"
                ;
 
    // prepare query
    $stmt = $this->conn->prepare($query);
 

    
    // bind values
    $stmt->bindParam(":orders", $this->orders);
    $stmt->bindParam(":total_price", $this->total_price);
    $stmt->bindParam(":total_weight", $this->total_weight);
    $stmt->bindParam(":username", $this->username);
    $stmt->bindParam(":pickup_location", $this->pickup_location);
    $stmt->bindParam(":pickup_date", $this->pickup_date);
    $stmt->bindParam(":pickup_time", $this->pickup_time);
    $stmt->bindParam(":status", $this->status);

    $stmt->bindParam(":phone", $this->phone);
    $stmt->bindParam(":address", $this->address);
    $stmt->bindParam(":landmark", $this->landmark);
    $stmt->bindParam(":ppm", $this->ppm);

    // execute query
    if($stmt->execute()){
        return true;
    }
 
    return false;
}

#3// check registration map
function checkRegMap($_username){
 
    // select all query
    $query = "SELECT
                p.id,
                p.username,
                p.allocated,
                p.walladd,
                p.prikeyhash,
                p.firstname,
                p.surname,
                p.mobilephone,
                p.allocationdate
            FROM
                " . $this->registration_table_name . " p 
            WHERE p.username='".$_username."'
            ORDER BY
                p.id ASC";
    
    // prepare query statement
    $stmt = $this->conn->prepare($query);
 
    // execute query
    $stmt->execute();
 
    return $stmt;
}

#4// read products type
function readType(){
 
    // select all query
    $query = "SELECT
                p.id,
                p.plasticcode,
                p.plasticname,
                p.description,
                p.price,
                p.plasticpicture,
                p.registrationdate
            FROM
                " . $this->type_table_name . " p
                
            ORDER BY
                p.id ASC";
    
    // prepare query statement
    $stmt = $this->conn->prepare($query);
 
    // execute query
    $stmt->execute();
 
    return $stmt;
}


#5// read history type
function readHistory($history_username){
 
    // select all query
    $query = "SELECT
                p.id,
                p.orders,
                p.total_price,
                p.total_weight,
                p.username,
                p.pickup_location,
                p.pickup_date,
                p.pickup_time,
                p.status
            FROM
                " . $this->schedule_table_name . " p 
            WHERE p.username='".$history_username."'
            ORDER BY
                p.id ASC";
    
    // prepare query statement
    $stmt = $this->conn->prepare($query);
 
    // execute query
    $stmt->execute();
 
    return $stmt;
}


#6// read notification
function readNotes(){
 
    // select all query
    $query = "SELECT
                p.id,
                p.notification
            FROM
                " . $this->notification_table_name . " p 
            ORDER BY
                p.id ASC";
    
    // prepare query statement
    $stmt = $this->conn->prepare($query);
 
    // execute query
    $stmt->execute();
 
    return $stmt;
}


#7// read store
function readStore(){
 
    // select all query
    $query = "SELECT
                p.id,
                p.bartercode,
                p.bartername,
                p.description,
                p.barterpicture,
                p.price,
                p.registrationdate
            FROM
                " . $this->store_table_name . " p 
            ORDER BY
                p.id ASC";
    
    // prepare query statement
    $stmt = $this->conn->prepare($query);
 
    // execute query
    $stmt->execute();
 
    return $stmt;
}

#7// read store
function readUserStore($history_username){
 
    // select all query
    $query = "SELECT
                p.id
            FROM
                " . $this->barter_schedule_table_name . " p 
            WHERE p.username='".$history_username."'
            AND p.status='n'
            ORDER BY
                p.id ASC";
    
    // prepare query statement
    $stmt = $this->conn->prepare($query);
 
    // execute query
    $stmt->execute();
 
    return $stmt;
}


 #8// create reg mapping
 function RegisterMapUser($_username){
    
    // query to insert record
    $query = "INSERT INTO
                " . $this->registration_table_name . "
            SET
                username=:username"
                ;
 
    // prepare query
    $stmt = $this->conn->prepare($query);
 

    
    // bind values
    
    $stmt->bindParam(":username", $this->username);

    // execute query
    if($stmt->execute()){
        return true;
    }
 
    return false;
}


#// place barter schedule order
function PlaceBarterOrderSchedule(){
    
    // query to insert record
    $query = "INSERT INTO
                " . $this->barter_schedule_table_name . "
            SET
                orders=:orders, 
                total_price=:total_price, 
                total_weight=:total_weight,                
                username=:username, 
                pickup_location=:pickup_location, 
                pickup_date=:pickup_date,
                pickup_time=:pickup_time, 
                status=:status,
                phone=:phone,
                address=:address,
                landmark=:landmark,
                ppm=:ppm"
                ;
 
    // prepare query
    $stmt = $this->conn->prepare($query);
 

    
    // bind values
    $stmt->bindParam(":orders", $this->orders);
    $stmt->bindParam(":total_price", $this->total_price);
    $stmt->bindParam(":total_weight", $this->total_weight);
    $stmt->bindParam(":username", $this->username);
    $stmt->bindParam(":pickup_location", $this->pickup_location);
    $stmt->bindParam(":pickup_date", $this->pickup_date);
    $stmt->bindParam(":pickup_time", $this->pickup_time);
    $stmt->bindParam(":status", $this->status);

    $stmt->bindParam(":phone", $this->phone);
    $stmt->bindParam(":address", $this->address);
    $stmt->bindParam(":landmark", $this->landmark);
    $stmt->bindParam(":ppm", $this->ppm);

    // execute query
    if($stmt->execute()){
        return true;
    }
 
    return false;
}

//end
}
?>