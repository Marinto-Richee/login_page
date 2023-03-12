<?php
session_start();
include("./db.php");

$redis = new Redis();
$redis->connect(REDIS_HOST, 6379);

if ($_SERVER['REQUEST_METHOD'] === 'GET') {
  // Handle GET request
  $session_key = $_GET['session_key'];
  $session_value = $redis->get('session:' . $session_key);
  // check if session data is not empty and valid
  if (!empty($session_value)) {
    // update session expiry time
    $redis->expire('session:' . $session_key, 3600);
    $session_data = json_decode($session_value);
    echo json_encode(array('success' => true, 'username' => $session_data->username));
    // session is valid
    
  } else {
    // destroy session
    //$redis->del($session_key);
    echo json_encode(array('success' => false,'message' => 'Session expired.','session_key' => $session_key));
  }  
  
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
  echo json_encode(array('success' => true));
  $session_key = $_POST['session_key'];
}

?>
