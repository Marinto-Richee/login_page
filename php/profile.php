<?php
// connect to MongoDB
$mongo = new MongoDB\Driver\Manager('mongodb://localhost:27017');

// get the username from the POST data
$username = $_POST['username'];

// create a query to retrieve the user's profile data from MongoDB
$filter = ['username' => $username];
$options = [];
$query = new MongoDB\Driver\Query($filter, $options);

// execute the query
$cursor = $mongo->executeQuery('test.profile', $query);

// retrieve the user's profile data from the cursor
$userData = $cursor->toArray()[0];

// return the user's profile data as a JSON object
echo json_encode([
	'age' => $userData->age,
	'dob' => $userData->dob,
	'contact_address' => $userData->contact_address
]);
?>