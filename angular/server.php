<?php

header('Access-Control-Allow-Origin: *');
header('Access-Control-Allow-Methods: GET, PUT, POST, DELETE, OPTIONS');
header('Access-Control-Allow-Headers: Origin, Content-Type, X-Auth-Token , Authorization');

var_dump($_FILES);
var_dump($_POST);

$con = mysqli_connect("localhost","root","","angular");

$data = json_decode(file_get_contents('php://input'), true);

if(empty($data)){
   echo json_encode(  'errror');

}


if($data['action'] == 'insert'){

    $sql = "INSERT INTO angular (name, sname)
VALUES ('$data[name]', '$data[sname]')";

    if ($con->query($sql) === TRUE) {
        echo "New record created successfully";
    } else {
        echo "Error: " . $sql . "<br>" . $conn->error;
    }
}
?>