$(document).ready(function () {
  // handle form submission
  $('#signup-form').submit(function (e) {
    e.preventDefault(); 
    // get form data from the user inputs
    var formData = {
      username: $('#username').val(),
      email: $('#email').val(),
      password: $('#password').val(),
      confirm_password: $('#confirm-password').val()
    };



    // send form data to server using ajax
    $.ajax({
      url: './php/register.php',
      type: 'POST',
      data: formData,
      dataType: 'json',
      success: function (response) {
        if (response.success) {
          alert('Signup successful!');
          window.location.href = 'login.html';
        } else {
          alert(response.message);
        }
      },
      error: function () {
        alert('Error submitting form!');
      }
    });

  });

});