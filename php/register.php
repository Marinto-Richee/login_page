<?php
include("./db.php");

// get form data
try {
  $username = $_POST['username'];
  $email = $_POST['email'];
  $password = $_POST['password'];
  $confirm_password = $_POST['confirm_password'];

  $created_at = date("Y-m-d H:i:s");
  $password_hash = password_hash($password, PASSWORD_DEFAULT);

  //Password validation
  $uppercase = preg_match('@[A-Z]@', $password);
  $lowercase = preg_match('@[a-z]@', $password);
  $number    = preg_match('@[0-9]@', $password);

  // validate form data
  if (empty($username) || empty($email) || empty($password) || empty($confirm_password)) {
    $response = array('success' => false, 'message' => 'Please fill in all fields.');
  } elseif ($password != $confirm_password) {
    $response = array('success' => false, 'message' => 'Passwords do not match.');
  } elseif (!$uppercase || !$lowercase || !$number || strlen($password) < 8) {
    $response = array('success' => false, 'message' => 'Use a Valid Password with 8 characters (1 upper case, 1 lower case and 1 numeric character)');
  } else {
    // connect to database
    $conn = new mysqli(DB_HOST, DB_USERNAME, DB_PASSWORD, DB_NAME);

    // prepare query
    $stmt = $conn->prepare('INSERT INTO users (username, email, password,created_at) VALUES (?, ?, ?, ?)');
    $stmt->bind_param('ssss', $username, $email, $password_hash, $created_at);

    // execute query
    if ($stmt->execute()) {
      $response = array('success' => true);
    } else {
      $response = array('success' => false, 'message' => 'Error inserting data into database.');
    }

    // close database connection
    $stmt->close();
    $conn->close();
  }
} catch (mysqli_sql_exception $e) {
  //echo 'Message: ' .$e->getMessage();
  $response = array('success' => false);
  //response = array('success' => 100,'message'=>'Message: ' .$e->getMessage());
}
// send response to client
header('Content-Type: application/json');
echo json_encode($response);
