<?php
session_start();
require ("dbcon.php");
// this file contains functions to query data from database and validate it
//input field validation
function validate($inputData){
    global $conn;
    $validatedData = mysqli_real_escape_string( $conn, $inputData );//prevents malicious injection of code
    return trim($validatedData);
}
//redirect from one page to another with a status
function redirect($url, $status){
    $_SESSION['status'] = $status;
    header('Location: '. $url);
    exit(0);
}
//displaying a red warning message after a process
function alertMessage(){
if(isset($_SESSION['status'])){
    echo '<div class="alert alert-warning" role="alert">
        '.$_SESSION['status'].'
        </div>';  
    unset($_SESSION['status']);
}
}
//displaying a green success message
function successMessage(){
    if(isset($_SESSION['status'])){
        echo '<div class="alert alert-success" role="alert">
            '.$_SESSION['status'].'
            </div>';  
        unset($_SESSION['status']);
    }
    }
//insert record using this function
function insert($tableName, $data){
    global $conn;
    $table = validate($tableName);
    $columns = array_keys($data);
    $values = array_values($data);
    $finalColumn = implode(', ', $columns);
    $finalValues = "'". implode("', '", $values) ."'";
    $query = "INSERT INTO $table ($finalColumn) VALUES ($finalValues)";
    $result = mysqli_query($conn, $query);
    return $result;
}

//Update data using this function
function update($tableName, $id,$data){

    global $conn;
    $table = validate($tableName);
    $id = validate( $id );
    $updateDataString = "";
    foreach($data as $column => $value){
        $updateDataString .= $column ."="." '$value' ,";

    }
    $finalUpdateData = substr($updateDataString,0,-1);
    $query = "UPDATE $table SET $finalUpdateData WHERE id='$id'";
    $result = mysqli_query($conn, $query);
    return $result;
}

function getAll($tableName,$status=NULL){
    global $conn;
    $table = validate($tableName);
    $status = validate($status);

    if($status == "status"){
        $query = "SELECT * FROM $table WHERE status='0'";
}else{
         $query = "SELECT * FROM $table";

}
    return mysqli_query($conn, $query);
}

function getById($tableName,$id){
    global $conn;
    $table = validate($tableName);
    $id = validate($id);
    $query = "SELECT * FROM $table WHERE id='$id' LIMIT 1" ;
    $result = mysqli_query($conn, $query);
    if($result){
        if(mysqli_num_rows($result) == 1){
            $row = mysqli_fetch_assoc($result);
            $response = [
                "status"=> 200,
                "data"=> $row,
                "message"=> "Record Found"
               ];
               return $response;
        }else{
            $response = [
                "status"=> 404,
                "message"=> "Oops No data found!"
               ];
               return $response;
        }

    }else{
       $response = [
        "status"=> 500,
        "message"=> "Something went wrong"
       ];
       return $response;
    }

}

//delete data function
function delete($tableName,$id){
    global $conn;
    $table = validate($tableName);
    $id = validate($id);
    $query = "DELETE FROM $table WHERE id='$id' LIMIT 1";
    $result = mysqli_query($conn, $query);
    return $result;

}
// function for checking id parameters used for deleting and updating
function checkParamId($type){
    if(isset($_GET[$type])){
        if($_GET[$type] != ''){
            return $_GET[$type];
        }else{
            return '<h5>No id Found</h5>';
        }
    }else{
        return'<h5>No id given</h5>';
    }
}

//function for logout
function logoutSession(){
    unset($_SESSION['loggedIn']);
    unset($_SESSION['loggedInUser']);
}

//function for json response used in incrementing and decrementing orders
function jsonResponse($status,$status_type, $message){
    $response = [
        'status'=> $status,
        'status_type' => $status_type,
        'message'=> $message,
    ];
    echo json_encode($response);
    return;
}
//function to count all items in the database that will be used in displaying the information to the database.
function getCount($tableName){
    global $conn;
    $table = validate($tableName);
    $user_id = $_SESSION['loggedInUser']['user_id'];
    $query = "SELECT * FROM $table WHERE user_id='$user_id'";
    $query_run = mysqli_query($conn, $query);
    if($query_run){
        $totalCount = mysqli_num_rows($query_run);
        return $totalCount;
    }else{
        return "something is wrong";
    }

}