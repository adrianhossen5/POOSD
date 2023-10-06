$(() => {
  $('#registerForm').submit(function (e) {
    e.preventDefault();

    const email = $('#email').val();
    const user_name = $('#user_name').val();
    const password = $('#password').val();
    const confirm_password = $('#confirm_password').val();

    const registerObj = {
      user_name,
      email,
      password,
      confirm_password,
    };

    $.ajax({
      url: '/API/registerUser.php',
      method: 'POST',
      dataType: 'json',
      contentType: 'application/json',
      data: JSON.stringify(registerObj),
      success: function (response, status, jqXHR) {
        if (response.success || jqXHR.status === 200) {
          window.location = '../index.php';
        } else {
          alert('Registration Failed!:' + response.message);
          window.location = '../register.php';
        }
      },
      error: function (error) {
        alert('Registration Failed!:' + error.message);
        window.location = '../register.php';
      },
    });
  });
});
