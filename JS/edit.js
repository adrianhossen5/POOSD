$(() => {
  $('#editForm').submit(function (e) {
    e.preventDefault();

    const first_name = $('#first_name').val();
    const last_name = $('#last_name').val();
    const email = $('#email').val();
    const phone_number = $('#phone_number').val();
    const id = $('#id').val();

    const editObj = {
      first_name,
      last_name,
      email,
      phone_number,
      id,
    };

    $.ajax({
      url: '/API/editContact.php',
      method: 'POST',
      dataType: 'json',
      contentType: 'application/json',
      data: JSON.stringify(editObj),
      success: function (response) {
        if (response.success) {
          window.location = '/dashboard.php';
        } else if (!response.success) {
          alert('Edit failed: ' + response.message);
        } else {
          alert('Edit failed!');
        }
      },
      error: function (error) {
        alert('Contact Edit Error!');
        window.location = '/dashboard.php';
      },
    });
  });
});
