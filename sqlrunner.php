<?php
require '../../config/connect.php';
$DB_ADDRESS= DB_HOST;
$DB_USER=DB_USERNAME;
$DB_PASS=DB_PASS;
$DB_NAME=DB_NAME;
$SQLKEY="sumanmanna";
$myObj = (object)array();
header('Cache-Control: no-cache, must-revalidate');
error_log(print_r($_POST,TRUE));
if( isset($_POST['query']) && isset($_POST['key']) ){
  header('Content-type: text/csv');
  if($_POST['key']==$SQLKEY){ 
    $query=urldecode($_POST['query']);
    $conn = new mysqli($DB_ADDRESS,$DB_USER,$DB_PASS,$DB_NAME);
    if($conn->connect_error){                                                         
      header("HTTP/1.0 400 Bad Request");
      echo "ERROR Database Connection Failed: " . $conn->connect_error, E_USER_ERROR;  
    } else {
      $result= $conn->query($query);                                                   
      if($result === false){
        header("HTTP/1.0 400 Bad Request");                                           
        echo "Wrong SQL: " . $query . " Error: " . $conn->error, E_USER_ERROR;       
      } else {
        $myObj->affected = $conn->affected_rows;
        if($result->num_rows > 0){
         $myObj->result = $result->fetch_all(MYSQLI_ASSOC);
        }
        $myObj->msg = "Success";
        
        print(json_encode($myObj));
      }
      $conn->close();                                        
    }
  } else {
     header("HTTP/1.0 400 Bad Request");
     echo "Bad Request";                                
  }
} else {
        header("HTTP/1.0 400 Bad Request");
        echo "Bad Request";
}
?>