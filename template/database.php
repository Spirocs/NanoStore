<?php
    $servername = "localhost";
    $username = "root";
    $password = "password";
    $dbname = "nanostore";
  
    // Create connection
    $conn = new mysqli($servername, $username, $password, $dbname);
  
    // Check connection
    if ($conn->connect_error) {
      die("Connection failed: " . $conn->connect_error);
    }

    $get_option = function($option) use ($conn) {
      $stmt = $conn->prepare("SELECT text FROM nanostore WHERE options='". $option. "' limit 1");
      $stmt->execute();
      $result = $stmt->get_result();
      $value = $result->fetch_object();
      return $value->text;
  };
?>