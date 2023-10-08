function formatDatetime(timestamp) {
  const date = new Date(timestamp);
  const options = {
    year: 'numeric',
    month: 'numeric',
    day: 'numeric',
    hour: 'numeric',
    minute: 'numeric',
  };
  const formattedDate = date.toLocaleString(undefined, options);
  const formattedWithoutSeconds = formattedDate.replace(/:\d{2}$/, '');
  return formattedWithoutSeconds;
}

$(() => {
  // Sets the table with the given contacts
  function setTable(contacts) {
    const div = $('#searchDiv').empty();
    div.append(`
    <div class='table-screen'>
      <table id="searchTable" style="margin-bottom: 30px "></table>
    </div>
    `);

    const table = $('#searchTable').empty();

    table.append(`
		<thead style="width:100%">
            <tr>
              <th>Date Created</th>
              <th>First Name</th>
              <th>Last Name</th>
			  <th>Phone Number</th>
              <th>Email</th>
              <th>Edit</th>
			  <th>Delete</th>
            </tr>
          </thead>`);

    Array.from(contacts).forEach((contact) => {
      const formattedTimeCreated = formatDatetime(contact.time_created);
      table.append(`
    		<tr>
        <td>${formattedTimeCreated}</td>
				<td>${contact.first_name}</td>
				<td>${contact.last_name}</td>
				<td>${contact.phone_number}</td>
				<td>${contact.email}</td>
				<td><button class="edit-delete-button" onclick="editContact('${contact.first_name}', '${contact.last_name}', '${contact.phone_number}', '${contact.email}', '${contact.id}')">Edit</button></td>
    			<td><button class="edit-delete-button" onclick="deleteContact('${contact.id}')">Delete</button></td>
    			</tr>
			`);
    });
  }

  $('#searchForm').submit(function (e) {
    e.preventDefault();

    const search = $('#search').val();

    const searchObj = {
      search,
    };
    $.ajax({
      url: '/API/getContacts.php',
      method: 'POST',
      dataType: 'json',
      contentType: 'application/json',
      data: JSON.stringify(searchObj),
      success: function (response) {
        if (response.success) {
          if (response.contacts === false) {
            alert('No Contacts Found!');
            window.location = '/search.php';
          } else {
            setTable(response.contacts);
          }
        } else {
          alert('Contact Search Failed!');
          window.location = '/search.php';
        }
      },
      error: function (error) {
        alert('Contact Search Failed!');
        window.location = '/search.php';
      },
    });
  });
});
