$(() => {
  $('#loginForm').submit((e) => {
    e.preventDefault();

    const loginData = {
      user_name: $('#user_name').val(),
      password: $('#password').val(),
    };

    $.ajax({
      url: '/API/loginUser.php',
      method: 'POST',
      dataType: 'json',
      contentType: 'application/json',
      data: JSON.stringify(loginData),
      success: function (response) {
        if (response.success) {
          window.location = '/dashboard.php';
        } else if (!response.success) {
          alert('Login failed: ' + response.message);
        } else {
          alert('Login failed!');
        }
      },
      error: () => {
        alert('Login failed!');
      },
    });
  });
});
