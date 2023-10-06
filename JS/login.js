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
      success: function (response, status, jqXHR) {
        if (response.success || jqXHR.status === 200 || status === 200) {
          window.location = '/dashboard.php';
        } else {
          alert('Login failed');
        }
      },
      error: (err) => {
        alert('Login failed');
      },
    });
  });
});
