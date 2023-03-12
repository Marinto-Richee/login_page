$(document).ready(function() {
	// get the current user's username from local storage
	var session_key = localStorage.getItem('session_key');
	// get the user's profile data from MongoDB
	$.ajax({
		url: './php/profile.php',
		type: 'GET',
		data: { session_key: session_key},
		dataType: 'json',
		success: function(data) {
			// populating the username from the database
			if(data.success)
			{
				$('#username').val(data.username);

			}else{
				localStorage.removeItem('session_key');
				window.location.href = './login.html';
			}
		},
		error: function() {
			alert('Failed to get user profile data.');
		}
	});

	// handle form submission
	$('#profile-form').submit(function(event) {
		event.preventDefault();
		var session_key = localStorage.getItem('session_key');
		// get the form data
		var age = $('#age').val();
		var dob = $('#dob').val();
		var contactAddress = $('#contact-address').val();

		// send the updated profile data to MongoDB
		$.ajax({
			url: './php/profile.php',
			type: 'POST',
			data: {
				session_key: session_key,
				username: username,
				age: age,
				dob: dob,
				contactAddress: contactAddress
			},
			success: function() {
				alert('Profile updated successfully.');
			},
			error: function() {
				alert('Failed to update profile.');
			}
		});
	});
});

