<?php
$name = $_POST['name'];
$address = $_POST['address'];
$phone = $_POST['phone'];
$message = $_POST['message'];
if(!empty($username) ||!empty($address) ||!empty($phone) ||!empty($message) )
{
  $host= "localhost";
  $dbUsername = "root";
  $dbPassword = "";
  $dbname = "practice";
  $conn = new mysqli($host, $dbUsername, $dbPassword, $dbname);
  if(mysqli_connect_error()){
      die('Connect Error('.mysqli_connect_error().')'.mysqli_connect_error());
  } else {
      $SELECT = "SELECT phone From user Where phone=? Limit 1";
      $INSERT = "INSERT Into user (name,address,phone,message) values(?,?,?,?)";
      $stmt = $conn->prepare($SELECT);
      $stmt->bind_param("s" , $phone);
      $stmt->execute();
      $stmt->bind_result($phone);
      $stmt->store_result();
      $rnum = $stmt->num_rows;
      if($rnum==0){
          $stmt->close();
          $stmt = $conn->prepare($INSERT);
          $stmt->bind_param("ssis", $name, $address, $phone, $message);
          $stmt->execute();
          echo "New record inserted sucessfully";
      } else {
          echo "Someone already register using this email";
      }
      $stmt->close();
      $conn->close();
  }
}else {
    echo "All fields are required";
    die();
}
?>