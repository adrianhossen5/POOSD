function deleteContact(idToDelete) {
  var delObject = { contact_id: idToDelete };
  $.ajax({
    url: '/API/deleteContact.php',
    method: 'POST',
    dataType: 'json',
    contentType: 'application/json',
    data: JSON.stringify(delObject),
    success: function (response, status, jqXHR) {
      if (response.success || jqXHR.status === 200 || status === 200) {
        window.location = '../dashboard.php';
      } else {
        alert('Contact Delete Failed!');
        window.location = '../dashboard.php';
      }
    },
    error: function (error) {
      alert('Contact Delete Failed!');
      window.location = '../dashboard.php';
    },
  });
}
