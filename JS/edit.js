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
      dataType: 'text',
      contentType: 'application/json',
      data: JSON.stringify(editObj),
      success: function (response, status, jqXHR) {
        if (response.success || jqXHR.status === 200 || status === 200) {
          window.location = '/dashboard.php';
        } else {
          alert('Contact Edit Failed!: ' + response.message);
          window.location = '/dashboard.php';
        }
      },
      error: function (error) {
        alert('Contact Edit Error!: ' + error.message);
        window.location = '/dashboard.php';
      },
    });
  });
});
